<?php
namespace Controller;
include 'Model/Employee.php';

use \Model\Employee;
use \Config\Request;

class EmployeeController extends Employee
{

    
    public function __call($method,$arguments) {
        if(method_exists($this, $method)) {
            
            switch ($method) {
                case 'add':
                    $request = 'POST';
                break;
                
                case 'edit':
                    $this->checkArgument($arguments);
                    $request = 'PUT';
                break;
                
                case 'delete':        
                    $request = 'DELETE';
                break;
                
                default:
                    $request = 'GET';
                    break;
            }
            $this->checkMethod($request);
            return call_user_func_array(array($this,$method),$arguments);
        }else{
            encode(['error'=>true,'message'=>'This method doesnt exists!']);
            die();
        }
    }

    private function request($method)
    {
        return $request = new Request($method);
    }

    private function checkMethod($method)
    {
        if ( $_SERVER['REQUEST_METHOD'] != $method ) {
            encode(['error'=>true,'message'=>'This request was wrong with this method']);
            die();
        }
    }
    
    //------------Start Controller------------//
    private function index()
    {
        return Employee::select()->getAll();
    }

    private function show($id)
    {
        return Employee::select()->where($id)->get();
    }

    private function edit($id)
    {
        $request = $this->request('PUT');

        Employee::where('id',$id)->update([
            "name_en" => $request->name_en,
            "email" => $request->email,
            "password" => $request->password,
        ]);

        return ['error'=>false,'message'=>'success'];
    }
    
    private function add()
    {
        $request = $this->request('POST');

        $emp_id = Employee::insert([
            "name_en" => $request->name_en,
            "email" => $request->email,
            "password" => $request->password,
            ])->lastID();

        return ['error'=>false,'message'=>'success','id'=>$emp_id];
    }

    private function delete($id)
    {
        Employee::where('id',$id)->remove();
        return ['error'=>false,'message'=>'success'];
    }
    
    private function org($id = NULL)
    {
        if (!is_null($id))
            return Employee::organizations()->where('employee.id' , $id)->getAll();
        
        return Employee::organizations()->getAll();
    }

}