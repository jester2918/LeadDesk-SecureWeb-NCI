<?php include_once('layout/header.php'); ?>

<?php
$errors = "";
if (isset($_POST['login'])) {
   $UserController = new AccountController();
   $userLogin = $UserController->Login();
   if ($userLogin->success) {
      
      $_SESSION["loggedin"] = true;
      $_SESSION["Id"] = $userLogin->Id;
      $companyModel = new CompanyModel();
      $_SESSION["CompanyId"] = $userLogin->CompanyId;
      $_SESSION["user"] = $userLogin;
      $_SESSION["userType"] = $userLogin->UserType;
      header('location:/index.php');
   }
   else {
      $errors = join(", ", $userLogin->message);
   }  
}
?>
<style>
   body{
      background: #000428; 
      background: -webkit-linear-gradient(to right, #004e92, #000428);  
      background: linear-gradient(to right, #004e92, #000428);
   }
</style>
<div class="container">
   <section class="row py-5 my-5">
      <div class="col-12 d-flex align-items-center justify-content-center">
         <div class="col-lg-6 col-md-6 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
               <div class="card-header border-0 pb-0">
                  <div class="card-title text-center">
                     <img src="../../../app-assets/images/logo/stack-logo-dark.png" alt="branding logo" style="width: 50%;">
                  </div>
                  <div>
                     <h3 class="mt-2 font-weight-bold text-center">Sign In</h3>
                     <p class="text-center text-secondary">Log in to your account to continue</p>
                     <?php 
                        if($errors != ""){
                           echo '<div class="alert alert-danger mb-0">'.$errors.'</div>';
                        }
                     ?>
                  </div>
               </div>
               <div class="card-content">
                  <div class="card-body">
                     <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <fieldset class="form-group position-relative has-icon-left">
                           <input type="number" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Your Username" required>
                           <div class="form-control-position">
                              <i class="feather icon-user"></i>
                           </div>
                        </fieldset>
                        <fieldset class="form-group position-relative has-icon-left">
                           <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                           <div class="form-control-position">
                              <i class="fa fa-key"></i>
                           </div>
                        </fieldset>
                        <button type="submit" class="btn btn-primary btn-block" name="login"><i class="feather icon-unlock"></i> Login</button>
                     </form>
                  </div>

               </div>
            </div>
         </div>
      </div>
   </section>
</div>

<?php include_once('layout/footerLinks.php'); ?>