<?php

/**
 * MemberController
 * 
 * @author
 * @version 
 */

class MemberController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function init() {
		$this->table = new Model_DbTable_Member ( );
		parent::init ();
	}
	
	public function getmemberinfoAction() {
		$request = $this->getRequest ();
		$member_id = $request->getParam ( 'member_id' );
		$formatted = $request->getParam ( 'formatted' );
		if ($member_id) {
			$memberDetail = $this->table->getMemberDetail ( $member_id );
			/*
			if ($formatted and isset ( $memberDetail ['info'] )) {
				$formattedDetail = array ();
				foreach ( $memberDetail ['info'] as $key => $value ) {
					if (isset ( $value )) {
						$key = str_replace ( '_id', '', $key );
						$key = str_replace ( '_', ' ', $key );
						$key = ucwords ( $key );
						$formattedDetail [$key] = $value;
					}
				}
				$memberDetail ['info'] = $formattedDetail;
			}*/
		}
		if ($memberDetail) {
			$this->_helper->json ( $memberDetail );
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo '"' . $member_id . '" is not member.';
		}
	}
	// NOTE: THE ABOVE AND BELOW FUNCTIONS ARE ALMOST IDENTICAL!!
	/**
	 * Account Information of a member.
	 */
	public function getmemberaccountAction() {
		$request = $this->getRequest ();
		$memberId = $request->getParam ( 'member_id' );
		if ($memberId) {
			$memberDetail = $this->table->getMemberDetail ( $memberId );
			if ($memberDetail) {
				$issuedBook = Model_DbTable_IssueReturn::getIssuedDocumentCount ( $memberId );
				$memberDetail ['issued'] = $issuedBook;
				if ($this->debug) {
					$this->_helper->logger ( $memberDetail );
				}
				$this->_helper->json ( $memberDetail );
			} else {
				$this->getResponse ()->setHttpResponseCode ( 400 );
				echo ' '.$memberId . ' is not a member';
			}
		
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo 'Insufficient parameters';
		}
	}

}
?>

