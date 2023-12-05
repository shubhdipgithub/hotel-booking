<?php 
    session_start();
    $_SESSION['admin_username']='';
    session_destroy();
    header('Location: ../../yashams/index.php');
?>