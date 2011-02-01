<?php
class PeriodController extends Acadz_Base_BaseController
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
     * Back end data provider to datagrid.
     * @return JSON data
     */
    public function fillgridAction ()
    {
        $request = $this->getRequest();
        $valid = $request->getParam('nd');
        if ($request->isXmlHttpRequest() and $valid) {
            self::createModel();
            $this->grid = $this->_helper->grid();
            $this->grid->sql = $this->model->select()->from(
            $this->model->info('name'));
            $searchOn = $request->getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $request->getParams();
                foreach ($sarr as $key => $value) {
                    switch ($key) {
                        case 'department_id':
                        case 'degree_id':
                            $this->grid->sql->where("$key LIKE ?", 
                            $value . '%');
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
            die();
        }
    }
    /*
     * Get period's Id and Period Number.
     */
    public function getperiodAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $department = $request->getParam('department_id');
        $degree = $request->getParam('degree_id');
        $semester = $request->getParam('semester_id');
        $weekday = $request->getParam('weekday_number');
        if (isset($department) and isset($degree) and isset($semester) and
         isset($weekday)) {
            $result = Acad_Model_DbTable_Period::getPeriod($department, $degree, 
            (int) $semester, (int) $weekday);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'select':
                    echo '<select>';
                    echo '<option>Select one</option>';
                    foreach ($result as $key => $row) {
                        echo '<option value="' . $row['period_id'] . '">' .
                         $row['period_number'] . '</option>';
                    }
                    echo '</select>';
                    return;
                default:
                    header("HTTP/1.1 400 Bad Request");
                    echo 'Unsupported format';
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
        }
    }
    /*
	//Deprecated
	private function getData($sql = false) {
		$sql = ($sql) ? $sql : 'select period_number,start_time,duration from ' . $this->model;
		Zend_Db_Table::getDefaultAdapter ()->setFetchMode ( Zend_Db::FETCH_OBJ );
		$result = Zend_Db_Table::getDefaultAdapter ()->fetchAll ( $sql );
		return $result;
	}
	
	//Deprecated
	public function fillperiodcomboAction() {
		$this->_helper->viewRenderer->setNoRender ( true );
		$this->_helper->layout ()->disableLayout ();
		$degreeid = $_GET ['degreeid'];
		$deptid = $_GET ['deptid'];
		$semid = $_GET ['semid'];
		$weekday = $_GET ['weekday'];
		$where = 'WHERE period_type_id= "REG" ' . 'and degree_id="' . $degreeid . '"' . 'and department_id= "' . $deptid . '"' . 'and semester_id="' . $semid . '"' . 'and weekday_number="' . $weekday . '"';
		$sql = 'select period_number from period ' . $where;
		$result = $this->getData ( $sql );
		echo '<option value="">Select One</option>';
		foreach ( $result as $key => $object ) {
			echo '<option value="' . $object->period_number . '">' . $object->period_number . '</option>';
		}
	
	}
	
	//Deprecated
	public function dayperiodAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		//$request = $this->getRequest ();
		$department = 'CSE'; //$request->getParam ( 'department_id' );
		$degree = 'BTECH'; //$request->getParam ( 'degree_id' );
		$semester = '4'; //$request->getParam ( 'semester_id' );
		$adapter = Zend_Db_Table::getDefaultAdapter();
		
		/*
		 * Set Weekdays and periods
		 *
		$result = $this->model->getPeriod ( $department, $degree, ( int ) $semester );
		$daywise = array ();
		foreach ( $result as $key => $val ) {
			$daywise [$val ['weekday_number']] [$val ['period_number']] = $val ['period_id'];
		}
		$this->view->assign ( 'dayperiods', $daywise );
		
		/*
		 * Set Subjects
		 *
		
        $sql = 'SELECT
                    subject_department.subject_code
                    , subject.subject_name
                    , subject_mode.subject_mode_id
                    , subject_mode.group_together
                FROM
                    nwaceis.subject_department
                    INNER JOIN nwaceis.subject 
                        ON (subject_department.subject_code = subject.subject_code)
                    INNER JOIN nwaceis.subject_mode 
                        ON (subject.subject_type_id = subject_mode.subject_type_id)
                WHERE (subject_department.department_id = "'.$department.'"
                    AND subject_department.degree_id = "'.$degree.'"
                    AND subject_department.semester_id = "'.$semester.'")';
        
		$semesterSubjects = $adapter->fetchAll($sql);
		$subjectwise = array();
		foreach ($semesterSubjects as $num => $val) {
            $subjectwise[$val ['subject_code']]['subject_name'] = $val ['subject_name'];
            $subjectwise[$val ['subject_code']]['subject_mode_id'][$val ['subject_mode_id']] = $val ['group_together'];
		}
		$this->view->assign ( 'semesterSubjects', $subjectwise );
	}
	*/
}