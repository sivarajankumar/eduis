<?php
class Department_SubjectController extends Acadz_Base_BaseController {
	/*
     * @about Interface.
     */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
	}
	
	/*
     * Back end data provider to datagrid.
     * @return JSON data
     */
	public function fillgridAction() {
		$this->jqgrid = new Aceis_Base_Helper_Jqgrid ();
		self::createModel();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			
			$this->jqgrid->setGridparam ( $request );
			
			$this->jqgrid->sql = $this->model->select()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'subject_code' :
						case 'abbr' :
						case 'subject_name' :
						case 'subject_code' :
							$this->jqgrid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'subject_type_id' :
						case 'is_optional' :
						case 'lecture_per_week' :
						case 'tutorial_per_week' :
						case 'practical_per_week' :
						case 'suggested_duration' :
							$this->jqgrid->sql->where ( "$key = ?", $value );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			header ( "HTTP/1.1 403 Forbidden" );
		}
	
	}
	
	/*
	 * Show basic information of a subject.
	 * @return array 
	 */
	public function getsubjecinfoAction() {
		$request = $this->getRequest ();
		$format = $request->getParam ( 'format', 'json' );
		$subject_code = $request->getParam ( 'subject_code' );
		if (isset ( $subject_code ) ) {
			$result = Model_DbTable_Subject::getSubjectInfo ( $subject_code );
			switch (strtolower ( $format )) {
				case 'json' :
					$this->_helper->json($result);
					return;
				case 'select' :
					echo '<select>';
					echo '<option>Select one</option>';
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['batch_start'] . '">' . $row ['batch_start'] . '</option>';
					}
					echo '</select>';
					return;
				default :
					header ( "HTTP/1.1 400 Bad Request" );
					echo 'Unsupported format';
			}
		} else {
			header ( "HTTP/1.1 400 Bad Request" );
		}
	}
}

/*class Department_SubjectController extends Zend_Controller_Action {
	protected $request;
	protected $objSubjectFaculty;
	public function init() {
		$this->table = 'subject';
		$this->tblsubmode = 'subject_mode';  //This one is seprate now
		$this->tblsubfaculty = 'subject_faculty'; //This one is also seprate now

		$this->column = array ('subject_code', 'subject_name', 'abbr', 'subject_type_id', 'is_optional', 'lecture_per_week', 'tutorial_per_week', 'practical_per_week', 'span' );
		Zend_Db_Table::getDefaultAdapter ()->setFetchMode ( Zend_Db::FETCH_OBJ );
		
		$this->objSubjectFaculty = new Department_Model_DbTable_SubjectFaculty();

	}
	private function getData($sql = false) {
		if (is_array ( $this->column ))
		$fields = '`' . implode ( $this->column, '`, `' ) . '`';

		$sql = ($sql) ? $sql : 'Select ' . $fields . ' from ' . $this->table;
		$result = Zend_Db_Table::getDefaultAdapter ()->fetchAll ( $sql );
		return $result;
	}
	public function indexAction() {

	}

	////Add Subject :start
	public function fillgridAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();

		$result = $this->getData ();
		$total = count ( $result );

		$page = $_GET ['page']; // get the requested page
		$limit = $_GET ['rows']; // get how many rows we want to have into the grid
		$sidx = $_GET ['sidx']; // get index row - i.e. user click to sort
		$sord = $_GET ['sord']; // get the direction
		if (! $sidx)
		$sidx = 1;
		if (! $page)
		$page = 1;
		$total_pages = 5;
		$count = 30;
		$responce = new stdClass ( );
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $total;
		foreach ( $result as $key => $object ) {
			$responce->rows [$key] ['id'] = $object->subject_code;
			$responce->rows [$key] ['cell'] = array ($object->subject_code, $object->subject_name, $object->abbr, $object->subject_type_id, $object->is_optional, $object->lecture_per_week, $object->tutorial_per_week, $object->practical_per_week, $object->span );
		}
		echo json_encode ( $responce );
	}

	public function addsubjectAction() {
	}

	public function insertsubjectAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();

		//$ = $_GET [''];
		$myarr = array();
		$myarr['subject_code'] = $_GET ['subcode'];
		$myarr['abbr'] = $_GET ['subabbr'];
		$myarr['subject_name'] = $_GET ['subname'];
		$myarr['subject_type_id'] = $_GET ['subtype'];
		$myarr['is_optional'] = $_GET ['isopt'];
		//$myarr['lecture_per_week'] = $_GET ['lpw'];
		//$myarr['tutorial_per_week'] = $_GET ['tpw'];
		//$myarr['practical_per_week'] = $_GET ['ppw'];
		//$myarr['span'] = $_GET ['span'];

		$tbl = new Zend_Db_Table ( $this->table );
		$status = $tbl->insert ( $myarr );
		if ($status){
			echo 'Success';
			return true;
		}
		else{
			echo 'Fail';
			return false;
		}
	}

	////Add Subject end
	////////////////////////////


	////Add Subject mode start
	public function fillmodegridAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		$result = $this->getData ( "select subject_mode_id, subject_mode_name, subject_type_id from subject_mode" );
		$total = count ( $result );

		$page = $_GET ['page'];
		// get the requested page
		$limit = $_GET ['rows']; // get how many rows we want to have into the grid
		$sidx = $_GET ['sidx']; // get index row - i.e. user click to sort
		$sord = $_GET ['sord']; // get the direction
		if (! $sidx)
		$sidx = 1;
		if (! $page)
		$page = 1;
		$total_pages = 5;
		$count = 30;
		$responce = new stdClass ( );
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $total;
		$i = 0;
		foreach ( $result as $key => $object ) {
			$responce->rows [$key] ['id'] = $object->subject_mode_id;
			$responce->rows [$key] ['cell'] = array ($object->subject_mode_id, $object->subject_mode_name, $object->subject_type_id );
		}
		echo json_encode ( $responce );

	}
	public function addsubjectmodeAction() {
	}

	public function insertsubjectmodeAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		$modeid = $_GET ['modeid'];
		$modename = $_GET ['modename'];
		$subtype = $_GET ['subtype'];
		$status = Zend_Db_Table::getDefaultAdapter ()->insert ( $this->tblsubmode, array ('subject_mode_id' => $modeid, 'subject_mode_name' => $modename, 'subject_type_id' => $subtype ) );

		if ($status)
		return true;
		else
		return false;

	}
	////Add Subject mode end
	////////////////////////////


	////Assign Subject to faculty start
	public function fillsubjectfacultygridAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		$this->requset = $this->getRequest ();
		
		

		$page = $this->requset->getParam ( 'page' ); // get the requested page
		$limit = $this->requset->getParam ( 'rows' ); // get how many rows we want to have into the grid
		$sidx = $this->requset->getParam ( 'sidx' ); // get index row - i.e. user click to sort
		$sord = $this->requset->getParam ( 'sord' ); 
		$this->objSubjectFaculty->select()->limit($limit);
		$result = $this->objSubjectFaculty->getAllSubjectFaculty();
		$count = count ( $result ); 
		if (! $sidx)
		$sidx = 1;
		if ($count > 0) {
			$total_pages = ceil ( $count / $limit );
		} else {
			$total_pages = 0;
		}
		//if ($page > $total_pages)
			//$page = $total_pages;
			
		$start = $limit * $page - $limit;
		
		$responce = new stdClass ( );
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		
		foreach ( $result as $key => $value ) {
			$responce->rows [$key] ['id'] = $value['subject_code'];
			$responce->rows [$key] ['cell'] = array ($value['subject_code'], $value['subject_mode_id'], $value['staff_id'] );
		}
		echo json_encode ( $responce );
	}

	public function assignsubjectfacultyAction() {
		
		

	}

	public function insertsubjectfacultyAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		$deptid = $_GET ['deptid'];
		$staffid = $_GET ['staffid'];
		$subcode = $_GET ['subcode'];
		$submode = $_GET ['submode'];

		$status = Zend_Db_Table::getDefaultAdapter ()->insert ( $this->tblsubfaculty, array ('staff_id' => $staffid, 'subject_code' => $subcode, 'subject_mode_id' => $submode ) );

		if ($status)
		return true;
		else
		return false;

	}
	////Assign Subject to faculty end
	////////////////////////////


	////////combos//////////
	public function fillsubjecttypeAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		$result = $this->getData ( 'select subject_type_id,description from subject_type ' );

		echo "<option>Select one</option>";
		foreach ( $result as $key => $object ) {
			echo '<option value="' . $object->subject_type_id . '">' . $object->description . '</option>';
		}
	}

	public function fillmodecomboAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		$subcode = $_GET ['subcode'];
		$tst = $this->getData ( 'select subject_type_id from subject where subject_code="' . $subcode . '"' );
		$subtype = '';
		if (count ( $tst ) > 0)
		$subtype = $tst [0]->subject_type_id;

		$result = $this->getData ( 'select subject_mode_id,subject_mode_name from subject_mode where subject_type_id="' . $subtype . '"' );
		echo '<option value="">Select One</option> ';

		foreach ( $result as $key => $object ) {
			echo '<option value="' . $object->subject_mode_id . '">' . $object->subject_mode_id . '-' . $object->subject_mode_name . '</option>';
		}
	}
	public function fillsubjectfacultycomboAction() {
		$this->_helper->viewRenderer->setNoRender ();
		$this->_helper->layout ()->disableLayout ();
		$subcode = $_GET ['subcode'];
		$submode = $_GET ['submode'];

		$sql = "SELECT subject_faculty.staff_id,staff_personal.first_name,staff_personal.last_name FROM subject_faculty, staff_personal WHERE subject_faculty.subject_code=" . "'" . $subcode . "'" . " AND " . "subject_faculty.subject_mode_id= " . "'" . $submode . "'" . " AND " . "subject_faculty.staff_id = staff_personal.staff_id ";

		//$result = $this->getData ( 'select staff_id from subject_faculty where subject_code="' . $subcode . '"' . "and "  . "subject_mode_id=" . "'" . $submode . "'");
		$result = $this->getData ( $sql );
		echo '<option value="">Select One</option> ';
		foreach ( $result as $key => $object ) {
			echo '<option value="' . $object->staff_id . '">' . $object->staff_id . "-" . $object->first_name . " " . $object->last_name . '</option>';
		}

	}
}*/