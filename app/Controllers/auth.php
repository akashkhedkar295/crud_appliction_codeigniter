<?php
namespace App\Controllers;
use App\Models\AuthModel;
use App\Libraries\Hash;

class auth extends BaseController {
    public $userModel ;
    public function __construct(){
        $this->userModel = new AuthModel();
    }
    public function index(){
        return view('login');
    }
    public function signup(){
        $alert['error'] = [];
        $validation = \Config\Services::validation();
        $check =$this->validate([
            'fname'=>'required',
            'email' => 'required|valid_email|is_unique[usersdata.email]',
            'password' => 'required',
            'cpassword' => 'matches[password]',
        ]);
        if($this->request->getMethod()=="POST"){
            if($check){
                $user['fname'] = $_POST['fname'];
                $user['email'] = $_POST['email'];
                $user['bdate'] = $_POST['bdate'];
                $user['password'] = Hash::make($_POST['password']);
                $this->userModel->save($user);
                $alert['success']= "Employee Record Inserted Successfully !";
                return redirect()->to(base_url("login"));
            }else{
                $alert['error'] = $validation->getErrors();
            }
        }
        return view('signup',$alert);
    }

    public function login(){
        helper('form');
        $alert['error'] = [];
        $validation = \Config\Services::validation();
        $check=$this->validate([
            'email' => 'required|valid_email|is_not_unique[usersdata.email]',
            'password'=> 'required',
        ]);
        if($this->request->getMethod() == "POST"){
            if($check){     
                $email = $_POST['email'];
                $password = $_POST['password'];
                $user_info = $this->userModel->where('email',$email)->first();
                $check_password = Hash::check($password,$user_info['password']);
                if(!$check_password){
                    session()->setFlashdata('fail',"incurrect password");
                    return redirect()->to('/login')->withInput();   
                }else{
                    $user_id = $user_info['uid'];
                    session()->set([
                        'email' => $user_info['email'],
                        'uid' => $user_info['uid'],
                        'name'=>$user_info['fname'],
                        'loggedin'=> true,
                    ]);
                    return redirect()->to('UserTable');
                }
            }else{
                $alert['error']=$validation->getErrors();
            }
        }
        echo session()->get('loggedin');
        echo view('login',$alert);
    }

    public function logout(){
        if(session()->get('loggedin')){
            session()->destroy();
            return redirect()->to('login?access=out')->with('fail','your logged out!');
        }
    } 
}
?>