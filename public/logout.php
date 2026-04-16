<?php
require_once __DIR__ . '/../config/db.php';
session_destroy();
header('Location: /agri_rental_full/public/login.php');
exit;
