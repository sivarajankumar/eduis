<?php
/**
 * @author HeAvi
 *
 */
class IsbnController extends Libz_Base_BaseController {
	
	/*
     * @about Interface.
     */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
		//$this->view->assign ( 'colSetup', self::gridsetup() );
	}
	
	/*
     * @about Back end data provider to datagrid.
     * @return JSON data
     */
	public function fillgridAction() {
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($valid) {
			$this->jqgrid->setGridparam ( $request );
			
			$this->jqgrid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'isbn_id' :
							$this->jqgrid->sql->where ( "$key = ?", $value );
							break;
						case 'title' :
						case 'long_title' :
						case 'author' :
							$this->jqgrid->sql->where ( "$key LIKE ?", '%'. $value . '%' );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			echo ('<b>Oops!! </b><br/>No use of peeping like that.. :)');
		}
	}
	public function getbookimageAction()
	{
		$request = $this->getRequest();
		$isbn_id = $request->getParam("isbn_id");
		$book_image= $this->model->getBookGdata($isbn_id); 
		$this->_helper->json($book_image);
	}
	
	
	
	
}