<?php

/**
 * MemberLimitController
 * 
 * @author
 * @version 
 */

class MembershipLimitController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	
	public function getmembershiplimitAction() {
		$request = $this->getRequest ();
		$membership_type = $request->getParam ( 'membership_type' );
		$document_type = $request->getParam ( 'document_type' );
		if ($membership_type) {
			$membershipLimit = Lib_Model_DbTable_MembershipLimit::getMembershipLimits ( $membership_type, $document_type );
			
			if ($membershipLimit) {
				$this->_helper->json ( $membershipLimit );
			} else {
				$this->getResponse ()->setHttpResponseCode ( 400 );
				echo '"' . $membership_type . '" is not a valid membership type.';
			}
		}
	}
	
	public function getmemberlimitAction() {
		self::createModel ();
		$request = $this->getRequest ();
		$memberId = $request->getParam ( 'member_id' );
		$document_type = $request->getParam ( 'document_type' );
		if ($memberId) {
			$memberLimit = $this->model->getMemberLimit ( $memberId, $document_type );
			
			if ($memberLimit) {
				$this->_helper->json ( $memberLimit );
			} else {
				$this->getResponse ()->setHttpResponseCode ( 400 );
				echo '"' . $memberId . '" is not a member.';
			}
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo 'Insufficient parameters';
		}
	}

}
?>

