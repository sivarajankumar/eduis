<?php
/**
 * Library Member Information
 * 
 * All information related to members will be available here.
 * @category   EduIS
 * @package    Library
 * @subpackage Member
 * @since	   0.1
 * @author 	   Hemant
 *
 */
class Lib_Model_DbTable_Member extends Libz_Base_Model {
	protected $_name = 'member';
	const TABLE_NAME = 'member';
	
	public static function getMembership($memberId) {
		return self::_getMemberInfo ( array('member_type_id', 'membership_type_id'), $memberId );
	}
	
	protected static function _getMemberInfo($col, $memberId) {
		
		$sql = self::getDefaultAdapter ()->select ()
						->from ( self::TABLE_NAME, $col )
						->where ( "member_id = ?", $memberId );
		
		$info = $sql->query ()->fetchAll (  );
		if (count ( $info )) {
			return $info[0];
		}
		throw new Zend_Exception ( 'Member ' . $memberId . ' not found', Zend_Log::ERR );
	}
	
	public static function getMemberStatus($memberId, $details = FALSE) {
		// TODO Status of Books issued, returned, pending, fine
	}
	
	public static function getMemberPrivs() {
		// Privelages and rights assigned to member. e.g. issue day, doc limit etc;	
	}
	
	public static function getMemberInfo($memberId) {
		$PROTOCOL = 'http://';
		$membership = self::getMembership ( $memberId );
		$memberType = strtoupper($membership['member_type_id']);
		Zend_Registry::get('logger')->debug($membership);
		$memberInfo = $membership;
		switch ($memberType) {
			case 'STUDENT' :
				$URL_STU_INFO = $PROTOCOL . CORE_SERVER . '/student/getinfo' . "?rollno=$memberId";
				$client = new Zend_Http_Client ( $URL_STU_INFO );
				$client->setCookie ( 'PHPSESSID', $_COOKIE ['PHPSESSID'] );
				$response = $client->request ();
				if ($response->isError ()) {
					$remoteErr = 'REMOTE ERROR: ('.$response->getStatus () . ') ' . $response->getMessage ();
					Zend_Registry::get('logger')->err($remoteErr);
					/**
					 * @todo Surpress Remote Error.
					 */
					//throw new Zend_Exception ( $remoteErr, Zend_Log::ERR );
					$memberInfo['info'] = array();
				    return $memberInfo;
				}
				
				$jsonContent = $response->getBody ( $response );
				$memberInfo['info'] = Zend_Json_Decoder::decode ( $jsonContent );
				return $memberInfo;
			case 'STAFF' :
				$URL_STAFF_INFO = $PROTOCOL . CORE_SERVER . '/staff/getinfo' . "?staff_id=$memberId";
				$client = new Zend_Http_Client ( $URL_STAFF_INFO );
				$client->setCookie ( 'PHPSESSID', $_COOKIE ['PHPSESSID'] );
				$response = $client->request ();
				if ($response->isError ()) {
					$remoteErr = 'REMOTE ERROR: ('.$response->getStatus () . ') ' . $response->getMessage ();
					Zend_Registry::get('logger')->err($remoteErr);
					/**
					 * @todo Surpress Remote Error.
					 */
					//throw new Zend_Exception ( $remoteErr, Zend_Log::ERR );
					$memberInfo['info'] = array();
				    return $memberInfo;
				}
				
				$jsonContent = $response->getBody ( $response );
				$memberInfo['info'] = Zend_Json_Decoder::decode ( $jsonContent );
				return $memberInfo;
			case 'BOOKBANK' :
			    $memberInfo['info'] = array('first_name'=>strtoupper($memberId));
				return $memberInfo;
			default :
				throw new Zend_Exception ( 'Unknown member type : "'.$memberType.'"', Zend_Log::WARN );
		}
		// TODO Name, Department etc
		;
	}
	
	public function getMember($memberId) {
		// TODO all about a member.
		;
	}

}

/*
 * 	public function getMemberDetail($member_id) {
		switch ($memberType) {
			case "STUDENT" :
				$memberDetails ['info'] = Lib_Model_DbTable_StudentDepartment::getStudentInfo ( $member_id );
				return $memberDetails;
				break;
			case "STAFF" :
				break;
			default :
				echo 'Unknown "Member type".';
		}
		return FALSE;
	}
	public function getMemberLocalInfo($member_id) {
		$sql = $this->select ()->from ( $this->_name )->where ( "member_id = ?", $member_id );
		$memberInfo = $sql->query ()->fetch ();
		$memberType = strtoupper ( $memberInfo ['member_type_id'] );
		$memberDetails = array ('member_type_id' => $memberType );
	}
	public function getMemberRemoteInfo($member_id) {
	}
	
	public function getMemberType($member_id) {
		
		;
	}
	
	public function getCurrentState($param) {
		;
	}
 */