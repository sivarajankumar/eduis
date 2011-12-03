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
	    self::createModel();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($valid) {
			$this->grid = $this->_helper->grid ();
			
			$this->grid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'isbn_id' :
						case 'year' :
							$this->grid->sql->where ( "$key = ?", $value );
							break;
						case 'title' :
						case 'long_title' :
						case 'author' :
						case 'place_publisher' :
							$this->grid->sql->where ( "$key LIKE ?", '%' . $value . '%' );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			echo ('<b>Oops!! </b><br/>No use of peeping like that.. :)');
		}
	}
	
	
	public function getbookimageAction() {
		self::getModel();
		$request = $this->getRequest ();
		$isbn_id = $request->getParam ( "isbn_id" );
		$book_image = $this->model->getBookGdata ( $isbn_id );
		$this->_helper->json ( $book_image );
	}

	public function getisbnlistAction() {
		$isbnString = $this->getRequest ()->getParam ( 'term' );
		$format = $this->getRequest ()->getParam ( 'format', 'json' );
		$isbn = new Lib_Model_Isbn();
		
		$result = $isbn->findIsbn($isbnString);
		switch (strtolower($format)) {
		    case 'json':
		        echo $this->_helper->json($result,false);
		    return;
		    
		    default:
		        ;
		    break;
		}
	}
}