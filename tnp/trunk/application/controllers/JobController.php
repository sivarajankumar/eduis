<?php
/**
 * JobController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class JobController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
	public function init(){
		
	}
    public function indexAction ()
    {
    $this->_redirect('job/register');
    }
    public function registerAction ()
    {
        
    }
    public function saveAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        
        
        
        
    }
    
}
