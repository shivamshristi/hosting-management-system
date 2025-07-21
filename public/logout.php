<?php
session_start();
require_once __DIR__.'/../classes/User.php';
User::logout();
header('Location: /login.php');
