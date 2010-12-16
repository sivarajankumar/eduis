<?php

/**
 * IssuereturnController
 * 
 * @author
 * @version 
 */

class IssueController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	protected $objbook;
	protected $objisbn;
	
	public function init() {
		$this->table = new Lib_Model_DbTable_IssueReturn ( );
		parent::init ();
	}
	
	/*
     * @about Interface.
     */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
	}
	
	public function getbookinfoAction() {
		$request = $this->getRequest ();
		$acc_no = $request->getParam ( 'acc_no' );
		$formatted = true;
		if (isset ( $acc_no )) {
			$bookInfo = Model_DbTable_Book::getBookInfo ( $acc_no );
			/*
			 * Deprecated lines (in comments), can be cleaned up.
			if ($formatted and isset ( $bookInfo )) {
				$formattedDetail = array ();
				foreach ( $bookInfo as $key => $value ) {
					if (isset ( $value )) {
						$key = str_replace ( '_id', '', $key );
						$key = str_replace ( '_', ' ', $key );
						$key = ucwords ( $key );
						$formattedDetail [$key] = $value;
					}
				}
				$bookInfo = $formattedDetail;
			}*/
			$this->_helper->json( $bookInfo );
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo 'Insufficient parameters';
		
		}
		/*
     else {
			//$this->getResponse ()->setHttpResponseCode(400);
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo ("The accession number $acc_no not found");
			
			if ($this->debug) {
				$this->_helper->logger ( 'The accession number "' . $acc_no . '" didnt return any ISBN number.', Zend_Log::NOTICE );
			}
		}*/
	}
	
	public function getissueinfoAction() {
		$request = $this->getRequest ();
		$param ['member_id'] = $request->getParam ( 'member_id' );
		
		$result = $this->table->getissueInfo ( $param );
		/*
		$this->logger->log ( 'Issued Books', Zend_Log::INFO );
		$this->logger->log ( $result, Zend_Log::DEBUG );
		*/
		$page = $request->getParam ( 'page' ); // get the requested page
		$limit = $request->getParam ( 'rows' ); // get how many rows we want to have into the grid
		$sidx = $request->getParam ( 'sidx' ); // get index row - i.e. user click to sort
		$sord = $request->getParam ( 'sord' ); // get the direction
		if (! $sidx)
			$sidx = 1;
		$count = count ( $result );
		
		if ($count > 0) {
			$total_pages = ceil ( $count / $limit );
		} else {
			$total_pages = 0;
		}
		if ($page > $total_pages)
			$page = $total_pages;
		$start = $limit * $page - $limit;
		$responce = new stdClass ( );
		$responce->page = $page;
		$responce->total = $total_pages;
		$responce->records = $count;
		//$order = " ORDER BY $sidx $sord LIMIT $start , $limit";
		foreach ( $result as $key => $object ) {
			$responce->rows [$key] ['id'] = $object ['acc_no'];
			$responce->rows [$key] ['cell'] = array ($object ['acc_no'], $object ['issue_date'] );
		}
		/*
		$this->logger->log ( 'Issued Books', Zend_Log::INFO );
		$this->logger->log ( $responce, Zend_Log::DEBUG );
		*/
		$this->_helper->json ( $result );
	
	}
	/**
	 * Get book(s) issued to a member
	 * @param string member_id
	 */
	public function getissuedbooks() {
		$request = $this->getRequest ();
		$acc_no = $request->getParam ( 'member_id' );
	}
	public function issuebookAction() {
		$request = $this->getRequest ();
		$acc_no = $request->getParam ( 'acc_no' );
		$memberId = $request->getParam ( 'member_id' );
		if (isset ( $acc_no ) and isset ( $memberId )) {
			$bookInfo = Model_DbTable_Book::getBookInfo ( $acc_no );
			if ($this->debug) {
				$this->_helper->logger->notice ( 'Book Info' );
				$this->_helper->logger->debug ( $bookInfo );
			}
			if ('AVAILABLE' == strtoupper ( $bookInfo ['status'] )) {
				
				$memberConstraints = Model_DbTable_MemberLimit::getMemberLimit ( $memberId, $bookInfo ['document_type_id'] );
				if ($this->debug) {
					$this->_helper->logger->notice ( 'Member Constraints' );
					$this->_helper->logger->debug ( $memberConstraints );
				}
				// assuming that document type will be always 'reg'.
				$issuedCount = Model_DbTable_IssueReturn::getIssuedDocumentCount ( $memberId, $bookInfo ['document_type_id'] );
				if ($this->debug) {
					$this->_helper->logger->notice ( 'Issued Book Info' );
					$this->_helper->logger->debug ( $memberConstraints );
				}
				if ($issuedCount < $memberConstraints ['document_limit']) {
					$result ['trans_id'] = $this->table->issuebook ( $acc_no, $memberId );
					$result ['totBooksIssued'] = $issuedCount + 1;
					if ($this->debug) {
						$this->_helper->logger->notice ( 'Result' );
						$this->_helper->logger->debug ( $result );
					}
					$this->_helper->json ( $result );
				} else {
					$this->getResponse ()->setHttpResponseCode ( 400 );
					echo $issuedCount . ' books are already issued to ' . $memberId . '.<br/> (Max limit = ' . $memberConstraints ['document_limit'] . ')';
				}
			} else {
				$this->getResponse ()->setHttpResponseCode ( 400 );
				echo 'The acc number "' . $acc_no . '" is not "AVAILBLE".';
			}
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo 'Insufficient parameters';
		
		}
	
	}

}
?>

