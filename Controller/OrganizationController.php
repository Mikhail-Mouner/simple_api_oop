<?php
include "Organization.php";

class OrganizationController extends Organization
{
    public function index()
    {
        return Organization::select()->getAll();
    }

    public function show($id)
    {
        return Organization::select()->where('id',$id)->get();
    }

    public function employees($id = NULL)
    {
        if (!is_null($id))
            return Organization::select()->join(['table'=>'employee','on' => 'employee.organization_id = organization.id'])->where('organization.id' , $id)->getAll();

        return Organization::select()->join(['table'=>'employee','on' => 'employee.organization_id = organization.id'])->getAll();
    }

}