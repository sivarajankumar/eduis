<?php
class Acad_Model_DbTable_Subject extends Acadz_Base_Model_Dbtable
{
    protected $_name = 'subject';
    const TABLE_NAME = 'subject';
    public static function getSubjectInfo ($subject_code, 
    $subject_type_id = null)
    {
        $sql = self::getDefaultAdapter()->select()
            ->from(self::TABLE_NAME)
            ->where('`subject_code` = ?', $subject_code);
        /*if (isset ( $subject_type_id )) {
			$sql->where ( '`subject_type_id` = ?', $subject_type_id );
		}*/
        return $sql->query()->fetchAll();
    }
}