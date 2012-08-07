<?php
class DepartmentController extends Zend_Controller_Action
{
    public function init ()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $this->department_id = $authInfo['department_id'];
            $this->identity = $authInfo['identity'];
            $this->setMember_id($authInfo['member_id']);
        }
    }
    public function indexAction ()
    {}
}
