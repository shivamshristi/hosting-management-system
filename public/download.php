<?php
session_start();
require_once __DIR__.'/../classes/User.php';
User::requireLogin();
$file = basename($_GET['file'] ?? '');
$path = __DIR__.'/../data/'.$file;
if(is_file($path)) {
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="'.$file.'"');
    readfile($path);
    exit;
}
http_response_code(404);
?>
