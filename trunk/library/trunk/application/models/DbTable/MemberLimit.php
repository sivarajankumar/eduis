<?php
class Lib_Model_DbTable_MemberLimit extends Libz_Base_Model {
	protected $_name = 'member_limit';
	
	public static function getMemberTypeLimit($memberType, $documentType = NULL) {
		$sql = self::getDefaultAdapter()->select ()
		              ->from ( 'member_limit', array('document_type_id','document_limit','day_limit') )
		              ->where ( 'member_type_id = ?', $memberType );
		              
		if (isset($documentType)) {
			$sql->where('document_type_id = ?', $documentType);
			return $sql->query ()->fetch();
		}
		return $sql->query ()->fetchAll (Zend_Db::FETCH_UNIQUE);
	}
	
	public static function getMemberLimit($member_id, $documentType = NULL) {
		$sql = self::getDefaultAdapter()->select()
		              ->from('member_limit', array('document_type_id',
		                                           'member_type_id',
		                                          'document_limit',
		                                          'day_limit') )
		              ->join('member',
		                      'member.member_type_id = member_limit.member_type_id',
		                      array(''))
                      ->where('member_id = ?', $member_id);
                      
                     
        if (isset($documentType)) {
            $sql->where('document_type_id = ?', $documentType);
            return $sql->query ()->fetch();
        }
        return $sql->query ()->fetchAll (Zend_Db::FETCH_UNIQUE);
	}
}