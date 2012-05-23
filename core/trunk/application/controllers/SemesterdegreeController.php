<?php
/**
 * @category   Aceis
 * @package    Default
 * @subpackage SemesterDegree
 * @since	   0.1
 */
/**
 * To manage semester in a degree.
 *
 */
class SemesterdegreeController extends Corez_Base_BaseController
{
    /*
     * @about Interface.
     */
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
    }
    /*
	 * @about Back end data provider to datagrid.
	 * @return JSON data
	 */
    public function fillgridAction ()
    {
        self::createModel();
        $request = $this->getRequest();
        $valid = $request->getParam('nd');
        if ($request->isXmlHttpRequest() and $valid) {
            $this->grid = new $this->_helper->grid();
            $this->grid->sql = $this->model->select()->from(
            $this->model->info('name'));
            $searchOn = $request->getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $request->getParams();
                foreach ($sarr as $key => $value) {
                    switch ($key) {
                        case 'department_id':
                        case 'degree_id':
                        case 'semester_id':
                        case 'semester_duration':
                        case 'semester_type_id':
                            $this->grid->sql->where("$key LIKE ?", $value . '%');
                            break;
                    }
                }
            }
            self::fillgridfinal();
        } else {
            header("HTTP/1.1 403 Forbidden");
        }
    }
    /*
	 * All Semesters of a department
	 */
    public function getsemesterAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $degree = $request->getParam('degree_id');
        $department = $request->getParam('department_id');
        if (isset($degree) and isset($department)) {
            $result = Core_Model_DbTable_SemesterDegree::allSemesters(
            $department, $degree);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'select':
                    echo '<option value="">Select one</option>';
                    foreach ($result as $key => $option) {
                        echo '<option value="' . $option['semester_id'] . '">' .
                         $option['semester_id'] . '</option>';
                    }
                    return;
                default:
                    header("HTTP/1.1 400 Bad Request");
                    echo 'Unsupported format';
            }
        }
        header("HTTP/1.1 400 Bad Request");
        echo 'Oops!! Inputs are incorrect.';
    }
    /*
	 * Either 'EVEN' or 'ODD' semesters of department according to current session
	 */
    public function getsessionsemesterAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $degree = $request->getParam('degree_id');
        $department = $request->getParam('department_id');
        if (isset($degree) and isset($department)) {
            $result = Core_Model_DbTable_SemesterDegree::semesters($department, 
            $degree, TRUE);
            if (count($result)) {
                switch (strtolower($format)) {
                    case 'json':
                        $this->_helper->json($result);
                        return;
                case 'jsonp':
                    $callback = $request->getParam('callback');
                    echo $callback.'('.$this->_helper->json($result, false).')';
                    return;
                case 'select':
                    echo '<select>';
                    echo '<option value="">Select one</option>';
                    foreach ($result as $key => $option) {
                        echo '<option value="' . $option['semester_id'] .
                         '">' . $option['semester_id'] . '</option>';
                    }
                    echo '</select>';
                    return;
                }
            } else {
                header("HTTP/1.1 400 Bad Request");
                echo 'No semesters returned: Either session is over or inputs are wrong.';
                return;
            }
        }
        header("HTTP/1.1 400 Bad Request");
        echo 'Inputs are incorrect.';
    }
    /**
     * Either 'EVEN' or 'ODD' semesters of department according to current session
     */
    public function getslavedegreeAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $masterDepartment = $request->getParam('masterDepartment');
        $slaveDepartment = $request->getParam('slaveDepartment');
        if (isset($masterDepartment)) {
            $result = Core_Model_DbTable_SemesterDegree::slaveDegree(
            $masterDepartment, $slaveDepartment);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'jsonp':
                    $callback = $request->getParam('callback');
                    echo $callback.'('.$this->_helper->json($result, false).')';
                    return;
                case 'select':
                    echo '<select>';
                    echo '<option>Select one</option>';
                    foreach ($result as $key => $option) {
                        echo '<option value="' . $option['degree_id'] . '">' .
                         $option['degree_id'] . '</option>';
                    }
                    echo '</select>';
                    return;
            }
        }
        header("HTTP/1.1 400 Bad Request");
        echo 'Input params are incorrect.';
    }
    /**
     * Either 'EVEN' or 'ODD' semesters of department according to current session
     */
    public function getslaveinfoAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $masterDepartment = $request->getParam('masterDepartment');
        $currentSession = $request->getParam('currentSession');
        $degree = $request->getParam('degree');
        $semester = $request->getParam('semseter');
        if (isset($masterDepartment)) {
            $result = Core_Model_DbTable_SemesterDegree::slaveInfo($masterDepartment, 
                                                                    $currentSession, 
                                                                    $degree, 
                                                                    $semester);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'jsonp':
                    $callback = $request->getParam('callback');
                    echo $callback.'('.$this->_helper->json($result, false).')';
                    return;
                case 'select':
                    /*echo '<select>';
                    echo '<option>Select one</option>';
                    foreach ($result as $key => $option) {
                        echo '<option value="' . $option['degree_id'] . '">' .
                         $option['degree_id'] . '</option>';
                    }
                    echo '</select>';*/
                    return;
            }
        }
        header("HTTP/1.1 400 Bad Request");
        echo 'Input params are incorrect.';
    }
}
