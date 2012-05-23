<?php
class Lib_Model_DbTable_MembershipLimit extends Libz_Base_Model {
	protected $_name = 'membership_limit';
	const TABLE_NAME = 'membership_limit';
	
	public static function getMembershipLimits($membershipType, $documentType = NULL) {
		$sql = self::getDefaultAdapter()->select ()
		              ->from ( self::TABLE_NAME, array('document_type_id','document_limit','day_limit') )
		              ->where ( 'membership_type_id = ?', $membershipType );
		              
		if (isset($documentType)) {
			$sql->where('document_type_id = ?', $documentType);
			return $sql->query ()->fetch();
		}
		return $sql->query ()->fetchAll (Zend_Db::FETCH_UNIQUE);
	}
	
	public static function getMemberLimit($member_id, $documentType = NULL) {
		$sql = self::getDefaultAdapter()->select()
		              ->from(self::TABLE_NAME, array('document_type_id',
		                                           'membership_type_id',
		                                          'document_limit',
		                                          'day_limit') )
		              ->join('member',
		                      'member.membership_type_id = '.self::TABLE_NAME.'.membership_type_id',
		                      array(''))
                      ->where('member_id = ?', $member_id);
                     
                  
        if (isset($documentType)) {
            $sql->where('document_type_id = ?', $documentType);
            return $sql->query ()->fetch();
        }
        return $sql->query ()->fetchAll (Zend_Db::FETCH_UNIQUE);
	}
}