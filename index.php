<?php include_once('layout/header.php'); ?>
<?php include_once('layout/nav.php'); ?>
<?php include_once('layout/sideNav.php'); ?>
<?php

$accountModel = new AccountModel();
$employeeList = $accountModel->GetEmployeeByCompanyId($companyId);

$taskModel = new TaskModel();
$taskList = $taskModel->GetRelatedToMeTaskList($_SESSION["Id"]);

$userId = $_SESSION['user']->Id;

$DepartmentModel = new DepartmentModel();
$departmentList = $DepartmentModel->GetDepartmentByCompanyId($companyId);
?>

<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="row match-height">
                <div class="col-xl-8 col-lg-12">
                    <div class="card active-users">
                        <div class="card-header border-0">
                            <h4 class="card-title">Employees</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        </div>
                        <div class="card-content">
                            <div id="audience-list-scroll" class="table-responsive position-relative">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Phone Number</th>
                                            <th>Create Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($employeeList as $employees) { 
                                                if($userId != $employees['Id']){ ?>
                                                <tr>
                                                    <td><?= $employees['Id'] ?></td>
                                                    <td><?= $employees['FullName'] ?></td>
                                                    <td>
                                                    <?php foreach($departmentList as $item){ 
                                                        if($employees["DepartmentId"] == $item["Id"]){   
                                                    ?>
                                                        <?= $item["DepartmentName"] ?>
                                                    <?php } }?>
                                                    </td>
                                                    <td><?= $employees['ContactNo'] ?></td>
                                                    <td><?= $employees['CreatedAt'] ?></td>
                                                </tr>
                                        <?php }}?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-12">
                    <div class="card">
                        <div class="card-header border-0">
                            <h4 class="card-title">Urgent Tasks</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <div class="widget-timeline">
                                    <ul>
                                        <?php 
                                        if(count($taskList) > 0){ foreach ($taskList as $taks) { ?>
                                            <li class="timeline-items timeline-icon-danger">
                                                <p class="timeline-time"><?= $taks['DueDate'] ?></p>
                                                <div class="timeline-title"><?= $taks['Title'] ?></div>
                                                <div class="timeline-subtitle"><?= $taks['Description'] ?></div>
                                            </li>
                                        <?php }} else{?>
                                            <p>No new Task Available</p>
                                        <?php }?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row minimal-modern-charts d-none">

                <!-- region stats chart -->
                <div class="col-xxl-3 col-xl-4 col-lg-4 col-md-6 col-12 region-stats-chart">
                    <div class="card statistic-card">
                        <div class="card-content">
                            <div class="top-row statistics-card-title border-bottom-blue-grey border-bottom-lighten-5">
                                <div class="py-1 pl-2 primary">
                                    <span class="mb-1">Region Statistics</span>
                                </div>
                            </div>
                            <div class="statistics-chart d-flex justify-content-center align-self-center">
                                <div id="tasks_pie_donut"></div>
                            </div>
                            <div class="statistics-chart-data d-flex justify-content-center ml-auto mr-auto pb-50 mb-2">
                                <div class="collection mr-1">
                                    <span class="bullet bullet-xs bullet-warning"></span>
                                    <span class="font-weight-bold">26%</span>
                                </div>
                                <div class="collection mr-1">
                                    <span class="bullet bullet-xs bullet-danger"></span>
                                    <span class="font-weight-bold">44%</span>
                                </div>
                                <div class="collection mr-1">
                                    <span class="bullet bullet-xs bullet-primary"></span>
                                    <span class="font-weight-bold">28%</span>
                                </div>
                            </div>
                            <div class="statistic-card-footer d-flex">
                                <div class="column-data py-1 text-center border-top-blue-grey border-top-lighten-5 flex-grow-1 text-center border-right-blue-grey border-right-lighten-5">
                                    <p class="font-large-1 mb-0">$6.9k</p>
                                    <span>Revenue</span>
                                </div>
                                <div class="column-data py-1 flex-grow-1 text-center border-top-blue-grey border-top-lighten-5">
                                    <p class="font-large-1 mb-0">25</p>
                                    <span>Sales</span>
                                </div>
                                <div class="column-data py-1 flex-grow-1 text-center border-top-blue-grey border-top-lighten-5 border-left-blue-grey border-left-lighten-5">
                                    <p class="font-large-1 mb-0">11</p>
                                    <span>Products</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xxl-9 col-xl-8 col-lg-8 col-md-12 col-12 power-consumption-stats-chart">
                    <div class="card">
                        <div class="card-content pt-2 px-1">
                            <div class="row">
                                <div class="col-8 d-flex">
                                    <div class="ml-1">
                                        <h4 class="power-consumption-stats-title text-bold-500">Power consumption</h4>
                                    </div>
                                    <div class="ml-50 mr-50">
                                        <p>(kWh/100km)</p>
                                    </div>
                                </div>
                                <div class="col-4 d-flex justify-content-end pr-3">
                                    <div class="dark-text">
                                        <h5 class="power-consumption-active-tab text-bold-500">Week</h5>
                                    </div>
                                    <div class="light-text ml-2">
                                        <h5>Month</h5>
                                    </div>
                                </div>
                            </div>
                            <div id="column-basic-chart"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?php include_once('layout/footer.php'); ?>