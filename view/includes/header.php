<?php
require_once('user-session.php');
// enregistrement de la page actuelle
$path = "/test";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Livret Scolaire</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Statistique -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Favicons -->
    <link href="<?= $path ?>/view/assets/img/favicon.png" rel="icon">
    <link href="<?= $path ?>/view/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?= $path ?>/view/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $path ?>/view/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= $path ?>/view/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?= $path ?>/view/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?= $path ?>/view/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?= $path ?>/view/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?= $path ?>/view/assets/vendor/datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= $path ?>/view/assets/css/style.css" rel="stylesheet">

</head>

<body>