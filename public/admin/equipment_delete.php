<?php
require_once __DIR__ . '/../../includes/admin_auth.php';

$id = (int)($_GET['id'] ?? 0);
// delete image file if exists
$stmt = $conn->prepare("SELECT image FROM equipment WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
if($res && $res['image']){
    $path = __DIR__ . '/../../' . $res['image'];
    if(is_file($path)) { @unlink($path); }
}
$stmt = $conn->prepare("DELETE FROM equipment WHERE id=?");
$stmt->bind_param('i',$id);
$stmt->execute();

flash('success','Equipment deleted.');
header('Location: /agri_rental_full/public/admin/equipment_list.php');
exit;
