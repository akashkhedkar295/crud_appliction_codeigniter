<?php
namespace App\Models;
use CodeIgniter\Model;

class AuthModel extends Model{
    protected $table      = 'usersdata';
    protected $primaryKey = 'uid';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['uid','fname', 'email','password','bdate'];
    public function record(){
        return "hallo world";
    }
}
?>