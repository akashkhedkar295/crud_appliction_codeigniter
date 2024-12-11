<?= $this->extend('tmplates\Main');?>
<?= $this->section('login')?>

<div class= "card contener-form shadow  p-5 pb-3 pt-3">
    <div class="header text-center pb-3 pt-4">
        <h2>Login Now</h2>
    </div>
    <?php
    if(!empty(session()->getFlashdata('fail'))) : ?>
    <div class="alert alert-danger"><?php echo session()->getFlashdata('fail');?></div>
    <?php endif ?>
    <?php if($error){
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"
                    .print_r($error)
                     ."<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        }?>
    <form class="needs-validation" method="post" action="<?= base_url('login')?>" novalidate>
  <?= csrf_field(); ?>
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" name="email" class="form-control" id="validationCustom01" aria-describedby="emailHelp" value="<?= set_value('email')?>" >
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="validationCustom02"name="password" >
  </div>

  <button type="submit" class="btn btn-dark">Submit</button>
  <hr class="mt-3">
  <div class="signup-link pt-1 pb-3">
    <p>Not registered <a href="<?php echo base_url("signup");?>" class="btn-link">Create Account</a></p>
  </div>
</form>
</div>
<?= $this->endSection()?>
