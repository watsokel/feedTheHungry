<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
header('Content-Type: text/html; charset=utf-8');
include 'dbpass.php';
ini_set('session.save_path', '../sessionSaver');
session_start();
session_unset();
session_destroy();
header('Location: index.php');
?>