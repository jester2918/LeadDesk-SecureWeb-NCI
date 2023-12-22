<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" navigation-header"><span>General</span><i class=" feather icon-minus" data-toggle="tooltip" data-placement="right" data-original-title="General"></i>
            </li>
            <li class=" nav-item"><a href="/index.php"><i class="feather icon-home"></i><span class="menu-title">Dashboard</span></a></li>
            <li class="nav-item"><a href="taskBoard.php"><i class="feather icon-monitor"></i><span class="menu-title">Tasks</span></a></li>
            <li class="nav-item"><a href="leaves.php"><i class="fa fa-calendar"></i><span class="menu-title">Leaves</span></a></li>
            <?php if( $_SESSION["userType"] == 'admin' ){?>
                <li><a class="nav-item" href="company.php"><i class="fa fa-building-o"></i> Company List</a> </li>
                <li><a class="nav-item" href="department.php"><i class="fa fa-users"></i> department List</a> </li>
                <li><a class="nav-item" href="employee.php"><i class="fa fa-user"></i> Employee List</a> </li>
            <?php }?>
        </ul>
    </div>
</div>