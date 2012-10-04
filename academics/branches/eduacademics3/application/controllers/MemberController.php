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
            $this->_redirect('http://core.aceambala.com/member');
        } else {
            $this->_redirect('/student');
        }
    }
    public function savepersonalinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        Zend_Registry::get('logger')->debug($params);
        $member_id = null;
        $personal_info = $params['personal_info'];
        $member_id = $personal_info['member_id'];
        $this->savePersonalInfo($member_id, $personal_info);
        $this->activateProfile($member_id, true);
        $format = $this->_getParam('format', 'log');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('status', true);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json(true, false) . ')';
                break;
            case 'json':
                $this->_helper->json(true);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug(true);
                break;
            default:
                ;
                break;
        }
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
        $member = new Acad_Model_Member_Member();
        $member->register($info);
        if ($this->_department_id == 'MGMT' or $this->_department_id == 'mgmt') {
            $this->_redirect('http://' . TNP_SERVER . '/admin');
        }
        if ($this->_user_type == 'stu' or $this->_user_type == 'STU') {
            $this->_redirect('/member/profile');
        }
    }
    private function savePersonalInfo ($member_id, $profile_info)
    {
        $member = new Acad_Model_Member_Member();
        $member->setMember_id($member_id);
        $member->saveInfo($profile_info);
    }
    private function activateProfile ($member_id, $status)
    {
        $member = new Acad_Model_Member_ProfileStatus();
        $member->setMember_id($member_id);
        return $member->activateProfile(array('exists' => $status));
    }
    private function findProfileStatus ($member_id)
    {
        $profile = new Acad_Model_Member_ProfileStatus();
        $profile->setMember_id($member_id);
        $info = $profile->fetchInfo();
        if ($info instanceof Acad_Model_Member_ProfileStatus) {
            return $info->getExists();
        } else {
            return false;
        }
    }
}