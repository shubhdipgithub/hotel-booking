<?php 
    session_start();
    $_SESSION['customer_id']='';
    $_SESSION['customer_email']='';
    session_destroy();
    header('Location: ../../yashams/index.php');
?>