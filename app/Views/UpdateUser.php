
<!-- <div class="contener-form"> -->
      <form class="card px-5 py-5 needs-validation" id="test" method="post" novalidate>
        <div class="hede pb-4 text-center">
          <h3>Upade Employee Details<Embed></Embed></h3> 
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label" name='f_name'
            >Full Name</label
          >
          <input
            type="text"
            class="form-control"
            name="f_name"
            id="f_name"
            aria-describedby="f_name"
            placeholder="Enter Employee Name"
            value=""
            required
          />
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail" class="form-label" name='email'>Email</label>
          <input
            type="email"
            name="email"
            id="email"
            class="form-control"
            id="exampleInputEmail1"
            placeholder="abcd123@gmail.com"
            value=""
            required
          />
        </div>
        <div class="mb-3">
          <label for="exampleInputPhoneNo" class="form-label" name = 'phone_no'>Phone No</label>
          <input
            type="txer"
            name="phone_no"
            id="phone_no"
            class="form-control"
            id="exampleInputPhone"
            placeholder="9999999999"
            value=""
            required
          />
        </div>
        <div class="d-flex justify-content-start">
        <button type="submit" class="btn btn-primary me-4">Update</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
        </div>
      </form>
      <script>
        (() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
      </script>
    <!-- </div>  -->

