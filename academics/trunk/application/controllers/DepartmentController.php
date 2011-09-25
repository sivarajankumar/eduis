<?php

class DepartmentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $dbtable = new Acad_Model_DbTable_StudentAttendance2();
        
        $result = $dbtable->stats('CSE','BTECH');
        echo("<pre>");
        print_r($result);
        
    }


}

