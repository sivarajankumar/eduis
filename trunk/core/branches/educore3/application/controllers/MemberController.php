<?php
class MemberController extends Zend_Controller_Action
{
    /**
     * 
     * @var int
     */
    protected $_member_id;
    protected $_user_name;
    protected $_user_type;
    protected $_department_id;
    /**
     * @return the $_member_id
     */
    protected function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @return the $_user_name
     */
    protected function getUser_name ()
    {
        return $this->_user_name;
    }
    /**
     * @return the $_user_type
     */
    protected function getUser_type ()
    {
        return $this->_user_type;
    }
    /**
     * @return the $_department_id
     */
    protected function getDepartment_id ()
    {
        return $this->_department_id;
    }
    /**
     * @param int $_member_id
     */
    protected function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_user_name
     */
    protected function setUser_name ($_user_name)
    {
        $this->_user_name = $_user_name;
    }
    /**
     * @param field_type $_user_type
     */
    protected function setUser_type ($_user_type)
    {
        $this->_user_type = $_user_type;
    }
    /**
     * @param field_type $_department_id
     */
    protected function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $this->_redirect('/member/register');
    }
    public function init ()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $this->setDepartment_id($authInfo['department_id']);
            $this->setUser_name($authInfo['identity']);
            $this->setUser_type($authInfo['userType']);
            $this->setMember_id($authInfo['member_id']);
        }
    }
    public function profileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $member_id = $this->getMember_id();
        $profile_status = $this->findProfileStatus($member_id);
        if (empty($profile_status)) {
            $this->_helper->viewRenderer->setNoRender(false);
            $this->_helper->layout()->enableLayout();
        } else {
            $this->_redirect('/student');
        }
    }
    public function editpersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function viewpersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function savepersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $my_array = $params['myarray'];
        $personal_info = $my_array['personal_info'];
        Zend_Registry::get('logger')->debug($params);
        $this->savePersonalInfo($member_id, $personal_info);
        $this->activateProfile($member_id, true);
    }
    public function fetchpersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        Zend_Registry::get('logger')->debug(
        'member_id may be sent in as parameter');
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $personal_info = $this->findPersonalInfo($member_id);
        Zend_Registry::get('logger')->debug($personal_info);
        $this->_helper->json($personal_info);
    }
    public function registerAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $member_id = $this->getMember_id();
        $member_type = $this->getUser_type();
        $member_types = array(1 => 'STU', 2 => 'STAFF', 3 => 'MANAGEMENT', 
        4 => 'OUTSIDER');
        $info['member_id'] = $member_id;
        $info['member_type_id'] = array_search($member_type, $member_types);
        $member = new Core_Model_Member_Member();
        $member->register($info);
        if ($this->_department_id == 'MGMT' or $this->_department_id == 'mgmt') {
            $this->_redirect('http://' . TNP_SERVER . '/admin');
        }
        if ($this->_user_type == 'stu' or $this->_user_type == 'STU') {
            $this->_redirect('/member/profile');
        }
    }
    public function memberidcheckAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        if (! empty($member_id)) {
            $member_id_exists = $this->memberIdCheck($member_id);
            $format = $this->_getParam('format', 'log');
            switch ($format) {
                case 'html':
                    $this->_helper->viewRenderer->setNoRender(false);
                    $this->_helper->layout()->enableLayout();
                    $this->view->assign('member_id_exists', $member_id_exists);
                    break;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' . $this->_helper->json(
                    $member_id_exists, false) . ')';
                    break;
                case 'json':
                    $this->_helper->json($member_id_exists);
                    break;
                case 'log':
                    Zend_Registry::get('logger')->debug($member_id_exists);
                    break;
                default:
                    ;
                    break;
            }
        }
    }
    public function memberinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $member_id = null;
        if (empty($params['member_id'])) {
            $member_id = $this->getMember_id();
        } else {
            $member_id = $params['member_id'];
        }
        $info = array();
        if (empty($member_id)) {
            $info = false;
        } else {
            $info = $this->findMemberInfo($member_id);
        }
        $format = $this->_getParam('format', 'log');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('$info', $info);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($info, false) . ')';
                break;
            case 'json':
                $this->_helper->json($info);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug($info);
                break;
            default:
                ;
                break;
        }
    }
    /**
     * Checks if member is registered in the core,
     * @return true if member_id is registered, false otherwise
     */
    private function memberIdCheck ($member_id_to_check)
    {
        $member = new Core_Model_Member_Member();
        $member->setMember_id($member_id_to_check);
        $member_id_exists = $member->memberIdCheck();
        if (! $member_id_exists) {
            Zend_Registry::get('logger')->debug(
            'Member with member_id : ' . $member_id_to_check .
             ' is not registered in CORE');
        }
        return $member_id_exists;
    }
    private function findMemberInfo ($member_id)
    {
        $member = new Core_Model_Member_Member();
        $member->setMember_id($member_id);
        $member_info = array();
        $info = $member->fetchInfo();
        if ($info instanceof Core_Model_Member_Member) {
            $member_info['first_name'] = $info->getFirst_name();
            $member_info['middle_name'] = $info->getMiddle_name();
            $member_info['last_name'] = $info->getLast_name();
            $member_info['cast_id'] = $info->getCast_id();
            $member_info['nationality_id'] = $info->getNationality_id();
            $member_info['religion_id'] = $info->getReligion_id();
            $member_info['blood_group'] = $info->getBlood_group();
            $member_info['dob'] = $info->getDob();
            $member_info['gender'] = $info->getGender();
            $member_info['image_no'] = $info->getImage_no();
            foreach ($member_info as $key => $value) {
                if ($value == null) {
                    $member_info[$key] = null;
                }
            }
        } else {
            $member_info = false;
        }
        return $member_info;
    }
    private function savePersonalInfo ($member_id, $profile_info)
    {
        $member_types = array(1 => 'STU', 2 => 'STAFF', 3 => 'MANAGEMENT', 
        4 => 'OUTSIDER');
        $profile_info['member_id'] = $member_id;
        $member_type = $this->getUser_type();
        $profile_info['member_type_id'] = array_search($member_type, 
        $member_types);
        $member = new Core_Model_Member_Member();
        $member->setMember_id($member_id);
        return $member->saveInfo($profile_info);
    }
    private function findPersonalInfo ($member_id)
    {
        $member_id_exists = $this->memberIdCheck($member_id);
        if ($member_id_exists) {
            $member = new Core_Model_Member_Member();
            $member->setMember_id($member_id);
            $info = $member->fetchInfo();
            if ($info instanceof Core_Model_Member_Member) {
                $personal_data['first_name'] = $info->getFirst_name();
                $personal_data['middle_name'] = $info->getMiddle_name();
                $personal_data['last_name'] = $info->getLast_name();
                $personal_data['cast_id'] = $info->getCast_id();
                $personal_data['nationality_id'] = $info->getNationality_id();
                $personal_data['religion_id'] = $info->getReligion_id();
                $personal_data['blood_group'] = $info->getBlood_group();
                $personal_data['dob'] = $info->getDob();
                $personal_data['gender'] = $info->getGender();
                $personal_data['image_no'] = $info->getImage_no();
                foreach ($personal_data as $key => $value) {
                    if ($value == null) {
                        $personal_data[$key] = null;
                    }
                }
            } else {
                $personal_data = false;
            }
            return $personal_data;
        }
    }
    private function activateProfile ($member_id, $status)
    {
        $member = new Core_Model_Member_Member();
        $member->setMember_id($member_id);
        return $member->activateProfile(array('exists' => $status));
    }
    private function findProfileStatus ($member_id)
    {
        $profile = new Core_Model_Member_ProfileStatus();
        $profile->setMember_id($member_id);
        $info = $profile->fetchInfo();
        if ($info instanceof Core_Model_Member_ProfileStatus) {
            return $info->getExists();
        } else {
            return false;
        }
    }
}