<?php 
class Lib_Model_DbTable_DocumentType extends Libz_Base_Model {
	protected $_name = 'document_type';
	const TABLE_NAME =  'document_type';
	
	/**
	 * Get Document Types
	 * @param int $acc_no
	 */
	public static function docTypes() {
		$sql = self::getDefaultAdapter()->select()->from(self::TABLE_NAME);
		return $sql->query()->fetchAll();
	}
	
	
}
?>