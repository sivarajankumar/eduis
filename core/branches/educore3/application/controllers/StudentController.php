<?php

class StudentController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    /**
     * 
     *to show the form on view for personal information
     */
    
    public function  createprofileAction()
    {
      $this->_helper->viewRenderer->setNoRender(false);
      $this->_helper->layout()->enableLayout();   
    }

    public function saveprofileAction()
    
    {
        
    }
    
    public function viewprofileAction()
    {
        
    }
}

