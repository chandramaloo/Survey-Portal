<?php
include('config.php');
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
$user_check=$_SESSION['login_user'];
$ses_sql=pg_query($db,"select userid from users where userid='$user_check' ");

$row=pg_fetch_row($ses_sql);

$login_session=$row[0];

if(!isset($login_session))
{
	header("Location: login.php");
}
?>