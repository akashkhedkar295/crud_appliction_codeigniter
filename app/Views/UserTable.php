<?= $this->extend('tmplates/Main');?>
<?= $this->section('home');?>
<?php use App\Models\UserModel;?>

<?php $updateID; ?>

<script>
  $(document).ready(function(){
        $('#select_all').on('click',function(){
          if(this.checked){
            $('.checkbox').each(function(){
              this.checked = true;
            });
          }else{
            $('.checkbox').each(function(){
              this.checked = false;
            });
          }
        });

        $('.checkbox').on('click',function(){
          if($('.checkbox:checked').length == $('.checkbox').length){
            $('#select_all').prop('checked',true);
          }else{
            $('#select_all').prop('checked',false);
          }
        })
      });

</script>
<form method="post" >
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Filter Employee data</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="myModal">

          <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
              <select class="select2 dropDown " name='email'>
                <option value="" selected>Choose...</option>
                <?php 
                $emails = array_unique(array_column($empfilter,'email'));
                foreach ($emails as $email){
              ?>
                <option value="<?php echo $email?>">
                  <?php echo $email?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Name</label>
            <div class="col-sm-10">
              <select class="select2 dropDown" name="f_name">
                <option value="" selected>Choose...</option>
                <?php 
                 $names = array_unique(array_column($empfilter,'f_name'));
                 foreach ($names as $name){
               ?>
                <option value="<?php echo $name?>">
                  <?php echo $name;?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="mb-3 row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Contact No.</label>
            <div class="col-sm-10">
              <select value="" class="select2 dropDown" name="phone_no">
                <option selected>Choose...</option>
                <?php 
                  $phoneNos = array_unique(array_column($empfilter,'phone_no'));
                  foreach ($phoneNos as $phoneNo){
               ?>
                <option value="<?php echo $phoneNo ?>">
                  <?php echo $phoneNo ?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-dark">Apply</button>
        </div>
      </div>
    </div>
  </div>
</form>

<div class="modal fade" id="updateUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <?php include 'UpdateUser.php'; ?>
    </div>
  </div>
</div>


<div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <?php include 'AddUser.php'; ?>
    </div>
  </div>
</div>
<script>
  if ("<?= $error? $error['email'] : ''?>" !== "") {
    var myModal = new bootstrap.Modal(document.getElementById('addUser'), { keyboard: false }); myModal.show();
  }
</script>
<div class="container ">
  <div class="row">
    <div class="col-md-offset-1 col-md-10">
      <div class="panel pt-3">
        <div class="pe-3">
          <div class="ms-3 row">
            <div class=" col-sm-12 col-xs-12">
              <button class="btn me-1 btn-sm btn-primary p-2 pull-left" data-bs-toggle="modal"
                data-bs-target="#addUser"><i class="fa fa-plus-circle"></i> Add New</button>

              <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                  fill="currentColor" class="bi bi-funnel-fill" viewBox="0 0 16 16">
                  <path
                    d="M1.5 1.5A.5.5 0 0 1 2 1h12a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.128.334L10 8.692V13.5a.5.5 0 0 1-.342.474l-3 1A.5.5 0 0 1 6 14.5V8.692L1.628 3.834A.5.5 0 0 1 1.5 3.5z" />
                </svg> Filter </button>

              <a href="<?= base_url('download');?>" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg"
                  width="16" height="15" fill="currentColor" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
                  <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293z" />
                </svg> Download </a>

              <?php if($state) echo '<a href="'.base_url('/UserTable').'" class="btn btn-danger" data-bs-dismiss="modal">Reset</a>';?>


            </div>
            <!-- upload file form  -->
            <form action="<?= base_url('/Upload')?>" method="post" enctype="multipart/form-data">
              <input type="file" class="upload" name="filename">
              <button type="submit" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                  height="16" fill="currentColor" class="bi bi-cloud-upload-fill" viewBox="0 0 16 16">
                  <path fill-rule="evenodd"
                    d="M8 0a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 4.095 0 5.555 0 7.318 0 9.366 1.708 11 3.781 11H7.5V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11h4.188C14.502 11 16 9.57 16 7.773c0-1.636-1.242-2.969-2.834-3.194C12.923 1.999 10.69 0 8 0m-.5 14.5V11h1v3.5a.5.5 0 0 1-1 0" />
                </svg>Upload</button>
            </form>
          </div>
        </div>
        <form method="post"  name="deleteSelecteRecord" onsubmit="return confirmDelete()" action="<?= base_url('/UserTable/DeleteSelected')?>">
        <div class="panel-body table-responsive">
          <table id="myTable" class="table table-dark">
            <thead>
              <tr>
                <th> <button type="submit" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
  <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
</svg></button>
                <input class="checkbox form-check-input" onclick="toggle(this)" type="checkbox" name="checkbox"  id="select_all"></th>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($emp as $row){?>
              <tr>
                <td>
                <input class="checkbox form-check-input" type="checkbox"   name="check_box[]" value="<?= $row['emp_id']?>" >
                </td>
                <script>
                  function setValue(id, name, email, phone) {
                    document.getElementById('f_name').value = name;
                    document.getElementById('email').value = email;
                    document.getElementById('phone_no').value = phone;
                    document.getElementById('test').action= `<?= base_url('/UserTable/Update/')?>${id}`;
                  }
                  </script>
                <td>
                  <?php echo $row['emp_id']?>
                </td>
                <td>
                  <?php echo $row['f_name']?>
                </td>
                <td>
                  <?php echo $row['email']?>
                </td>
                <td>
                  <?php echo $row['phone_no']?>
                </td>
                <td>
                  <ul class="action-list">
                    <li><button type="button" class="btn btn-primary" onclick="setValue('<?= $row['emp_id']?>','<?= $row['f_name']?>','<?= $row['email']?>','<?= $row['phone_no']?>')" data-bs-toggle="modal" data-bs-target="#updateUser"><i class="fa fa-pencil"></i>
                      </button></li>
                    <li><a href="<?= base_url(" UserTable/delete/{$row['emp_id']}"); ?>" onclick="return confirmDelete()" class="btn btn-danger"><i class="fa fa-times"></i></a> </li>
                  </ul>
                </td>
              </tr>
              <?php 
                }
              ?>
            </tbody>
          </table>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection();?>