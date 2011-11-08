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
		self::createModel ();
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		
		if ($request->isXmlHttpRequest () and $valid) {
			$this->grid = $this->_helper->grid ();
			
			$this->grid->sql = $this->model->select ()->from ( $this->model->info ( 'name' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'isbn_id' :
						case 'document_type_id' :
							$this->grid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'status' :
						case 'acc_no' :
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
	
	public function getbookdetailsAction() {
		self::createModel ();
		$request = $this->getRequest ();
		$acc_no = $request->getParam ( 'acc_no' );
		$objIsbn = new Lib_Model_DbTable_Isbn ();
		$objIssueReturn = new Lib_Model_DbTable_IssueReturn ();
		
		$book = array();
		
		if (isset ( $acc_no )) {
			$bookInfo = Lib_Model_DbTable_Book::getBookInfo ( $acc_no );
			if (isset($bookInfo['isbn_id'])) {
				$book = $objIsbn->getIsbnDetails ( $bookInfo['isbn_id'] );
				$bookIssued = $objIssueReturn->getIssuedBookInfo ( $acc_no );
				//$this->_helper->logger($bookIssued);
				if ($bookIssued) {
					$issueDate = new Zend_Date ( $bookIssued['issue_date'], Zend_Date::ISO_8601 );
					$book ['member_id'] = $bookIssued['member_id'];
					$member_limit = Lib_Model_DbTable_MembershipLimit::getMemberLimit ( $book ['member_id'], $bookInfo ['document_type_id'] );
					
					if (isset ( $_SESSION ['dateFormat'] )) {
						$dateFormat = $_SESSION ['dateFormat'];
					} else {
						$dateFormat = 'dd/MMM/yyyy';
					}
					$book ['issue_date'] = $issueDate->toString ( $dateFormat );
					
					$exp_return_date = $issueDate->addDay ( $member_limit ['day_limit'] );
					$day_late = 0;
					$objtoday = new Zend_Date ( Zend_Date::now (), $dateFormat );
					if ($exp_return_date->isToday () || $objtoday->isEarlier ( $exp_return_date )) {
						$day_late = 0;
					} else {
						$objtoday->sub ( $exp_return_date );
						$day_late = $objtoday->get ( Zend_Date::DAY ) - 2;
					}
					
					$book ['exp_return_date'] = $exp_return_date->toString ( $dateFormat );
					$book ['day_late'] = $day_late;
					$bookStatus = 1;
				}
				
				$book['bookInfo'] = $bookInfo;
				$this->_helper->json ( $book );
				//echo Zend_Json::encode($book);
			} else {
				$this->getResponse ()->setHttpResponseCode ( 400 );
				echo ('Either the Acc No "' . $acc_no . '" or its corrosponding ISBN is invalid.');
			}
		
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo 'Parameters are insufficient to process.';
		}
	
	}
	

	public function getbookAction() {
		self::createModel ();
		$request = $this->getRequest ();
		$acc_no = $request->getParam ( 'acc_no' );
		$objIsbn = new Lib_Model_DbTable_Isbn ();
		
		$book = array();
		
		if (isset ( $acc_no )) {
			$bookInfo = Lib_Model_DbTable_Book::getBookInfo ( $acc_no );
			if (isset($bookInfo['isbn_id'])) {
				$book = $objIsbn->getIsbnDetails ( $bookInfo['isbn_id'] );
				//$this->_helper->logger($bookIssued);
				$book['bookInfo'] = $bookInfo;
				$this->_helper->json ( $book );
				//echo Zend_Json::encode($book);
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

	public function circulationAction() {
		$request = $this->getRequest ();
		$process = $request->getParam ( 'process');
		$pDate = $request->getParam ( 'date');
		$format = $request->getParam ( 'format', 'html' );
		$book = new Lib_Model_Document_Book();
        if ($pDate) {
            $dateObj = new Zend_Date($pDate, 'dd-MM-YYYY');
        } else {
            $dateObj = new Zend_Date();
        }
		$result = $book->datewiseCirculation($dateObj, $process);
		switch (strtolower ( $format )) {
			case 'html' :
        		$this->_helper->viewRenderer->setNoRender ( false );
        		$this->_helper->layout ()->enableLayout ();
        		
			    $this->view->assign('transSet',$result);
			    $this->view->assign('date',$dateObj);
			    $this->view->assign('process',$process);
				return;
			case 'json' :
				$this->_helper->json ( $result );
				return;
			case 'test' :
			    $this->_helper->logger->debug($result);
				return;
			case 'select' :
				return;
			default :
			    throw new Exception("Unsupported format '$format'", Zend_Log::NOTICE);
		}
	}
}