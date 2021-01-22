<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="assets/images/logo.png" type="image/x-icon">
    <title>Endeavour Technologies</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="assets/fonts/all.css">
    
    <!-- AdminLTE Styles -->
    <link rel="stylesheet" type="text/css" href="assets/styles/adminlte.min.css">
    <link rel="stylesheet" type="text/css" href="assets/styles/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="assets/styles/toastr.min.css">
    <link rel="stylesheet" type ="text/css" media="print" href="assets/styles/print.css">

</head>

<?php

    require_once 'init.php';
    $security = new Security();
    $create = new Create();
    $read = new Read();
    $update = new Update();
    $delete = new Delete();

?>