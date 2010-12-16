<?php

/**
 * MemberLimitController
 * 
 * @author
 * @version 
 */

class MemberLimitController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function init() {
		$this->table = new Lib_Model_DbTable_MemberLimit ( );
		parent::init ();
	}
	
	public function getmembertypelimitAction() {
		$request = $this->getRequest ();
		$member_type = $request->getParam ( 'member_type' );
		$document_type = $request->getParam ( 'document_type' );
		if ($member_type) {
			$memberTypeLimit = $this->table->getMemberTypeLimit ( $member_type, $document_type );
		}
		if ($memberTypeLimit) {
			$this->_helper->json ( $memberTypeLimit );
		} else {
			$this->getResponse ()->setHttpResponseCode ( 400 );
			echo '"' . $member_type . '" is not a valid member type.';
		}
	}
	
	
	public function getmemberlimitAction() {
		$request = $this->getRequest ();
		$memberId = $request->getParam ( 'member_id' );
        $document_type = $request->getParam ( 'document_type' );
		if ($memberId) {
			$memberLimit = $this->table->getMemberLimit ( $memberId, $document_type );
			
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

