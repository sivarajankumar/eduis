<?php
class CareerController extends Zend_Controller_Action
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
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
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
    public function placementrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function fetchcompaniesAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $format = $this->_getParam('format', 'log');
        $companies = $this->fetchCompanies();
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('companies', $companies);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($companies, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($companies);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($companies);
                break;
            default:
                ;
                break;
        }
    }
    public function savecompanyAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $company_info = $my_array['company_info'];
        $company_id = null;
        if (! empty($company_info['company_id'])) {
            $company_id = $company_info['company_id'];
            $save['company_id'] = $company_id;
        }
        $save['company_name'] = $company_info['company_name'];
        $save['field'] = $company_info['field'];
        $save['description'] = $company_info['description'];
        $save['verified'] = $company_info['verified'];
        $format = $this->_getParam('format', 'log');
        $this->saveCompany($company_info);
        switch ($format) {
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json(true, false) . ')';
                break;
            case 'json':
                $this->_helper->json(true);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug(true);
                break;
            default:
                ;
                break;
        }
    }
    private function fetchCompanies ()
    {
        $company = new Tnp_Model_Company();
        return $company->fetchCompanies();
    }
    private function saveCompany ($company_info)
    {
        $company = new Tnp_Model_Company();
        return $company->saveInfo($company_info);
    }
}

