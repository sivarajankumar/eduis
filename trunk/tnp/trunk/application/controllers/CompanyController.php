<?php
/**
 * ComapnyController
 * 
 * @author
 * @version 
 */
require_once 'Zend/Controller/Action.php';
class CompanyController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    protected $_company;
    protected $_company_register;
    protected $_company_contact;
    
    public function init ()
    {
    	
        
    }
    
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->enableLayout();
        $this->_redirect('/company/register');
    }
    
    public function registerAction ()
    {
       $this->view->assign('stepNo', 0);
    }
    
    public function setregisterAction()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->company_register->$colName = $value;
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
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
       	echo "Data has been saved";
                
        
        
    }
    
    
    
    
}
