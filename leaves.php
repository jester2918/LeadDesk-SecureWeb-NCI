<?php include_once('layout/header.php'); ?>
<?php include_once('layout/nav.php'); ?>
<?php include_once('layout/sideNav.php'); ?>

<?php
$leaveModel = new LeaveModel();
$leaveList = $leaveModel->GetLeaveByCompanyId($companyId);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title mb-0">Leave List</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item active">Leave List
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="content-header-right col-md-6 col-12 mb-md-0 mb-2 text-right">
                <a type="button" class="btn btn-primary genericMPOpener" href="/leavesCRUD.php">Ask Leave</a>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div id="app-invoice-wrapper" >
                        <table id="leaves" class="table table-striped table-bordered dataTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Employee Name</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Leave Type</th>
                                    <th>Leave Reason</th>
                                    <th>Approved By</th>
                                    <th>No Of Days</th>
                                    <th>Status</th>
                                    <?php if ($_SESSION['userType'] == "admin") {?>
                                        <th>Action</th>
                                    <?php }?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leaveList as $leaves) { ?>
                                    <tr>
                                        <td><?= $leaves['LeaveId'] ?></td>
                                        <td><?= $leaves['EmployeeName'] ?></td>
                                        <td><?= date('Y-m-d', strtotime($leaves['FromDate'])) ?></td>
                                        <td><?= date('Y-m-d', strtotime($leaves['ToDate'])) ?></td>
                                        <td>
                                            <?php if($leaves['LeaveTypeId']==1){?>
                                                Casual Leave
                                            <?php }else if($leaves['LeaveTypeId']==2){?>
                                                Sick Leave
                                            <?php }?>
                                        </td>
                                        <td><?= $leaves['LeaveReason'] ?></td>
                                        <td><?= $leaves['ApprovedBy'] ?></td>
                                        <td><?= date('d', strtotime($leaves['ToDate']) - strtotime($leaves['FromDate']))-1; ?></td>
                                        <td>
                                            <?php if($leaves['IsApproved'] == null && $leaves['IsRejected'] == null){?>
                                                <p class="font-weight-bold" style="color:#db7e06;"> <small><svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none"> <circle cx="12" cy="12" r="8" fill="#db7e06"></circle> </svg> </small>Pending </p>
                                            <?php }else if($leaves['IsApproved'] != null){?>
                                                <p class="font-weight-bold" style="color:#3cb72c;"><small><svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none"> <circle cx="12" cy="12" r="8" fill="#3cb72c"></circle> </svg> </small> Approved</p>
                                            <?php }else if($leaves['IsRejected'] != null){?>
                                                <p class="font-weight-bold" style="color:#e70606;"> <small><svg xmlns="http://www.w3.org/2000/svg" width="18" viewBox="0 0 24 24" fill="none"> <circle cx="12" cy="12" r="8" fill="#e70606"></circle> </svg> </small>Rejected </p> 
                                            <?php }?>
                                        </td>
                                        <?php if ($_SESSION['userType'] == "admin") {?>
                                            <td>
                                                <?php                                     
                                                    if($leaves['IsApproved'] == null && $leaves['IsRejected'] == null){?>
                                                        <div class="d-flex justify-content-start align-items-center" style="gap: 20px;">   
                                                            <a class="approve badge bg-success" data-id="<?=$leaves['LeaveId']?>">
                                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 30 30.000001" height="40" preserveAspectRatio="xMidYMid meet" version="1.0"><defs><clipPath id="id1"><path d="M 2.328125 4.222656 L 27.734375 4.222656 L 27.734375 24.542969 L 2.328125 24.542969 Z M 2.328125 4.222656 " clip-rule="nonzero"/></clipPath></defs><g clip-path="url(#id1)"><path fill="rgb(13.729858%, 12.159729%, 12.548828%)" d="M 27.5 7.53125 L 24.464844 4.542969 C 24.15625 4.238281 23.65625 4.238281 23.347656 4.542969 L 11.035156 16.667969 L 6.824219 12.523438 C 6.527344 12.230469 6 12.230469 5.703125 12.523438 L 2.640625 15.539062 C 2.332031 15.84375 2.332031 16.335938 2.640625 16.640625 L 10.445312 24.324219 C 10.59375 24.472656 10.796875 24.554688 11.007812 24.554688 C 11.214844 24.554688 11.417969 24.472656 11.566406 24.324219 L 27.5 8.632812 C 27.648438 8.488281 27.734375 8.289062 27.734375 8.082031 C 27.734375 7.875 27.648438 7.679688 27.5 7.53125 Z M 27.5 7.53125 " fill-opacity="1" fill-rule="nonzero"/></g></svg>
                                                            </a>
                                                            <a class="reject badge bg-danger" data-id="<?=$leaves['LeaveId']?>">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16"> <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/> </svg>
                                                            </a>
                                                        </div>
                                                    <?php }else{?>
                                                        <p> </p>
                                                <?php }?>
                                            </td>
                                        <?php }?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.approve').click(function() {
        var el = this;
        var id = $(el).data('id');
        var userId = <?= $_SESSION['user']->Id ?>;
        var confirmalert = confirm("Are you sure?");
        if (confirmalert == true) {
            $.ajax({
                url: '/api/index.php/leave/Approved',
                type: 'GET',
                headers: {
                    "Authorization": "Bearer <?= $_SESSION["user"]->token ?>"
                },
                data: {
                    id: id,
                    userId:userId
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Leave Approved',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 1000); 
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
    $('.reject').click(function() {
        var el = this;
        var id = $(el).data('id');
        var confirmalert = confirm("Are you sure?");
        if (confirmalert == true) {
            $.ajax({
                url: '/api/index.php/leave/Rejected',
                type: 'GET',
                headers: {
                    "Authorization": "Bearer <?= $_SESSION["user"]->token ?>"
                },
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Leave Rejected',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        setTimeout(function(){
                            location.reload();
                        }, 1000); 
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });

    $(document).ready(function() {
        $("#leaves").DataTable();
    });

    $(document).ready(function() {
        $("#employee").DataTable();
        $(document).on('click', '.genericMPOpener', function (e) {
            e.preventDefault();
            var that = $(this);
            if (!$(this).hasClass('MpAdded')) {
                $(this).addClass('MpAdded');
                $(this).magnificPopup({
                    type: 'iframe',
                    closeOnContentClick: !that.hasClass('bgNoClose'),
                    modal: that.hasClass('bgNoClose'),
                    closeBtnInside: false,
                }).magnificPopup('open');
            } else {
                $(this).magnificPopup('open');
            }
        });
    });
</script>
<?php include_once('layout/footer.php'); ?>