<?php
namespace App\Controllers;
use App\Models\UserModel;
use App\Libraries\MongoDb;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as excel;


class User extends BaseController{
    public $userModel ,$collection;
    public $mongo;
    public function __construct(){
        $this->userModel = new UserModel();
        $this->mongo = new MongoDb();
        $this->collection =  $this->mongo->getCollection('userMdata');
    }
    public function index(){
        $data['error'] = [];
        if(!session()->get('loggedin')){
            return redirect()->to('login')->with('fail','you must logged in!');
         } 
        $data['emp']= $this->userModel->findAll();
        $data['empfilter']= $this->userModel->findAll();
        echo view('NavBar');
        $data['state']=false;
        echo $this->request->getMethod();  
        return view('UserTable',$data);
    }

    public function AddUser(){
        if(!session()->get('loggedin')){
            return redirect()->to('login')->with('fail','you must logged in!');
         } 
        $alert['error'] = [];
        $validation = \Config\Services::validation();
        $check =$this->validate([
            'email' => 'is_unique[employees.email]',
            'phone_no' => 'min_length[10]|is_unique[employees.phone_no]',
        ]);
        $alert['empfilter'] = $this->userModel->findAll();
        $alert['state']=false;
        $alert['emp'] = $this->userModel->findAll();
        if($this->request->getMethod()=="POST"){
            if($check){
                $user = [
                    'f_name'=>$_POST['f_name'],
                    'email' => $_POST['email'],
                    'phone_no' =>$_POST['phone_no'],
                ];
                $this->userModel->save($user);

                $preId = $this->userModel->getInsertID();
                $user = [
                    '_id' => (string) $preId,
                    'f_name'=>$_POST['f_name'],
                    'email' => $_POST['email'],
                    'phone_no' =>$_POST['phone_no'],
                ];
               
                $this->collection->insertOne($user);

                $alert['success']= "Employee Record Inserted Successfully!";
                return redirect()->to('/');
            }else{
                $alert['error'] = $validation->getErrors();
                echo view('NavBar');
                return view('UserTable',$alert);
            }
        } 
    }

    public function UpdateUser($id){
        $alert['error'] = [];
        $validation = \Config\Services::validation();
        $alert['empfilter'] =$this->userModel->findAll();
        $alert['emp'] = $this->userModel->findAll();
        $alert['state']= false;
        $check =$this->validate([
            'email' => 'is_unique[employees.email]',
            'phone_no' => 'min_length[10]|is_unique[employees.phone_no]',
        ]);
        $userRow['employee']= $this->userModel->find($id);
        if($this->request->getMethod()=="POST"){
                $user['f_name']=$_POST['f_name'];
                $user['email'] =$_POST['email'];
                $user['phone_no'] =$_POST['phone_no'];
                $this->userModel->update($id,$user); 
                $this->collection->updateOne(['_id'=>$id],['$set'=>$user]);
                $alert['success']= "Employee Record Updated Successfully !";
                return redirect()->to('UserTable')->with('success','record updated successfully');
        }
        if(!session()->get('loggedin')){
           return redirect()->to('login')->with('fail','you must logged in!');
        } 
       echo view('UpdateUser',$userRow,$alert);
    }

    public function deleteUser($id){
        if(!session()->get('loggedin')){
            return redirect()->to('login')->with('fail','you must logged in!');
         } 
        $this->userModel->delete($id);
        echo var_dump($id);
        $this->collection->deleteOne(['_id'=>$id]);
        return redirect()->to(base_url("UserTable"));
    }


    public function filter(){

        if($this->request->getMethod()=="POST"){
            $name =$_POST['f_name'];
            $email = $_POST['email'];
            $phone_no =$_POST['phone_no'];
            $filter_data['emp'] = $this->userModel->where('email',$email)->orWhere('f_name',$name)->orwhere('phone_no',$phone_no)->findAll();
            $filter_data['empfilter'] = $this->userModel->findAll();
            $filter_data['state']=true;
            $filter_data['error']=[];
            echo view('NavBar');
            return view('UserTable',$filter_data);
        }
    }

    public function download(){
        $spredsheet =new Spreadsheet();
        $result = $this->userModel->findAll();
        $sheet = $spredsheet->getActivesheet();
        $sheet->setCellValue("A1","emp_id");
        $sheet->setCellValue("B1","F_name");
        $sheet->setCellValue("C1","email");
        $sheet->setCellValue("D1","phone no");
        $count = 2;
        foreach ($result as $row){
            $sheet->setCellValue("A".$count,$row['emp_id']);
            $sheet->setCellValue("B".$count,$row['f_name']);
            $sheet->setCellValue("C".$count,$row['email']);
            $sheet->setCellValue("D".$count,$row['phone_no']);
            $count++;
        }
        $writer= new Xlsx($spredsheet);
        $writer->save('user-data.xlsx');
        return $this->response->download('user-data.xlsx', null)->setFileName('expenses.xlsx');

    }
    
    public function Upload(){
        if($this->request->getMethod()=="POST"){
            $rule=$this->validate([
                'filename' => 'uploaded[filename]|max_size[filename,500]|ext_in[filename,csv,xlsx]',
            ]);
            if($rule){
                $fileName = $this->request->getfile('filename');
                $fname=$fileName->getName();
                $tmpName=$fileName->getTempName();
                $arr_file=explode('.',$fname);
                $extension = end($arr_file);
                if($extension == 'csv'){
                    $reader = new Csv();
                }else{
                    $reader = new excel();
                }
                $spreadsheet = $reader->load($tmpName);
                $sheetdata= $spreadsheet->getActiveSheet()->toArray();
                $AllData =[];
                $remainingData  = [];
                foreach ($this->userModel->findAll() as $row){
                    $AllData['email'][] = $row['email'];
                    $AllData['phone_no'][] = $row['phone_no'];
                    $AllData['f_name'][] = $row['f_name'];
                }

                if(!empty($sheetdata)){
                    for($i = 1;$i<count($sheetdata);$i++){
                        if(in_array($sheetdata[$i][2],$AllData['email']) || in_array($sheetdata[$i][3],$AllData['phone_no']) || 
                        empty($sheetdata[$i][1]) || empty($sheetdata[$i][2]) || empty($sheetdata[$i][3])){
                            $data = [
                                'f_name' => $sheetdata[$i][1],
                                'email' => $sheetdata[$i][2],
                                'phone_no' => $sheetdata[$i][3],
                            ];
                            array_push($remainingData,$data);
                            continue;
                        }
                        $dbdata['f_name']=$sheetdata[$i][1];
                        $dbdata['email']=$sheetdata[$i][2];
                        $dbdata['phone_no']=$sheetdata[$i][3];
                        $this->userModel->save($dbdata);
                        $dbdata['_id'] = (String) $this->userModel->getInsertID();
                        $this->collection->insertOne($dbdata);
                        
                    }
                   if(!empty($remainingData)){
                        $spredsheet =new Spreadsheet();
                        $sheet = $spredsheet->getActivesheet();
                       
                        $sheet->setCellValue("B1","F_name");
                        $sheet->setCellValue("C1","email");
                        $sheet->setCellValue("D1","phone no");
                        $count=2;
                        foreach ($remainingData as $row){
                            $sheet->setCellValue("B".$count,$row['f_name']);
                            $sheet->setCellValue("C".$count,$row['email']);
                            $sheet->setCellValue("D".$count,$row['phone_no']);
                            $count++;
                        }
                        $writer= new Xlsx($spredsheet);
                        $writer->save('user-data.xlsx');
                        $this->response->download('user-data.xlsx', null)->setFileName('rmdata.xlsx');
                   }
                    return redirect()->to('UserTable');
                }
            }else{
                return redirect()->to('UserTable')->with('file is empty or not uploaded valid file');
            }
        }else{
            return redirect()->to('UserTable')->with('invalid file uploaded!');
        }
        return redirect()->to('UserTable');
    }
    

    public function deleteSelected(){
        if($this->request->getMethod()=="POST"){
            $ids = $this->request->getPost('check_box');
            print_r($ids);
            if(!empty($ids)){
                $delete = $this->userModel->delete($ids); 
            }
        }
        return redirect()->to('UserTable')->with('status',"Selected Record deleted successfully");
    }
}
?>


        