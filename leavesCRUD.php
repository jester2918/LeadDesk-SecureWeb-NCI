<?php include_once('layout/header.php'); ?>
<?php

$errors = "";
$employeeObj = null;

$userId = $_SESSION['user']->Id;

$leaveController = new LeaveController();

if (isset($_POST['createLeave'])) {
    $CreateLeave = $leaveController->CreateLeave();
    if ($CreateLeave->success) {
       echo '
        <script>
            $(document).ready(function() { 
                Swal.fire({
                    icon: "success",
                    title: "Leave Applied Successfully",
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
                        <h3 class="font-weight-bold mb-2">Apply Leave</h3>
                        <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST"> 
                            <div class="row">
                                <input type="hidden" class="form-control" name="CompanyId" id="CompanyId" value="<?= $companyId ?>"/>
                                <input type="hidden" class="form-control" name="UserId" id="UserId" value="<?= $userId ?>"/>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="LeaveApplyFrom">From</label>
                                    <input type="date" class="form-control" name="LeaveApplyFrom" id="LeaveApplyFrom"/>
                                </div>
                                
                                <div class="col-md-6 mb-2">
                                    <label for="LeaveApplyTo">To</label>
                                    <input type="date" class="form-control" name="LeaveApplyTo" id="LeaveApplyTo"/>
                                </div>

                                <div class="col-md-12 mb-2">
                                    <label for="LeaveTypeId">Leave Type</label>
                                    <select class="form-control" name="LeaveTypeId" id="LeaveTypeId">
                                        <option selected disable>Please Select</option>
                                        <option value="1">Casual Leave</option>
                                        <option value="2">Sick Leave</option>
                                    </select>
                                </div>
                                <input type="hidden" class="form-control" name="IsHalfDay" id="IsHalfDay" value="1"/>
                                <div class="col-md-12 mb-2">
                                    <label for="LeaveReason">Reason</label>
                                    <textarea class="form-control" name="LeaveReason" rows="6" id="LeaveReason"></textarea>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" name="createLeave">Apply Leave</button>
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