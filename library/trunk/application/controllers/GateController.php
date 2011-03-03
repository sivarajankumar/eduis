<?php

/**
 * ReturnController
 * 
 * @author
 * @version 
 */

class GateController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
	}
	
	public function checkAction() {
		$this->model = new Lib_Model_DbTable_IssueReturn ();
		$request = $this->getRequest ();
		$acc_no = $request->getParam ( 'acc_no' );
		$issue_Date = $request->getParam ( 'issue_date' );
		if (isset ( $acc_no )) {
			if ($this->model->returnBook ( $acc_no )) {
				echo $acc_no.' successfully recieved by <user>';
			} else {
				throw new Zend_Exception('The acc no "'.$acc_no.'" could not be accepted.', Zend_Log::WARN);
			}
		
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo 'Parameters are insufficient to process.';
		}
	}

}
?>

