<?php

/**
 * DocumenttypeController
 * 
 * @author
 * @version 
 */

class DocumenttypeController extends Libz_Base_BaseController {
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
	
	public function getdoctypeAction() {
		$format = $this->getRequest ()->getParam ( 'format', 'json' );
		$result = Lib_Model_DbTable_DocumentType::docTypes();
		switch (strtolower ( $format )) {
			case 'json' :
				$this->_helper->json ( $result );
				return;
			case 'select' :
				echo '<select>';
				echo '<option>Select One</option>';
				foreach ( $result as $key => $row ) {
					echo '<option value="' . $row ['document_type_id'] . '">' . $row ['document_type_name'] . '</option>';
				}
				echo '</select>';
				return;
			default :
				header ( "HTTP/1.1 400 Bad Request" );
				echo 'Unsupported format';
		}
	}

}
?>

