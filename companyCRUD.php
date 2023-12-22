<?php include_once('layout/header.php'); ?>

<?php

if ($_SESSION['userType'] == "employee") {
    echo '<script>window.location.href = "/index.php";</script>';
    exit();
}

$companyObj = null;
$companyModel = new CompanyModel();
$userId = $_SESSION['user']->Id;
$companyController = new CompanyController();

if (isset($_POST["companyAdd"])) {
    $companyAdd = $companyController->CreateCompany();
    if($companyAdd->success){
        echo '
        <script>
            $(document).ready(function() { 
                Swal.fire({
                    icon: "success",
                    title: "Company Created Successfully",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function(){
                    parent.location.reload(); $(".mfp-close", window.parent.document).click();
                }, 2000);
            });
        </script>
        ';
    }
}
if (isset($_GET["id"])) {
    $companyObj = $companyModel->GetCompanyById($_GET["id"]);
}
if (isset($_POST["companyUpdate"])) {
    $companyUpdate = $companyController->UpdateCompany();
    if($companyUpdate->success){
        echo '
            <script>
                $(document).ready(function() { 
                    Swal.fire({
                        icon: "success",
                        title: "Company Updated Successfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function(){
                        parent.location.reload(); $(".mfp-close", window.parent.document).click();
                    }, 2000);
                });
            </script>
        ';
    }
}
?>
<style>
    html body.fixed-navbar{ background-color:white;padding: 0; }
    .card{box-shadow:none}
    footer{ display: none; }
</style>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper p-0">
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div id="app-invoice-wrapper" class="">
                        <h2 class="font-weight-bold pt-2 mb-2">Company <?= $companyObj != null ? "Edit " : "Add " ?></h2>
                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                            <?php if ($companyObj != null) { ?>
                                <input type="hidden" name="Id" value="<?= $companyObj["Id"] ?>" />
                            <?php } ?>
                            <input type="hidden" value="<?= $userId ?>" name="PortalUserId">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="CompanyName">Company Name</label>
                                    <input type="text" class="form-control" placeholder="Enter name" value="<?= $companyObj != null ? $companyObj["CompanyName"] : "" ?>" id="companyname" name="CompanyName" required />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="CompanyName">Company Phone Number</label>
                                    <input type="number" class="form-control" placeholder="Enter phonenumber" value="<?= $companyObj != null ? $companyObj["PhoneNumber"] : "" ?>" id="phonenumber" name="PhoneNumber" required />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="CompanyName">Company Address</label>
                                    <input type="text" class="form-control" placeholder="Enter address" value="<?= $companyObj != null ? $companyObj["Address"] : "" ?>" id="address" name="Address" />
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary submit" name="<?= $companyObj != null ? "companyUpdate" : "companyAdd" ?>"><?= $companyObj != null ? "Update" : "Add" ?> Company</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layout/footer.php'); ?>