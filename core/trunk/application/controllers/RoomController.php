<?php
/**
 * To manage room information of a block/building.
 *
 * @category   Aceis
 * @package    Default
 * @subpackage Room
 * @since	   0.1
 */
/**
 * RoomController
 * 
 */
class RoomController extends Corez_Base_BaseController {
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
		self::createModel ();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			$this->grid = new $this->_helper->grid ( );
			
			$this->grid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
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
	public function getroomAction() {
		$block_id = $this->getRequest ()->getParam ( 'block_id' );
		$format = $this->getRequest ()->getParam ( 'format', 'json' );
		if (isset ( $block_id )) {
			$result = Core_Model_DbTable_Room::getRooms ( $block_id );
			switch (strtolower ( $format )) {
				case 'json' :
					$this->_helper->json ( $result );
					return;
				case 'select' :
					echo '<select>';
					echo '<option>Select one</option>';
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['room_id'] . '">' . $row ['room_type_id'] . ' - ' . $row ['room_id'] . '</option>';
					}
					echo '</select>';
					return;
			}
		}
		
		header ( "HTTP/1.1 400 Bad Request" );
		echo 'Either format type not supported or incorrect.';
		die ();
	
	}
}