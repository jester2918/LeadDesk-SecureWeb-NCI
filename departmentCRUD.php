<?php include_once('layout/header.php'); ?>
<?php
if ($_SESSION['userType'] == "employee") {
    echo '<script>window.location.href = "/index.php";</script>';
    exit();
}

$departmentObj = null;
$departmentController = new DepartmentController();
$departmentModel = new DepartmentModel();

$departmentList = $departmentModel->GetDepartmentByCompanyId($companyId);

if (isset($_GET["id"])) {
    $departmentObj = $departmentModel->GetDepartmentById($_GET["id"]);
}
if (isset($_POST["deparmentAdd"])) {
    $deparmentAdd = $departmentController->CreateDepartment();
    if($deparmentAdd->success){
        echo '<script> $(document).ready(function() { Swal.fire({ icon: "success", title: "Department Created Successfully", showConfirmButton: false, timer: 1500 }); setTimeout(function(){ parent.location.reload(); $(".mfp-close", window.parent.document).click(); }, 2000); }); </script> ';
    }
}
if (isset($_POST["departmentUpdate"])) {
    $deparmentUpdate = $departmentController->UpdateDepartment();
    if($deparmentUpdate->success){
        echo '<script> $(document).ready(function() { Swal.fire({ icon: "success", title: "Department Updated Successfully", showConfirmButton: false, timer: 1500 }); setTimeout(function(){ parent.location.reload(); $(".mfp-close", window.parent.document).click(); }, 2000); }); </script> ';
    }
}
?>
<style>
    .navbar{ display: none; }
    html body.fixed-navbar{ background-color:white;padding: 0; }
    .card{box-shadow:none}
    footer{ display: none; }
</style>

<script>
    $(function(){
        $('.mfp-iframe-scaler', window.parent.document).css('height', ($('.content-body').height() + 20) + 'px');
    })
</script>

<div class="content-body">
    <div class="card">
        <div class="card-body">
            <div id="app-invoice-wrapper" class="">
                <h2 class="font-weight-bold pt-2 mb-2">Department <?= $departmentObj != null ? "Edit " : "Add " ?></h2>
                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
                        <input type="hidden" class="form-control" value="<?= $companyId ?>" name="CompanyId" />
                        <?php if ($departmentObj != null) { ?>
                            <input type="hidden" name="Id" value="<?= $departmentObj["Id"] ?>" />
                        <?php } ?>
                        <div class="col-md-12 mb-2">
                            <label for="pid">Parent Department</label>
                            <select class="form-control" name="pid" id="pid">
                                <option value="0" selected disabled>Parent</option>
                                <?php foreach($departmentList as $departments){ ?>
                                    <option value="<?=$departments['Id']?>" <?=  $departmentObj != null &&  $departments['Id'] == $departmentObj["pid"] ? "selected" : "" ?>><?=$departments['DepartmentName'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-12 mb-2">
                            <label for="CompanyName">Department Name</label>
                            <input type="text" class="form-control" placeholder="Enter name" id="DepartmentName" value="<?= $departmentObj != null ? $departmentObj["DepartmentName"] : "" ?>" name="DepartmentName"  />
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary" name="<?= $departmentObj != null ? "departmentUpdate" : "deparmentAdd" ?>"><?= $departmentObj != null ? "Update" : "Add" ?> department</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once('layout/footer.php'); ?>