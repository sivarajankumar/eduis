<?php
/**
 * TestingController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class TestingController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated TestingController::indexAction() default action
        $student = new Core_Model_Member_Student();
        $data = array('member_type_id' => 1, 'first_name' => 'Amrit', 
        'last_name' => 'Singh', 'dob' => '1990-05-09', 'blood_group' => 'B-', 
        'gender' => 'Male', 'religion_id' => 1, 'cast_id' => 1, 
        'nationality_id' => 1, 'join_date' => '2008-08-28', 
        'relieve_date' => '2012-08-28', 'image_no' => 12345, 'is_active' => 1);
        $student->saveCriticalInfo($data);
        /*$student->setMember_id(1);
        $i = $student->fetchContactInfo(1);
        if (! $i) {
            throw new Exception('No class info');
        } else {
            if ($i instanceof Core_Model_MemberContacts) {
                $phn_num = $i->getContact_details();
                Zend_Registry::get('logger')->debug($phn_num);
            }
        }*/
    }
}

