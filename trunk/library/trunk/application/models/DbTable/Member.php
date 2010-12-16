<?php
class Lib_Model_DbTable_Member extends Libz_Base_Model {
	protected $_name = 'member';
	
	public function getMemberDetail($member_id) {
		$sql = $this->select ()->from ( $this->_name )->where ( "member_id = ?", $member_id );
		
		$memberInfo = $sql->query ()->fetch ();
		$memberType = strtoupper ( $memberInfo ['member_type_id'] );
		$memberDetails = array ('member_type_id' => $memberType );
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
	
	public function getMemberType($member_id)
	{
		
	}
	
	
}