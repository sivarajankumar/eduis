<?php
class TestingController extends Zend_Controller_Action
{
    public function newAction ()
    {}
    public function newsAction ()
    {
        /*
         * @todo Show all dmc's grouped by Programme and discipline id as heading and grouped by semester and ordered by result types
         */
        $response = array();
        $this->_helper->layout()->enableLayout();
        $params = $this->getRequest()->getParams();
        $dmc_params = $params['dmcParams'];
        /*
         * Optional Params
         */
        $department_id = $dmc_params['department_id'];
        $programme_id = $dmc_params['programme_id'];
        $semester_id = $dmc_params['semester_id'];
        /*
         * Mandatory params
         */
        $member_id = 1; // For student : Extract from Session . For Admin extract from Request
        /*
         * Fetch Criticlal Info of member from models 
         */
        $student_object = new Acad_Model_Member_Student();
        $student_object->setMember_id($member_id);
        $batch_id = $student_object->fetchBatchId();
        /*
         *  Format for $all_dmc_info_ids = array('dmc_info_id'=>1234,' 'class_id'=>123, 'dmc_id'=>567,
         *  'result_type_id'=1)
         */
        $all_dmc_info_ids = $student_object->fetchAllDmcInfoIds();
        /*
         *Here we compute the Class of Student on basis of
         * 1)Semester id
         *   And
         * 2)Batch id 
         * 
         */
        $class_object = new Acad_Model_Class();
        $class_object->setSemester_id($semester_id);
        $class_object->setBatch_id($batch_id);
        $member_semester_class_id = $class_object->fetchClassId($department_id, 
        $programme_id);
        // All his dmc info ids and so does his dmc ids are fetched
        $dmc_info_ids = $student_object->fetchDmcInfoIds(
        $member_semester_class_id);
        Zend_Registry::get('logger')->debug($dmc_info_ids);
        // $this->view->assign('dmc_info_ids', $dmc_info_ids);
        $response['dmc_info_ids'] = $dmc_info_ids;
        /*$dmc_data = array(
        1 => array('Marks Obtained' => 400, 'Total Marks' => 500, 
        'Percentage' => 80), 
        2 => array('Marks Obtained' => 450, 'Total Marks' => 500, 
        'Percentage' => 90));*/
        $this->_helper->json($response);
    }
    public function paramCheckAction ()
    {
        $params = $this->getRequest()->getParams();
        $member_id = $params['member_id'];
        if (! empty($member_id) and is_int($member_id)) {
            $dmc_info_ids = $this->studentInfoAction('dmc_info_ids');
        }
        $department_id = $params['department_id'];
        $programme_id = $params['programme_id'];
        $department_id = $params['department_id'];
    }
    public function studentInfoAction ($info_required)
    {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $params = $this->getRequest()->getParams();
        $member_id = $params['member_id']; // Can be Extracted from Session also
        /**
         * 
         * All params are conditionally set depending on their status
         *
         */
        $department_id = $params['department_id'];
        $programme_id = $params['programme_id'];
        $semester_id = $params['semester_id'];
        $class_id = $params['class_id'];
        //
        $student_object = new Acad_Model_Member_Student();
        $student_object->setMember_id($member_id);
        /*
         *  Format for $all_dmc_info_ids = array('dmc_info_id'=>1234,' 'class_id'=>123, 'dmc_id'=>567,
         *  'result_type_id'=1)
         */
        switch ($info_required) {
            case 'dmc_info_ids':
                $all_dmc_info_ids = $student_object->fetchAllDmcInfoIds();
                return $all_dmc_info_ids;
                break;
            case 'current_class_id':
                $current_class_id = $student_object->fetchClassId(null, true);
                return $current_class_id;
                break;
            case 'all_class_ids':
                $class_ids = $student_object->fetchClassId(null, null, true);
                return $class_ids;
                break;
            case 'class_info':
                $class_object = new Acad_Model_Class();
                $class_object->setClass_id($class_id);
                $class_object->fetchInfo();
                $info = array();
                // get all info you want
                return $info;
                break;
            case 'subjects':
                $subjects = array();
                $subjects = $student_object->fetchClassSubjects($class_id);
                return $subjects;
                break;
            case 'dmc':
                $dmc = array();
                $dmc = $student_object->fetchDmc();
                return $subjects;
                break;
            default:
                ;
                break;
        }
    }
    public function testAction ()
    {
        /* $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $this->_helper->json($candidates, false);*/
    //$student = new Acad_Model_Qualification();
    /*$data_array = array('member_id' => 1, 'member_type_id' => 1, 
        'first_name' => 'AMRIT', 'last_name' => 'SINGH', 'dob' => '1990-05-09', 
        'blood_group' => 'B-', 'gender' => 'MALE', 'religion_id' => 1, 
        'cast_id' => 1, 'nationality_id' => 1, 'join_date' => '2008-08-28', 
        'relieve_date' => '2012-08-28', 'image_no' => 12245, 'is_active' => 1);
        $student->initSave();
        $student->saveCriticalInfo($data_array);*/
    //$student->setQualification_id(1);
    /* $c = $student->fetchCriticalInfo();
        $info = array();
        if ($c) {
            $props = $student->getAllowedProperties();
            foreach ($props as $prop) {
                $getter_string = 'get' . ucfirst($prop);
                $info[$prop] = $student->$getter_string();
            }
        }*/
    /*  $q = $student->fetchInfo();
        Zend_Registry::get('logger')->debug($q);
        if ($q) {
            Zend_Registry::get('logger')->debug(
            $student->getQualification_name());
        }*/
    /*$re = new Acad_Model_StudentSubject();
        $rt = $re->fetchResultTypes();
        Zend_Registry::get('logger')->debug($rt);*/
    /* $name = 'Amrit';
        $this->disName();*/
    /* $obj = new Acad_Model_Member_Student();
        $obj->setMember_id(1);
        $p = $obj->fetchDmcInfoIds(1);
         Zend_Registry::get('logger')->debug($p);*/
    /*$params = $this->getRequest()->getParams();
        Zend_Registry::get('logger')->debug($params);*/
    }
}

