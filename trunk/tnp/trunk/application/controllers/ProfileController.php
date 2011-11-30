<?php
/**
 * ProfileController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class ProfileController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    protected $_applicant;
    protected $_applicant_personal;
    protected $_applicant_academic;
    protected $_applicant_admissionbasis;
    protected $_applicant_degreedetails;
    protected $_applicant_career;
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
        $this->_applicant_admissionbasis = new Zend_Session_Namespace(
        'applicant_admissionbasis');
        $this->_applicant_academic = new Zend_Session_Namespace(
        'applicant_academic');
        $this->_applicant_degreedetails = new Zend_Session_Namespace(
        'applicant_degreedetails');
        $this->_applicant_career = new Zend_Session_Namespace('applicant_career');
        $this->view->assign('applicant', $this->_applicant);
        $this->view->assign('steps', 
        array('personal', 'admissionbasis', 'academic', 'degreedetails', 
        'career'));
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
        $PROTOCOL = 'http://';
        Zend_Registry::get('logger')->debug($params);
        $URL = $PROTOCOL . CORE_SERVER . '/student/enroll' . '?' .
         http_build_query($params);
        $client = new Zend_Http_Client($URL);
        $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
        $response = $client->request();
        if ($response->isError()) {
            $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message');
            throw new Zend_Exception($remoteErr, Zend_Log::ERR);
        } else {
            $jsonContent = $response->getBody($response);
            $memberId = Zend_Json_Decoder::decode($jsonContent);
            $this->_applicant->memberId = $memberId;
            Zend_Registry::get('logger')->debug($this->_applicant->memberId);
            return $memberId;
        }
        $this->_applicant->memberId = $memberId;
        Zend_Registry::get('logger')->debug($this->_applicant->memberId);
        
    }
    public function personalAction ()
    {
        $this->view->assign('stepNo', 0);
    }
    public function setpersonalAction ()
    {
        Zend_Registry::get('logger')->debug($this->_applicant->memberId);
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $params['member_id'] = $this->_applicant->memberId;
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
        $PROTOCOL = 'http://';
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
        $body = $response->getBody();
        Zend_Registry::get('logger')->debug($body);
    }
    public function admissionbasisAction ()
    {
        $this->view->assign('stepNo', 1);
    }
    public function setadmissionbasisAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $this->_applicant->$colName = $value;
        }
        $this->_redirect('/profile/academic');
    }
    public function academicAction ()
    {
        $this->view->assign('stepNo', 2);
    }
    public function setacademicAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant_academic->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? var_export($value, true) : htmlentities(
            trim($value));
            echo '<b>' . ucwords(str_ireplace('_', ' ', $colName)) . '</b> : ' .
             $value . '<br/>';
        }
        $PROTOCOL = 'http://';
        Zend_Registry::get('logger')->debug($params);
        $URL = $PROTOCOL . ACADEMIC_SERVER . '/student/saveprofile' . '?' .
         http_build_query($params);
        $client = new Zend_Http_Client($URL);
        $client->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
        $response = $client->request();
        if ($response->isError()) {
            $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message');
            throw new Zend_Exception($remoteErr, Zend_Log::ERR);
        }
    }
    public function degreedetailsAction ()
    {
        $this->view->assign('stepNo', 3);
    }
    public function setdegreedetailsAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant_degreedetails->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? var_export($value, true) : htmlentities(
            trim($value));
            echo '<b>' . ucwords(str_ireplace('_', ' ', $colName)) . '</b> : ' .
             $value . '<br/>';
        }
    }
    public function careerAction ()
    {
        $this->view->assign('stepNo', 4);
    }
    public function setcareerAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant_career->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? var_export($value, true) : htmlentities(
            trim($value));
            echo '<b>' . ucwords(str_ireplace('_', ' ', $colName)) . '</b> : ' .
             $value . '<br/>';
        }
    }
    public function saveAction ()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $authInfo = Zend_Auth::getInstance()->getStorage()->read();
        $this->_applicant = $authInfo['applicant'];
        $this->_applicant_personal = $authInfo['applicant_personal'];
        $this->_applicant_academic = $authInfo['applicant_admissionbasis'];
        $this->_applicant_academic = $authInfo['applicant_academic'];
        $this->_applicant_academic = $authInfo['applicant_degreedetails'];
        $this->_applicant_career = $authInfo['applicant_career'];
    }
}
