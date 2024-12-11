<?php
namespace App\Models;
use CodeIgniter\Model;
use App\Libraries\MongoDb;

class UserModel extends Model{
    protected $table      = 'employees';
    protected $primaryKey = 'emp_id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['emp_id','f_name', 'email','phone_no'];
    public function record(){
        return "hallo world";
    }
}
?>