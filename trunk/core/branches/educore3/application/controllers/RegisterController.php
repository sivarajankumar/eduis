<?php
/**
 * RegisterController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class RegisterController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     * 
     */
    protected $_applicant;
    protected $_applicant_personal;
    protected $_member_id;
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function init ()
    {
        $this->_applicant = new Zend_Session_Namespace('applicant');
        $this->_applicant_personal = new Zend_Session_Namespace(
        'applicant_personal');
        $this->view->assign('applicant', $this->_applicant);
        $this->view->assign('steps', array('personal'));
    }
    public function validaterollnoAction ()
    {
        /*$rollNo = $this->getRequest()->getParam('roll_no');
        $application_basis = $this->getRequest()->getParam('admission_basis');
        $candidate = new Admsn_Model_Member_Candidate();
        $status = $candidate->setRoll_no($rollNo)->exists();
        
        $applicant = new Zend_Session_Namespace('applicant');
        $applicant->unsetAll();
        if (isset($status['is_locked']) and $status['is_locked'] == 1) {
            throw new Zend_Exception($rollNo.' has locked the application.',Zend_Log::ERR);
        } elseif ($status) {
            $applicant->roll_no = $status['roll_no'];
            $applicant->admission_basis = $status['admission_basis'];
            
        } else {
            $applicant->roll_no = $rollNo;
            $applicant->admission_basis = $admission_basis;
        }
        
       $this->_helper->json($status);*/
    }
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function followstepAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant->$colName = $value;
        }
        $model = new Core_Model_Member_Student();
        $model->initSave();
        $model->enroll($params);
        $model->initSave();
        $model->setRoll_no($params['roll_no']);
        $model->setDepartment_id($params['department_id']);
        $model->setProgramme_id($params['programme_id']);
        $model->setSemester_id($params['semester_id']);
        $model->findMemberID();
        $member_id = $model->getMember_id();
        $this->_applicant->member_id = $member_id;
        $this->_applicant->department_id = $params['department_id'];
        $this->_applicant->programme_id = $params['programme_id'];
        $this->_applicant->semester_id = $params['semester_id'];
        $this->_applicant->roll_no = $params['roll_no'];
        /*$PROTOCOL = 'http://';
        $URL = '/student/enroll' . '?' .http_build_query($params);
        Zend_Registry::get('logger')->debug($params);
        $client = new Zend_Http_Client($URL);
        $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
        $response = $client->request();
        if ($response->isError()) {
            $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message');
            throw new Zend_Exception($remoteErr, Zend_Log::ERR);
        } else {
            $jsonContent = $response->getBody($response);
            $member_id = Zend_Json_Decoder::decode($jsonContent);
            $this->_applicant->member_id = $member_id;
            Zend_Registry::get('logger')->debug($this->_applicant->member_id);
            return $member_id;
        }*/
    //Zend_Registry::get('logger')->debug($this->_applicant->member_id);
    }
    public function personalAction ()
    {
        $this->view->assign('stepNo', 0);
    }
    public function setpersonalAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $params['member_id'] = $this->_applicant->member_id;
        $params['department_id'] = $this->_applicant->department_id;
        $params['programme_id'] = $this->_applicant->programme_id;
        $params['semester_id'] = $this->_applicant->semester_id;
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant_personel->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? var_export($value, true) : htmlentities(
            trim($value));
            echo '<b>' . ucwords(str_ireplace('_', ' ', $colName)) . '</b> : ' .
             $value . '<br/>';
        }
        $model = new Core_Model_Member_Student();
        $model->initSave();
        $model->setSave_stu_dep(true);
        $model->save($params);
        $model->initSave();
        $model->setSave_stu_per(true);
        $model->save($params);
        /*$PROTOCOL = 'http://';
        Zend_Registry::get('logger')->debug($params);
        $URL = $PROTOCOL . CORE_SERVER . '/student/saveprofile' . '?' .
         http_build_query($params);
        $client = new Zend_Http_Client($URL);
        $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
        $response = $client->request();
        if ($response->isError()) {
            $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message');
            throw new Zend_Exception($remoteErr, Zend_Log::ERR);
        }
        $body = $response->getBody();*/
    //Zend_Registry::get('logger')->debug($body);
    }
    public function saveAction ()
    {}
    public function testAction ()
    {
        $params = array('programme_id');
        $model = new Core_Model_Member_Student();
        $model->initSave();
        $model->enroll($params);
        $model->setRoll_no($params['roll_no']);
        $model->setDepartment_id($params['department_id']);
        $model->setProgramme_id($params['programme_id']);
        $model->setSemester_id($params['semester_id']);
        $model->findMemberID();
        $member_id = $model->getMember_id();
    }
}


