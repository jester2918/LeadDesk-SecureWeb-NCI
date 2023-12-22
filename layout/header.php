<?php
session_start();
require __DIR__ . "/../inc/session.php";
require __DIR__ . "/../inc/bootstrap.php";
require __DIR__ . "/../inc/bootstrap_controller.php";
?>

<?php 
if(isset($_SESSION['user'])){
    $companyModel = new CompanyModel();
    $companyId = $_SESSION["CompanyId"];
    $company = $companyModel->GetCompanyById($companyId);
    $comapnyName = $company['CompanyName'];
}
?>

<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    
    <title>Lead Desk</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/jkanban/jkanban.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/pickers/pickadate/pickadate.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/pickers/daterange/daterangepicker.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/selects/select2.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/forms/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/dragula.min.css">

    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">

    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/datatables.min.css">
    
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/fonts/simple-line-icons/style.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/card-statistics.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/vertical-timeline.css">

    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/app-kanban.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/app-todo.css">

    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.14/sweetalert2.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.6.14/sweetalert2.min.js"></script>

    <script defer src="/app-assets/vendors/js/maginificpopup/jquery.magnific-popup.min.js"></script>
    <link rel="stylesheet" href="/app-assets/css/pages/magnific-popup.min.css" />

    

    <script>
        var authToken = null;
        var authTokenUserId = null;
        <?php if(isset($_SESSION["user"])){ ?>
            authToken = "Bearer <?= $_SESSION["user"]->token ?>";
        <?php } ?>
    </script>

</head> 

<style>
    table.dataTable.no-footer { border-bottom-color: #E6E6E6; }
</style>
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   fixed-navbar" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">