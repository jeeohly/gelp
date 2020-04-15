<?php
session_start();

session_destroy();
header('Location: /cs4640/createAccount.html');  
?>