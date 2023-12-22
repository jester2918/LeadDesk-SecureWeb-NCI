<?php include_once('layout/header.php'); ?>
<?php include_once('layout/nav.php'); ?>
<?php include_once('layout/sideNav.php'); ?>

<?php
if ($_GET["id"] != $_SESSION['Id']) {
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
            });
        </script>
        ';
    } else {
        $errors = '<span class="text text-danger">'.$errors.'</span>';
    }
}

?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper p-0">
        <div class="content-body">
            <div class="card mb-0">
                <div class="card-body">
                    <div id="app-invoice-wrapper" class="">
                        <h3 class="font-weight-bold mb-2">Account <?= $employeeObj != null ? "Edit " : "Add " ?></h3>
                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST"> 
                            <div class="row">
                                <?php if($employeeObj != null){?>
                                    <input type="hidden" class="form-control" name="Id" value="<?= $employeeObj[0]["Id"] ?>" />
                                <?php }?>
                                <div class="col-md-6 mb-2">
                                    <label for="UserFullName">My Name</label>
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
                                <input type="hidden" name="UserTypeId" value="<?= $employeeObj[0]["UserTypeId"]?>">
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