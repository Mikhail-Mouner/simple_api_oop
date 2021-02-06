<?php
include "DB.php";

class Organization extends DB
{
    public $table    =  'organization' ;
    public $table_id =  'id' ;
    public $select   =  ['name_en','name_ar'] ;
}