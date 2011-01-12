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
class SemesterController extends Corez_Base_BaseController {
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
            $this->grid->sql = $this->table->select ()->from ( $this->table->info ( 'name' ) );
            $searchOn = $request->getParam ( '_search' );
            if ($searchOn != 'false') {
                $sarr = $request->getParams ();
                foreach ( $sarr as $key => $value ) {
                    switch ($key) {
                        case 'description' :
                            $this->grid->sql->where ( "$key LIKE ?", $value . '%' );
                            break;
                        case 'semester_id' :
                            $this->grid->sql->where ( "$key = ?", $value );
                            break;
                    }
                }
            }
			self::fillgridfinal ();
		
		} else {
			header ( "HTTP/1.1 403 Forbidden" );
		}
	}
}
