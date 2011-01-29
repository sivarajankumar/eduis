<?php
class TimeTableController extends Acadz_Base_BaseController
{
    protected $objsubject;
    protected $department_id;
    public function init ()
    {
        $this->model = new Acad_Model_DbTable_TimeTable();
        //$this->objsubject = new Department_Model_DbTable_Subject ( );
        $this->dbCols[] = 'department_id';
        $this->dbCols[] = 'period_id';
        $this->dbCols[] = 'period';
        $this->dbCols[] = 'subject_code';
        $this->dbCols[] = 'subject_mode_id';
        $this->dbCols[] = 'staff_id';
        $this->dbCols[] = 'group_id';
        $this->dbCols[] = 'period_duration';
        //$this->dbCols [] = 'block_id';
        //$this->dbCols [] = 'room_id';
        //$this->dbCols [] = 'valid_upto';
        $this->dbCols[] = 'valid_from';
        $this->department_id = 'CSE';
        //$this->objtimetable = new Department_Model_DbTable_TimeTable ( );
        //$this->_autoModel = TRUE;
        //$this->_autoDbCols = TRUE;
        parent::init();
    }
    /*
     * @about Interface.
     */
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
        $masterDepartment = $this->department_id;
        $this->view->assign('masterDepartment', $masterDepartment);
        $this->view->assign('slaveDepartment', 'CSE');
        //Model_DbTable_SemesterDegree::slaveDepartment($masterDepartment));
    }
    public function fillgridAction ()
    {
        $request = $this->getRequest();
        $valid = $request->getParam('nd');
        $upcoming = $request->getParam('upcoming');
        if ($valid) {
            $this->grid = $this->_helper->grid();
            $masterDepartment = $this->department_id;
            $slaves = Acad_Model_DbTable_SemesterDegree::slaveInfo($masterDepartment, 
            'thisSessionOnly', 'showDegree', 'showSemester');
            $where = '';
            $setOr = false;
            foreach ($slaves as $num => $slave) {
                if ($setOr) {
                    $where .= ' OR ';
                }
                $setAnd = false;
                $where .= ' ( `prd`.';
                foreach ($slave as $column => $value) {
                    if ($setAnd) {
                        $where .= ' AND ';
                    }
                    $where .= $this->model->getAdapter()->quoteInto(
                    "$column = ?", $value);
                    $setAnd = true;
                }
                $where .= ' ) ';
                $setOr = true;
            }
            $sql = Zend_Db_Table::getDefaultAdapter()->select()
                ->from(array('prd' => 'period'), 
            array('department_id', 'degree_id', 'semester_id', 
            'weekday_number', 'period_number'))
                ->join(array('tt' => 'timetable'), 
            '`prd`.period_id = `tt`.period_id', 
            array('timetable_id', 'subject_code', 'subject_mode_id', 'group_id', 
            'staff_id', 'period_duration', 
            'periods_covered', 'valid_from', 'valid_upto', 'block_id', 'room_id'));
            if ($upcoming) {
                $sql->where(
                '( `tt`.valid_from > CURDATE() AND CURDATE() < `tt`.valid_upto)');
            } else {
                $sql->where(
                '(CURDATE() BETWEEN `tt`.valid_from AND `tt`.valid_upto)');
            }
            /*
           if ($this->debug) {
				$this->_helper->logger($where);
			}*/
            if ($where) {
                $sql->where($where);
            }
            $searchOn = $request->getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $request->getParams();
                foreach ($sarr as $key => $value) {
                    switch ($key) {
                        case 'department_id':
                            $sql->where("prd.department_id LIKE ?", 
                            $value . '%');
                            break;
                        case 'weekday_number':
                            $sql->where("weekday_number LIKE ?", 
                            $value . '%');
                            break;
                        case 'period_number':
                            $sql->where("prd.period_number = ?", $value);
                            break;
                        case 'group_id':
                            $sql->where("$key = ?", $value);
                            break;
                        case 'staff_id':
                            $sql->where("first_name LIKE ?", $value . '%');
                            break;
                        case 'semester_id,weekday_number':
                            $sql->where("semester_id = ?", $value);
                            break;
                        case 'degree_id':
                        case 'subject_code':
                        case 'subject_mode_id':
                            $sql->where("$key LIKE ?", $value . '%');
                            break;
                        default:
                            if ($this->debug) {
                                $this->_helper->logger(
                                "Search : key = $key and value = $value.");
                            }
                    }
                }
            }
            $this->grid->sql = $sql;
            self::fillgridfinal();
        } else {
            echo ('<b>Oops!! </b><br/>No use of peeping like that.. :)');
        }
    }
    protected function fillgridfinal ()
    {
        $response = $this->grid->prepareResponse();
        $result = $this->grid->fetchdata();
        foreach ($result as $key => $row) {
            $gridTuplekey = $row['timetable_id'];
            unset($row['timetable_id']);
            $response->rows[$key]['id'] = $gridTuplekey;
            $response->rows[$key]['cell'] = array_values($row);
        }
        echo json_encode($response);
         //$this->_helper->json($response);
    }
    // Deprecated
    /*
     * To fill the valid_upto entry of the provided timetable-ids 
     * DEPRECATED since V2
     */
    /*public function endvalidAction() {
		$noMoreValids = $this->getRequest ()->getParam ( 'nomorevalid' );
		$noMoreValids = explode ( ",", $noMoreValids );
		if (isset ( $noMoreValids )) {
			try {
				$this->model->markTTidsInvalid ( $noMoreValids );
			} catch ( Zend_Exception $e ) {
				if (isset ( $this->debug )) {
					$this->getResponse ()->setHttpResponseCode ( 400 )->sendResponse ();
					$this->_helper->logger->err ( $e->getTraceAsString () );
					echo 'Sorry, request not processed';
				}
			
			}
		
		}
	}*/
    //Should not be here. deprecated. shift to wrapper classes
    /*public function getfacultydeptsubjectsAction() {
		$request = $this->getRequest ();
		$params ['department_id'] = $request->getParam ( 'department_id' );
		$params ['staff_id'] = $request->getParam ( 'staff_id' );
		$resultSet = $this->model->gettimetableinfo ( $params, 'subject_code' );
		echo "<select><option>Select one</option>";
		foreach ( $resultSet as $key => $data ) {
			$this->objsubject->dbSelect->reset ();
			$result = $this->objsubject->getSubjectInfo ( $data ['subject_code'] );
			echo '<option value="' . $result [0] ['subject_code'] . '">';
			echo $result [0] ['subject_code'] . '  ' . $result [0] ['subject_name'];
			echo '</option>';
		}
		echo "</select>";
	}*/
    public function mytimetableAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $auth_details = $_SESSION['staff_detail'];
        $staff_id = $auth_details['staff_id'];
        $this->view->assign('staff_id', $staff_id);
         //$week_Periods = Department_Model_DbTable_TimeTable::getFacultyDayPeriods ( $staff_id);
    //$this->_helper->json($week_Periods);
    //print_r($week_Periods);	
    }
    public function getperiodstatusAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $periodId = $request->getParam('period_id');
        if (isset($periodId)) {
            $result = $this->model->periodStatus($periodId);
            $this->_helper->logger->debug($result);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    //echo json_encode($result);
                    return;
                    break;
                case 'select':
                    echo $result;
                    return;
                    break;
            }
        }
        header("HTTP/1.1 400 Bad Request");
        echo 'Oops!! Inputs are incorrect.';
    }
    public function getavailablegroupAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format');
        $periodId = $request->getParam('period_id');
        if (isset($periodId)) {
            $result = $this->model->availableGroup($periodId);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                    break;
                case 'select':
                    echo '<select>';
                    echo '<option value="">Select one</option>';
                    foreach ($result as $key => $row) {
                        echo '<option value="' . $row['group_id'] . '">' .
                         $row['group_id'] . '</option>';
                    }
                    echo '</select>';
                    return;
                    break;
            }
        }
        header("HTTP/1.1 400 Bad Request");
    }
    public function isvaliddurationAction ()
    {
        $objPeriod = new Acad_Model_DbTable_Period();
        $request = $this->getRequest();
        $department_id = $request->getParam('department_id');
        $degree_id = $request->getParam('degree_id');
        $semester_id = $request->getParam('semester_id');
        $weekday_number = $request->getParam('weekday_number');
        $period_id = $request->getParam('period_id');
        $period_detail = $objPeriod->getIdPeriod($period_id);
        $period_number = $period_detail['period_number'];
        $tmpperiod_number = $period_number;
        $groups = Acad_Model_DbTable_Groups::getClassGroups ( $department_id, $degree_id );
        $totalgroups = count($groups);
        array_push($groups, array('group_id' => "ALL"));
        $grpcnt = 0;
        $tmpspan = 0;
        $notavailablegroups = array();
        $cnt = 0;
        while ($tmpperiod_number > 1 && $grpcnt < $totalgroups) {
            $tmpspan ++;
            $tmpperiod_number = $tmpperiod_number - 1;
            $tmpperiod_id = $objPeriod->getPeriod($department_id, $degree_id, 
            $semester_id, $weekday_number, $tmpperiod_number);
            $period_id = $tmpperiod_id[0]['period_id'];
            $group_detail = $this->model->groupPeroidDuration($period_id, 
            $groups);
            if (count($group_detail) == 0) {
                continue;
            }
            $grpcnt = $grpcnt + count($group_detail);
            foreach ($group_detail as $key => $value) {
                if ($value['period_duration'] > $tmpspan) {
                    $notavailablegroups[$cnt] = $value['group_id'];
                }
                if ($value['group_id'] == 'ALL') {
                    $grpcnt = $totalgroups;
                    break;
                }
                foreach ($groups as $tmpkey => $tmpvalue) {
                    if ($tmpvalue['group_id'] == $value['group_id']) {
                        unset($groups[$tmpkey]);
                    }
                }
            }
        }
        print_r($notavailablegroups);
    }
    public function getdepartmentfacultyAction ()
    {
        $request = $this->getRequest();
        $department_id = $request->getParam('department_id');
        if (isset($department_id)) {
            $resultSet = Acad_Model_DbTable_Timetable::getDepartmentSubjectFaculty(
            $department_id);
            $this->_helper->json($resultSet);
        }
    }
    public function tempAction ()
    {
        echo '<pre>';
        //$obj = new Acad_Model_DbTable_TimeTable();
        //$var = Acad_Model_DbTable_TimeTable::currentPeriodStatus('438', TRUE);
        $var = Acad_Model_DbTable_AcademicSession::getSessionEndDate();
        print_r($var);
    }
}