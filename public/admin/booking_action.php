<?php
require_once __DIR__ . '/../../includes/admin_auth.php';
require_once __DIR__ . '/../../includes/functions.php';

$id = (int)($_GET['id'] ?? 0);
$act = $_GET['act'] ?? '';

if(!$id || !in_array($act, ['approve','reject'])){
    flash('error','Invalid request.');
    redirect('/agri_rental_full/public/admin/bookings.php');
}

$status = $act === 'approve' ? 'approved' : 'rejected';

// Before approving, ensure no overlap with other approved bookings if status is approve
if($status==='approved'){
    $stmt = $conn->prepare("SELECT equipment_id, start_date, end_date FROM bookings WHERE id=?");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $bk = $stmt->get_result()->fetch_assoc();
    if(!$bk){
        flash('error','Booking not found.');
        redirect('/agri_rental_full/public/admin/bookings.php');
    }
    if(overlap_exists($conn, $bk['equipment_id'], $bk['start_date'], $bk['end_date'], $id)){
        flash('error','Cannot approve due to overlapping booking.');
        redirect('/agri_rental_full/public/admin/bookings.php');
    }
}

$stmt = $conn->prepare("UPDATE bookings SET status=? WHERE id=?");
$stmt->bind_param('si', $status, $id);
$stmt->execute();

flash('success','Booking '.$status.'.');
redirect('/agri_rental_full/public/admin/bookings.php');
