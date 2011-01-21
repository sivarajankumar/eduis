<?php

/**
 * BookController
 * 
 * @author
 * @version 
 */

class PublisherController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
		//$this->view->assign ( 'colSetup', self::gridsetup() );
	}
	
	public function fillgridAction() {
		self::getModel();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			$this->grid = $this->_helper->grid();
			$this->grid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'address' :
						case 'publisher_name' :
							$this->grid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'publisher_id' :
							$this->grid->sql->where ( "$key = ?", $value );
							break;
					}
				}
			}
			self::fillgridfinal ();
		
		} else {
			echo ('<b>Error!! </b><br/>)');
		}
	
	}
	
	public function ispublisherAction() {
		$publisher_id = $this->getRequest ()->getParam ( 'publisher_id' );
		$result = $this->model->find($publisher_id)->toArray();
		echo isset($result[0]['publisher_name']);
		
	}

}
?>

