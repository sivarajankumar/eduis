<?php

/**
 * ReturnController
 * 
 * @author
 * @version 
 */

class ReturnController extends Aceis_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	protected $objIssueReturn;
	
	public function init() {
		$this->objIssueReturn = new Model_DbTable_IssueReturn ();
		parent::init ();
	}
	public function indexAction() {
		
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
	}
	
	public function returnbookAction() {
		$request = $this->getRequest ();
		$acc_no = $request->getParam ( 'acc_no' );
		$issue_Date = $request->getParam ( 'issue_date' );
		try {
			if (isset ( $acc_no ) and isset ( $issue_Date )) {
				$objIssueDate = new Zend_Date ( $issue_Date );
				//$staff_detail = $_SESSION['staff_detail'];
				$accepted_by = 'test_temp'; //$staff_detail[0]['first_name'] . ' '. $staff_detail[0]['last_name'] ;
				$rowUpdated = $this->objIssueReturn->returnBook ( $acc_no, $objIssueDate->toString ( 'YYYY-MM-dd HH:mm:ss' ), $accepted_by );
				if ($rowUpdated > 0) {
					echo $this->_helper->json ( 'ACC No ' . $acc_no . ' Book Returned Successfully' );
				} else {
					echo $this->_helper->json ( 'ACC No ' . $acc_no . " Book Not Returned" );
				}
			
			} else {
				$this->getResponse ()->setHttpResponseCode ( 400 );
				echo 'Parameters are insufficient to process.';
			}
		} catch ( Exception $ex ) {
			$this->getResponse ()->setHttpResponseCode ( 500 );
			echo $ex->getMessage ();
		}
		;
	}

}
?>

