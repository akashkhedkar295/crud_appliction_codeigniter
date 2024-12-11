<?= $this->extend('tmplates\Main');?>
<?= $this->section('signup');?>
<div class= "card contener-form-signup shadow  p-5 pb-3 pt-3">
    <div class="header text-center pb-3 pt-4">
        <h2>Register Now</h2>
    </div>
    <?php if($error){
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"
                    .$error['email']
                     ."<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }?>
        
<form class="needs-validation" method='post' novalidate>
<div class="mb-3">
    <label for="exampleInputName" class="form-label">Full Name</label>
    <input type="uname" name="fname" class="form-control" id="validationCustom01" aria-describedby="emailHelp" placeholder="Enter your name" require>
  </div>
  <div class="mb-3">
    <label for="exampleInputEmail1"  class="form-label">Email address</label>
    <input type="email" name="email" class="form-control"  id="validationCustom01" aria-describedby="emailHelp" placeholder="abc@gmail.com" require>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Date of Birth</label>
    <input type="date" name="bdate" name="password" class="form-control" id="validationCustom01" require>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" name="password" class="form-control" id="validationCustom01" placeholder="Password" require>
  </div>
  
  <div class="mb-3">
    <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
    <input type="password"  name="cpassword" class="form-control" id="validationCustom01" placeholder="Confirm Password" require>
  </div>
  <button type="submit" class="btn btn-dark">Submit</button>
  <hr class="mt-3">
  <div class="signup-link pt-1 pb-3">
    <p>Already have <a href="<?php echo base_url("login") ?>" class="btn-link"> Account Login</a></p>
  </div>
</form>
</div>
<?= $this->endSection();?>