
      <form class="card px-5 py-5 needs-validation" method="post" action="<?= base_url('/UserTable')?>" novalidate>
        <div class="hede pb-4 text-center">
          <h3>Add Employees Details<Embed></Embed></h3>
        </div>
        <?php 
  if($error){
          echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>"
                    .$error['email']
                    ."<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";

  }
?> 
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label" name='f_name'
            >Full Name</label>
          <input
            type="text"
            class="form-control"
            name="f_name"
            id="validationCustom01"
            aria-describedby="f_name"
            placeholder="Enter Employee Name"
            required
          />
          
          <div class="invalid-feedback">Enter valid Name</div>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail" class="form-label" name='email'>Email</label>
          <input
            type="email"
            name="email"
            class="form-control"
            id="exampleInputEmail1"
            placeholder="abcd123@gmail.com"
            required
          />

          <div class="invalid-feedback">Enter valid email</div>
        </div>
        <div class="mb-3">
          <label for="exampleInputPhoneNo" class="form-label" name = 'phone_no'>Phone No</label>
          <input
            type="txer"
            name="phone_no"
            class="form-control"
            id="exampleInputPhone"
            placeholder="9999999999"
            
            required
          />
          <div class="invalid-feedback">Enter valid contact number</div>
        </div>
        <div class="d-flex justify-content-start">
        <button type="submit" class="btn btn-primary me-4">Submit</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
        </div>
      </form>
      
      
    <!-- </div> -->
