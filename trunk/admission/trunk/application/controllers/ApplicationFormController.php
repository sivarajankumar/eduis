<?php
/**
 * ApplicationFormController
 * 
 * @author
 * @version 
 */
class ApplicationFormController extends Admsnz_Base_BaseController
{
    public function init ()
    {
        $applicant = new Zend_Session_Namespace('applicant');
        $this->applicant = $applicant;
        $this->view->assign('applicant',$this->applicant);
        $this->view->assign('steps',array('basic','academic','hostel','bus','address'));
    }
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        
    }

    public function basicAction ()
    {
        //TODO Basic information of candidate.
    }
    public function setbasicAction ()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        print_r($this->getRequest()->getParams());
    }
    
    public function academicAction ()
    {
        //TODO Academic Information.
    }

    
    public function hostelAction ()
    {
        //TODO Hostel Section.
    }
    

    public function busAction ()
    {
        //TODO Hostel Section.
    }

    public function addressAction ()
    {
        //TODO Address Section.
    }
}
