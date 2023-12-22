<?php include_once('layout/header.php'); ?>
<?php

if ($_SESSION['userType'] == "employee") {
    echo '<script>window.location.href = "/index.php";</script>';
    exit();
}


$errors = "";
$employeeObj = null;

$userId = $_SESSION['user']->Id;
$DepartmentModel = new DepartmentModel();
$departmentList = $DepartmentModel->GetDepartmentByCompanyId($companyId);

$companyModel = new CompanyModel();
$companyList = $companyModel->GetAllCompanies();

$gender_Array = array("Male","Female","Other");
$AccountController = new AccountController();

if (isset($_GET["id"])) {
    $AccountModel = new AccountModel();
    $employeeObj = $AccountModel->GetEmployeeById($_GET["id"]);
}
if (isset($_POST['createEmpolyee'])) {
    $CreateEmployee = $AccountController->Register();
    if ($CreateEmployee->success) {
       echo '
        <script>
            $(document).ready(function() { 
                Swal.fire({
                    icon: "success",
                    title: "Employee Created Successfully",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function(){
                    parent.location.reload(); $(".mfp-close", window.parent.document).click();
                }, 2000);
            });
        </script>
        ';
    } else {
        $errors = '<span class="text text-danger">'.$errors.'</span>';
    }
}
if (isset($_POST["updateEmpolyee"])) {
    $CreateEmployee = $AccountController->updateEmployee();
    if ($CreateEmployee->success) {
       echo '
        <script>
            $(document).ready(function() { 
                Swal.fire({
                    icon: "success",
                    title: "Employee Updated Successfully",
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function(){
                    parent.location.reload(); $(".mfp-close", window.parent.document).click();
                }, 2000);
            });
        </script>
        ';
    } else {
        $errors = '<span class="text text-danger">'.$errors.'</span>';
    }
}

?>
<style>
    .navbar{ display: none; }
    html body.fixed-navbar{background-color:white !important; padding: 0 !important;  }
    .card{box-shadow:none}
    footer{ display: none; }
</style>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper p-0">
        <div class="content-body">
            <div class="card mb-0">
                <div class="card-body">
                    <div id="app-invoice-wrapper" class="">
                        <h3 class="font-weight-bold mb-2">Employee <?= $employeeObj != null ? "Edit " : "Add " ?></h3>
                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST"> 
                            <div class="row">
                                <?php if($employeeObj != null){?>
                                    <input type="hidden" class="form-control" name="Id" value="<?= $employeeObj[0]["Id"] ?>" />
                                <?php }?>
                                <div class="col-md-6 mb-2">
                                    <label for="UserFullName">User FullName</label>
                                    <input type="text" class="form-control" name="fullName" placeholder="Enter name" id="UserFullName" value="<?= $employeeObj != null ? $employeeObj[0]["FullName"] : "" ?>" />
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" placeholder="Enter Email" id="Email"  value="<?= $employeeObj != null ? $employeeObj[0]["Email"] : "" ?>" />
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="phoneNumber">Phone Number</label>
                                    <input type="text" class="form-control" name="phoneNumber" placeholder="Enter PhoneNumber" id="PhoneNumber"  value="<?= $employeeObj != null ? $employeeObj[0]["ContactNo"] : "" ?>" />
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" name="password" placeholder="Enter password" id="Password"  value="<?= $employeeObj != null ? $employeeObj[0]["Password"] : "" ?>" />
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label for="Gender">Gender</label>
                                    <select class="form-control" name="gender" id="Gender">
                                        <?php 
                                            $gender_HTML = '<option selected disable>Please Select</option>';
                                            foreach($gender_Array as $item){ 
                                                $optionSelected = '';
                                                if($employeeObj != null && $employeeObj[0]["Gender"] == $item){ $optionSelected = 'selected'; }
                                                $gender_HTML .= '<option value="'.$item.'" '.$optionSelected.'>'.$item.'</option>';
                                            }
                                            echo $gender_HTML;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="DepartmentId">Department</label>
                                    <select class="form-control" name="DepartmentId" id="DepartmentId">
                                        <option selected disable>Please Select</option>
                                        <?php foreach($departmentList as $item){ 
                                            $selectedDepart  = '';
                                            if($employeeObj != null && $employeeObj[0]["DepartmentId"] == $item["Id"]){ $selectedDepart  = 'selected'; }    
                                        ?>
                                            <option value="<?= $item["Id"] ?>" <?= $selectedDepart ?>><?= $item["DepartmentName"] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="companyName">Company</label>
                                    <select class="form-control" name="companyName" id="companyName">
                                        <option selected disable>Please Select</option>
                                        <?php foreach($companyList as $item){ 
                                            $selectedCompany  = '';
                                            if($employeeObj != null && $employeeObj[0]["OrganizationId"] == $item["Id"]){ $selectedCompany  = 'selected'; }    
                                        ?>
                                            <option value="<?= $item["Id"] ?>" <?= $selectedCompany ?>><?= $item["CompanyName"] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-md-2 mb-2">
                                    <label for="isAdmin" class="col-6 px-0">Is Admin</label>
                                    <input type="radio" name="UserTypeId" id="isAdmin" class="form-control" <?= $employeeObj != null && $employeeObj[0]["UserTypeId"] == 0 ? "checked":"" ?> value="0" style="height: 22px;width: 22px;" />
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label for="isEmployee" class="col-6 px-0">Is Employee</label>
                                    <input type="radio" name="UserTypeId" id="isEmployee" class="form-control" <?= $employeeObj != null && $employeeObj[0]["UserTypeId"] == 1 ? "checked":"" ?> value="1" style="height: 22px;width: 22px;" />
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" name="<?= $employeeObj != null ? "updateEmpolyee" : "createEmpolyee" ?>"><?= $employeeObj != null ? "Update" : "Add" ?> employee</button>
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