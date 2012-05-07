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
        $al = $student->getAllowedProperties();
        Zend_Registry::get('logger')->debug($al);
    }
}
