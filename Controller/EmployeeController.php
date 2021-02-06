<?php
namespace Controller;
include 'Model/Employee.php';

use \Model\Employee;
use \Config\Request;

class EmployeeController extends Employee
{

    private function request($method)
    {
        $this->checkMethod($method);
        return $request = new Request($method);
    }

    private function checkMethod($method)
    {
        if ( $_SERVER['REQUEST_METHOD'] != $method ) {
            encode(['error'=>true,'message'=>'Something was gone wronge']);
            die();
        }
    }

    public function index()
    {
        return Employee::select()->getAll();
    }

    public function show($id)
    {
        return Employee::select()->where($id)->get();
    }

    public function edit($id)
    {
        $request = $this->request('PUT');

        Employee::where('id',$id)->update([
            "name_en" => $request->name_en,
            "email" => $request->email,
            "password" => $request->password,
        ]);

        return ['error'=>false,'message'=>'success'];
    }
    
    public function add()
    {
        $request = $this->request('POST');

        $emp_id = Employee::insert([
            "name_en" => $request->name_en,
            "email" => $request->email,
            "password" => $request->password,
            ])->lastID();

        return ['error'=>false,'message'=>'success','id'=>$emp_id];
    }

    public function delete($id)
    {
        $this->checkMethod('DELETE');
        Employee::where('id',$id)->remove();
        return ['error'=>false,'message'=>'success'];
    }
    
    public function org($id = NULL)
    {
        if (!is_null($id))
            return Employee::organizations()->where('employee.id' , $id)->getAll();
        
        return Employee::organizations()->getAll();
    }

}