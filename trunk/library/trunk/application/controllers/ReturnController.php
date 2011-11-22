<?php

/**
 * ReturnController
 * 
 * @author
 * @version 
 */

class ReturnController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
	}
	
	public function returnbookAction() {
	    $authContent = Zend_Auth::getInstance()->getIdentity();
	    if (!isset($authContent['identity'])) {
	        throw new Zend_Exception('Book cannot be recieved by unknown person. :<', Zend_Log::WARN);
	    }
		$this->model = new Lib_Model_DbTable_IssueReturn ();
		$request = $this->getRequest ();
		$acc_no = $request->getParam ( 'acc_no' );
		$issue_Date = $request->getParam ( 'issue_date' );
		if (isset ( $acc_no )) {
			if ($this->model->returnBook ( $acc_no )) {
				echo $acc_no.' successfully recieved by '.$authContent['identity'];
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

