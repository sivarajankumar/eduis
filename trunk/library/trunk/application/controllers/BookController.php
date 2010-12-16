<?php

/**
 * BookController
 *
 * @author
 * @version
 */

class BookController extends Libz_Base_BaseController {

	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
		//$this->view->assign ( 'colSetup', self::gridsetup () );
	}
	
	public function fillgridAction() {
		$this->jqgrid = new Aceis_Base_Helper_Jqgrid ();
		self::createModel ();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($request->isXmlHttpRequest () and $valid) {
			
			$this->jqgrid->setGridparam ( $request );
			
			$this->jqgrid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'isbn_id' :
						case 'document_type_id' :
							$this->jqgrid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'status' :
						case 'acc_no' :
							$this->jqgrid->sql->where ( "$key = ?", $value );
							break;
					}
				}
			}
			$this->fillgridfinal ();
		
		} else {
			echo ('<b>Error!! </b><br/>)');
		}
	
	}
	
	public function getbookdetailsAction() {
		self::createModel ();
		$request = $this->getRequest ();
		$acc_no = $request->getParam ( 'acc_no' );
		$objIsbn = new Model_DbTable_Isbn ();
		$objIssueReturn = new Model_DbTable_IssueReturn ();
		$issueDate = NULL;
		$bookStatus = 0; // Book is not issued
		if (isset ( $acc_no )) {
			$isbn_id = $this->model->getbookIsbn ( $acc_no );
			if ($isbn_id != NULL) {
				$isbn_Details = $objIsbn->getIsbnDetails ( $isbn_id );
				$issueDate = $objIssueReturn->getBookIssueDate ( $acc_no );
				if ($issueDate != NULL) {
					$objissue_date = new Zend_Date ( $issueDate, Zend_Date::ISO_8601 );
					$borrower_id = $objIssueReturn->getBookBorrower ( $acc_no );
					$isbn_Details ['member_id'] = $borrower_id;
					$book_details = Model_DbTable_Book::getBookInfo ( $acc_no );
					$document_type = $book_details ['document_type_id'];
					$member_limit = Model_DbTable_MemberLimit::getMemberLimit ( $borrower_id, $document_type );
					
					if (isset ( $_SESSION ['dateFormat'] )) {
						$dateFormat = $_SESSION ['dateFormat'];
					} else {
						$dateFormat = 'dd/MMM/yyyy';
					}
					$isbn_Details ['issue_date'] = $objissue_date->toString ( $dateFormat );
					
					$exp_return_date = $objissue_date->addDay ( $member_limit ['day_limit'] );
					$day_late = 0;
					$objtoday = new Zend_Date ( Zend_Date::now (), $dateFormat );
					if ($exp_return_date->isToday () || $objtoday->isEarlier ( $exp_return_date )) {
						$day_late = 0;
					} else {
						$objtoday->sub ( $exp_return_date );
						$day_late = $objtoday->get ( Zend_Date::DAY ) - 2;
					}
					
					$isbn_Details ['exp_return_date'] = $exp_return_date->toString ( $dateFormat );
					$isbn_Details ['day_late'] = $day_late;
					$bookStatus = 1;
				}
				$isbn_Details ["status"] = $bookStatus;
				$this->_helper->json ( $isbn_Details );
			} else {
				$this->getResponse ()->setHttpResponseCode ( 400 );
				echo ('Either the Acc No "' . $acc_no . '" or its corrosponding ISBN is invalid.');
			}
		
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo 'Parameters are insufficient to process.';
		}
	
	}
	
	/*
	 * Show values of "status" column of Book table.
	 * @return array 
	 */
	public function getstatusvalAction() {
		self::createModel ();
		$request = $this->getRequest ();
		$format = $request->getParam ( 'format', 'json' );
		$result = $this->model->statusColValues ();
		switch (strtolower ( $format )) {
			case 'json' :
				$this->_helper->json ( $result );
				return;
			case 'select' :
				echo '<select>';
				echo '<option>Select one</option>';
				foreach ( $result as $key => $row ) {
					echo '<option value="' . $row ['options'] . '">' . ucfirst ( strtolower ( $row ['options'] ) ) . '</option>';
				}
				echo '</select>';
				return;
			default :
				header ( "HTTP/1.1 400 Bad Request" );
				echo 'Unsupported format';
		}
	
	}

}