<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/functions.php';
if(!is_logged_in()){
    flash('error', 'Please log in first.');
    redirect('/agri_rental_full/public/login.php');
}
?>