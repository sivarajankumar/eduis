<?php
class CareerController extends Zend_Controller_Action
{
    public function aclconfigAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $db = new Zend_Db_Table();
        $qry = 'SELECT
  `action_id`,
  `controller_id`
FROM `tnp`.`mod_role_resource`';
        $actions = $db->getAdapter()
            ->query($qry)
            ->fetchAll();
        /*echo "<pre>";
        print_r($actions);
        echo "</pre>";*/
        $delete2 = 'DELETE FROM `tnp`.`mod_role_resource` WHERE `role_id`=?';
        $db->getAdapter()->query($delete2, array('faculty'));
        $sql = 'INSERT INTO `tnp`.`mod_role_resource`(`role_id`,`module_id`,`controller_id`,`action_id`) VALUES (?,?,?,?)';
        foreach ($actions as $row) {
            $bind = array('faculty', 'tnp', $row['controller_id'], 
            $row['action_id']);
            $db->getAdapter()->query($sql, $bind);
        }
        /*foreach ($actions as $action) {
            echo '<pre>';
            print_r($action);
            echo '</pre>';
        }
        Zend_Registry::get('logger')->debug($actions);*/
    }
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
    public function addrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function viewrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $company_job_id = $params['company_job_id'];
        $company_id = $params['company_id'];
        $member_id = $params['member_id'];
        $record_info = $this->fetchRecord($company_job_id, $member_id);
        $record_info['company_job_id'] = $company_job_id;
        $record_info['company_id'] = $company_id;
        $record_info['member_id'] = $member_id;
        $this->view->assign('record_info', $record_info);
    }
    public function saverecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $stu_job_info = $my_array['student_job_info'];
        $record['appeared'] = $stu_job_info['appeared'];
        $record['selected'] = $stu_job_info['selected'];
        $record['package'] = $stu_job_info['package'];
        $record['date_of_selection'] = $stu_job_info['date_of_selection'];
        $record['drive_location'] = $stu_job_info['drive_location'];
        $record['registered'] = $stu_job_info['registered'];
        $member_ids = $my_array['member_ids'];
        foreach ($member_ids as $member_id) {
            $stu_job_info['member_id'] = $member_id;
            $this->saveStudentJob($stu_job_info);
        }
    }
    public function fetchrecordAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $company_job_id = $my_array['company_job_id'];
        $member_id = $my_array['member_id'];
        $format = $this->_getParam('format', 'log');
        $record = $this->fetchRecord($company_job_id, $member_id);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('record', $record);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($record, false) . ')';
                break;
            case 'json':
                $this->_helper->json($record);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($record);
                break;
            default:
                ;
                break;
        }
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
    public function fetchcompanyinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $company_id = $params['company_id'];
        $format = $this->_getParam('format', 'log');
        $company_info = $this->fetchCompanyInfo($company_id);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('company_info', $company_info);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($company_info, 
                false) . ')';
                break;
            case 'json':
                $this->_helper->json($company_info);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($company_info);
                break;
            default:
                ;
                break;
        }
    }
    public function fetchcompanyjobsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $company_id = $params['company_id'];
        $format = $this->_getParam('format', 'log');
        $company_jobs = $this->fetchCompanyJobs($company_id);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('company_jobs', $company_jobs);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($company_jobs, 
                false) . ')';
                break;
            case 'json':
                $this->_helper->json($company_jobs);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($company_jobs);
                break;
            default:
                ;
                break;
        }
    }
    public function fetchstudentsAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $company_job_id = $params['company_job_id'];
        $format = $this->_getParam('format', 'log');
        $students = $this->fetchStudents($company_job_id);
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('students', $students);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($students, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($students);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($students);
                break;
            default:
                ;
                break;
        }
    }
    public function addcompanyAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function viewcompanyAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $company_names = $this->fetchCompanies();
        $this->view->assign('company_names', $company_names);
    }
    public function editcompanyAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $company_id = $params['company_id'];
        $company_info = $this->fetchCompanyInfo($company_id);
        $format = $this->_getParam('format', 'html');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('company_info', $company_info);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($company_info, 
                false) . ')';
                break;
            case 'json':
                $this->_helper->json($company_info);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($company_info);
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
        $company_id_gen = $this->saveCompany($company_info);
        switch ($format) {
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($company_id_gen, false) . ')';
                break;
            case 'json':
                $this->_helper->json($company_id_gen);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($company_id_gen);
                break;
            default:
                ;
                break;
        }
    }
    public function addjobAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function editjobAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $company_job_id = $params['company_job_id'];
        $job_info = $this->fetchJobInfo($company_job_id);
        $job_info['company_job_id'] = $company_job_id;
        $this->view->assign('job_info', $job_info);
    }
    public function viewjobAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function savejobAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $my_array = $params['myarray'];
        $job_info = $my_array['job_info'];
        $company_id = null;
        if (! empty($job_info['company_job_id'])) {
            $company_job_id = $job_info['company_job_id'];
            $save['company_job_id'] = $company_job_id;
        }
        $save['company_id'] = $job_info['company_id'];
        $save['job'] = $job_info['job'];
        $save['eligibility_criteria'] = $job_info['eligibility_criteria'];
        $save['description'] = $job_info['description'];
        $save['date_of_announcement'] = $job_info['date_of_announcement'];
        $save['external'] = $job_info['external'];
        $format = $this->_getParam('format', 'log');
        $company_job_id = $this->saveJob($save);
        switch ($format) {
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' .
                 $this->_helper->json($company_job_id, false) . ')';
                break;
            case 'json':
                $this->_helper->json($company_job_id);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($company_job_id);
                break;
            default:
                ;
                break;
        }
    }
    public function fetchjobinfoAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $company_job_id = $params['company_job_id'];
        $job_info = $this->fetchJobInfo($company_job_id);
        $format = $this->_getParam('format', 'html');
        switch ($format) {
            case 'html':
                $this->_helper->viewRenderer->setNoRender(false);
                $this->_helper->layout()->enableLayout();
                $this->view->assign('job_info', $job_info);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($job_info, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($job_info);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($job_info);
                break;
            default:
                ;
                break;
        }
    }
    private function fetchCompanyInfo ($company_id)
    {
        $company = new Tnp_Model_Company();
        $company->setCompany_id($company_id);
        $info = $company->fetchInfo();
        if ($info instanceof Tnp_Model_Company) {
            $company_info = array();
            $company_info['company_name'] = $info->getCompany_name();
            $company_info['field'] = $info->getField();
            $company_info['description'] = $info->getDescription();
            $company_info['verified'] = $info->getVerified();
            return $company_info;
        } else {
            return false;
        }
    }
    private function fetchJobInfo ($company_job_id)
    {
        $job = new Tnp_Model_CompanyJob();
        $job->setCompany_job_id($company_job_id);
        $info = $job->fetchInfo();
        if ($info instanceof Tnp_Model_CompanyJob) {
            $job_info = array();
            $job_info['company_id'] = $info->getCompany_id();
            $job_info['job'] = $info->getJob();
            $job_info['eligibility_criteria'] = $info->getEligibility_criteria();
            $job_info['description'] = $info->getDescription();
            $job_info['date_of_announcement'] = $info->getDate_of_announcement();
            $job_info['external'] = $info->getExternal();
            return $job_info;
        } else {
            return false;
        }
    }
    private function fetchCompanyJobs ($company_id)
    {
        $company_job = new Tnp_Model_CompanyJob();
        $company_job->setCompany_id($company_id);
        $company_job_ids = $company_job->fetchCompanyJobIds();
        if (empty($company_job_ids)) {
            return false;
        } else {
            $jobs = array();
            foreach ($company_job_ids as $company_job_id) {
                $jobs[$company_job_id] = $this->fetchJobInfo($company_job_id);
            }
            return $jobs;
        }
    }
    private function fetchStudents ($company_job_id)
    {
        $company_job = new Tnp_Model_JobRecord();
        $company_job->setCompany_job_id($company_job_id);
        return $company_job->fetchStudents();
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
    private function fetchRecord ($company_job_id, $member_id)
    {
        $company = new Tnp_Model_JobRecord();
        $company->setMember_id($member_id);
        $company->setCompany_job_id($company_job_id);
        $info = $company->fetchInfo();
        if ($info instanceof Tnp_Model_JobRecord) {
            $record = array();
            $record['appeared'] = $info->getAppeared();
            $record['selected'] = $info->getSelected();
            $record['package'] = $info->getPackage();
            $record['date_of_selection'] = $info->getDate_of_selection();
            $record['drive_location'] = $info->getDrive_location();
            $record['registered'] = $info->getRegistered();
            return $record;
        } else {
            return false;
        }
    }
    private function saveStudentJob ($info)
    {
        $company = new Tnp_Model_JobRecord();
        return $company->saveInfo($info);
    }
    private function saveJob ($company_job_info)
    {
        $company_job = new Tnp_Model_CompanyJob();
        return $company_job->saveInfo($company_job_info);
    }
}

