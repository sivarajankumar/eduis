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
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(false);
        $student = new Tnp_Model_Member_Student();
        $student->setMember_id(1);
        $al = $student->fetchTrainingInfo(1);
        Zend_Registry::get('logger')->debug($al);
    }
}
