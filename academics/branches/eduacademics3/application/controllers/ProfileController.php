<?php
class ProfileController extends Zend_Controller_Action
{
    protected $_applicant;
    protected $_applicant_academic;
    protected $_applicant_admissionbasis;
    protected $_applicant_degreedetails;
    public function init ()
    {
        $this->_applicant = new Zend_Session_Namespace('applicant');
        $this->_applicant_admissionbasis = new Zend_Session_Namespace(
        'applicant_admissionbasis');
        $this->_applicant_academic = new Zend_Session_Namespace(
        'applicant_academic');
        $this->_applicant_degreedetails = new Zend_Session_Namespace(
        'applicant_degreedetails');
        $this->view->assign('applicant', $this->_applicant);
        $this->view->assign('steps', 
        array('admissionbasis', 'academic', 'degreedetails'));
    }
    public function indexAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant->$colName = $value;
        }
        //print_r($params);
        $params['member_id'] = $this->_applicant->member_id;
        $params['department_id'] = $this->_applicant->department_id;
        $params['programme_id'] = $this->_applicant->programme_id;
        $params['semester_id'] = $this->_applicant->semester_id;
        $this->_redirect('profile/admissionbasis');
    }
    public function admissionbasisAction ()
    {
        $this->view->assign('stepNo', 0);
    }
    public function setadmissionbasisAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $params['member_id'] = $this->_applicant->member_id;
        $params['department_id'] = $this->_applicant->department_id;
        $params['programme_id'] = $this->_applicant->programme_id;
        $params['semester_id'] = $this->_applicant->semester_id;
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant->$colName = $value;
        }
        print_r($params);
        $this->_redirect('/profile/academic');
    }
    public function academicAction ()
    {
        $this->view->assign('stepNo', 1);
    }
    public function setacademicAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $params['member_id'] = 1;
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($value as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($params as $colName => $value) {
            $value = is_array($value) ? var_export($value, true) : htmlentities(
            trim($value));
            echo '<b>' . ucwords(str_ireplace('_', ' ', $colName)) . '</b> : ' .
             $value . '<br/>';
        }
        Zend_Registry::get('logger')->debug($params);
        //
        $twelfth_data = array();
        $tenth_data = array();
        $diploma_data = array();
        $aieee_data = array();
        //
        foreach ($params as $key => $value) {
            $element_id = substr($key, 0, 1);
            switch ($element_id) {
                case ('1'):
                    $twelfth_data[substr($key, 1)] = $value;
                    break;
                case ('2'):
                    $tenth_data[substr($key, 1)] = $value;
                    break;
                case ('3'):
                    $diploma_data[substr($key, 1)] = $value;
                    break;
                case ('4'):
                    $aieee_data[substr($key, 1)] = $value;
                    break;
            }
        }
        if (sizeof($tenth_data) != 0) {
            $tenth_data['member_id'] = $params['member_id'];
            $tenth_model = new Acad_Model_Exam_Aisse();
            $tenth_model->initSave();
            $tenth_model->save($tenth_data);
        }
        if (sizeof($diploma_data) != 0) {
            $diploma_data['member_id'] = $params['member_id'];
            $diploma_model = new Acad_Model_Programme_Diploma();
            $diploma_model->initSave();
            $diploma_model->save($diploma_data);
        }
        if (sizeof($twelfth_data) != 0) {
            $twelfth_data['member_id'] = $params['member_id'];
            $twelfth_model = new Acad_Model_Exam_Aissce();
            $twelfth_model->initSave();
            $twelfth_model->save($twelfth_data);
        }
        if (sizeof($aieee_data) != 0) {
            $aieee_data['member_id'] = $params['member_id'];
            $aieee_data['exam_id'] = '1';
            $aieee_model = new Acad_Model_Exam_Competitive();
            $aieee_model->initSave();
            $aieee_model->save($aieee_data);
        }
         //$URL = '/student/saveprofile' . '?' . http_build_query($params);
    }
    public function degreedetailsAction ()
    {
        $this->view->assign('stepNo', 2);
         //$this->view->assign('programme_id','btech');
    }
    public function setdegreedetailsAction ()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParam(), $request->getUserParams());
        $params['programme_id'] = $this->_applicant->programme_id;
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->helper->layout()->disableLayout();
        foreach ($value as $colName => $value) {
            $value = is_array($value) ? $value : htmlentities(trim($value));
            $this->_applicant->$colName = $value;
        }
        echo 'Following information recieved:<br/>';
        foreach ($value as $colName => $value) {
            $value = is_array($value) ? var_export($value, true) : htmlentities(
            trim($value));
            echo '<b>' . ucwords(str_ireplace('_', ' ', $colName)) . '</b> : ' .
             $value . '<br/>';
        }
    }
    public function testAction ()
    {
        $model = new Acad_Model_Programme_Subject();
        $model->setSubject_code('cse-101');
        $model->findAssociatedDepartments();
        $result = $model->getAssociated_departments();
        if (sizeof($result) != 0) {
            print_r($result);
        }
        $model->setDepartment_id('cse');
        $model->setProgramme_id('btech');
        $model->setSemester_id(6);
        $model->findSemesterSubjects();
        $res = $model->getSemester_subjects();
        Zend_Registry::get('logger')->debug($res);
    }
}