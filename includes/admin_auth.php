<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/functions.php';
if(!is_logged_in() || !is_admin()){
    flash('error', 'Admin access required.');
    redirect('/agri_rental_full/public/login.php');
}
?>