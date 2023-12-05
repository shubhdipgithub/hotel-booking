<?php 

session_start();

function checkUser(){
    if(empty($_SESSION['admin_username'])){
        header("Location: ../login.php");
    }
}
?>