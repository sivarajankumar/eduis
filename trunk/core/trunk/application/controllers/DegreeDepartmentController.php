<?php
/**
 * @category   Aceis
 * @package    Default
 * @subpackage DegreeDepartment
 * @since	   0.1
 */
/*
 * Degree(s) provided by department.
 *
 */
class DegreeDepartmentController extends Corez_Base_BaseController
{
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
    ////////Combos
    public function getdepartmentAction ()
    {
        $request = $this->getRequest();
        $format = $this->getRequest()->getParam('format', 'json');
        $result = Core_Model_DbTable_Degreedepartment::academicDepartments();
        switch (strtolower($format)) {
            case 'json':
                $this->_helper->json($result);
                return;
            case 'jsonp':
                $callback = $request->getParam('onJsonPLoad');
                echo $callback . '(' . $this->_helper->json($result, false) . ')';
                return;
            case 'select':
                echo '<select>';
                echo '<option>Select one</option>';
                foreach ($result as $key => $row) {
                    echo '<option value="' . $row['department_id'] . '">' .
                     $row['department_id'] . '</option>';
                }
                echo '</select>';
                return;
                break;
        }
        header("HTTP/1.1 400 Bad Request");
    }
    public function getdegreeAction ()
    {
        $format = $this->getRequest()->getParam('format', 'json');
        $department = $this->getRequest()->getParam('department_id');
        if (isset($department)) {
            $result = Core_Model_DbTable_Degreedepartment::departmentDegree(
            $department);
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
                    foreach ($result as $key => $option) {
                        echo '<option value="' . $option['degree_id'] . '">' .
                         $option['degree_id'] . '</option>';
                    }
                    echo '</select>';
                    return;
                    break;
            }
        }
        header("HTTP/1.1 400 Bad Request");
    }
}
?>