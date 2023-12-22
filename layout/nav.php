<nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="feather icon-menu font-large-1"></i></a></li>
                <li class="nav-item mr-auto"><a class="navbar-brand" href="index.php">
                    <img class="brand-logo" alt="stack admin logo" src="../../../app-assets/images/logo/logo-light.png" style="width: 100%;">
                    </a></li>
                <li class="nav-item d-lg-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                
                <div class="nav navbar-nav mr-auto float-left">
                    <p class="mb-0" id="changeCompany" data-id="<?= $companyId ?>"><?= $comapnyName ?></p>
                </div>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <div class="avatar avatar-online"><img src="../../../app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"></div><span class="user-name"><?= $_SESSION['user']->UserFullName ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="editAccount.php?id=<?= $_SESSION["Id"]?>">
                                <i class="feather icon-user"></i> Edit Profile
                            </a>
                            <a class="dropdown-item" href="/taskBoard.php">
                                <i class="feather icon-check-square"></i> Task
                            </a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="/auth-logout.php"><i class="feather icon-power"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>