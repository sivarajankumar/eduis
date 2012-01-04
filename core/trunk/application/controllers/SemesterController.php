<?php
/**
 * To manage semesters.
 *
 * @category   Aceis
 * @package    Default
 * @subpackage Semester
 * @since	   0.1
 */
/**
 * SemesterController
 * 
 */
class SemesterController extends Corez_Base_BaseController
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
                        case 'description':
                            $this->grid->sql->where("$key LIKE ?", $value . '%');
                            break;
                        case 'semester_id':
                            $this->grid->sql->where("$key = ?", $value);
                            break;
                    }
                }
            }
            self::fillgridfinal();
        } else {
            header("HTTP/1.1 403 Forbidden");
        }
    }
    public function getstudentsAction ()
    {
        $request = $this->getRequest();
        $department = $request->getParam('department_id');
        $degree = $request->getParam('degree_id');
        $semester = $request->getParam('semester_id');
        $group = $request->getParam('group_id');
        $format = $this->getRequest()->getParam('format', 'json');
        if (isset($department) and isset($degree) and isset($semester)) {
            $result = Core_Model_DbTable_StudentDepartment::getClassStudent(
            $department, $degree, $semester, $group);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'jsonp':
                    $callback = $this->getRequest()->getParam('callback');
                    echo $callback . '(' . $this->_helper->json($result, false) .
                     ')';
                    return;
                case 'select':
                    echo '<select>';
                    echo '<option>Select one</option>';
                    foreach ($result as $key => $row) {
                        echo '<option value="' . $row['batch_start'] . '">' .
                         $row['batch_start'] . '</option>';
                    }
                    echo '</select>';
                    return;
                default:
                    $this->getResponse()
                        ->setException('Unsupported format request')
                        ->setHttpResponseCode(400);
            }
        }
    }
}
