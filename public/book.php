<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

$equipment_id = (int)($_POST['equipment_id'] ?? 0);
$start_date = $_POST['start_date'] ?? '';
$end_date = $_POST['end_date'] ?? '';

if(!$equipment_id || !$start_date || !$end_date){
    flash('error','All fields are required.');
    redirect('/agri_rental_full/public/');
}

// Validate date order
if(strtotime($end_date) < strtotime($start_date)){
    flash('error','End date cannot be before start date.');
    redirect('/agri_rental_full/public/equipment.php?id='.$equipment_id);
}

// Load equipment price
$stmt = $conn->prepare("SELECT price_per_day FROM equipment WHERE id=?");
$stmt->bind_param('i',$equipment_id);
$stmt->execute();
$res = $stmt->get_result();
if(!$eq = $res->fetch_assoc()){
    flash('error','Invalid equipment.');
    redirect('/agri_rental_full/public/');
}

if(overlap_exists($conn, $equipment_id, $start_date, $end_date)){
    flash('error','Selected dates are not available for this equipment.');
    redirect('/agri_rental_full/public/equipment.php?id='.$equipment_id);
}

$total_days = days_between($start_date, $end_date);
$total_price = $total_days * (float)$eq['price_per_day'];

$status = 'pending';
$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("INSERT INTO bookings(user_id, equipment_id, start_date, end_date, total_price, status) VALUES (?,?,?,?,?,?)");
$stmt->bind_param('iissds', $user_id, $equipment_id, $start_date, $end_date, $total_price, $status);
if($stmt->execute()){
    flash('success','Booking placed successfully. Awaiting approval.');
    redirect('/agri_rental_full/public/history.php');
}else{
    flash('error','Failed to place booking.');
    redirect('/agri_rental_full/public/equipment.php?id='.$equipment_id);
}
