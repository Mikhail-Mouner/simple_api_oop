<?php
namespace Model;

include "Config/DB.php";
use \Config\DB;
class Employee extends DB
{
    public $table    =  'employee' ;
    public $table_id =  'id' ;
    public $select   = ['id','name_en','email','password'];

    public function organizations()
    {
        $this->join(['join'=>'INNER','table'=>'organization','on' => 'employee.organization_id = organization.id']);
        return $this;
    }
}