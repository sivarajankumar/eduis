<?php
/**
 * To manage room types.
 * 
 * A room can be a lecture hall, tutorial room, LAB etc.
 *
 * @category   Aceis
 * @package    Default
 * @subpackage Room
 * @since	   0.1
 */
/**
 * RoomTypeController
 * 
 */
class RoomTypeController extends Corez_Base_BaseController {
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
	 * @about Back end data provider to datagrid.
	 * @return JSON data
	 */
	public function fillgridAction() {
		$this->grid = new $this->_helper->grid ();
		self::createModel ();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			
			$this->grid->setGridparam ( $request );
			
			$this->grid->sql = $this->table->select ()->from ( $this->table->info ( 'name' ) );
			/*
            $searchOn = $request->getParam ( '_search' );
            if ($searchOn != 'false') {
                $sarr = $request->getParams ();
                foreach ( $sarr as $key => $value ) {
                    switch ($key) {
                        case 'department_id' :
                        case 'degree_id' :
                            $this->grid->sql->where ( "$key LIKE ?", $value . '%' );
                            break;
                        case 'batch_start' :
                            $this->grid->sql->where ( "$key = ?", $value );
                            break;
                    }
                }
            }*/
			self::fillgridfinal ();
		
		} else {
			header ( "HTTP/1.1 403 Forbidden" );
		}
	
	}
	
	////////combos//////////
	public function getroomtypeAction() {
		$result = Core_Model_DbTable_RoomType::roomTypes ();
		$format = $this->getRequest ()->getParam ( 'format', 'json' );
		switch (strtolower ( $format )) {
			case 'json' :
				$this->_helper->json ( $result );
				return;
			case 'select' :
				echo '<select>';
				echo '<option>Select one</option>';
				foreach ( $result as $key => $row ) {
					echo '<option value="' . $row ['room_type_id'] . '">' . $row ['room_type_name'] . '</option>';
				}
				echo '</select>';
				return;
			default :
				header ( "HTTP/1.1 400 Bad Request" );
				echo 'Unsupported format';
		}
	}
}
