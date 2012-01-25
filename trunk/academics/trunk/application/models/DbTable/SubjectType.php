<?php
class Acad_Model_DbTable_SubjectType extends Acadz_Base_Model_Dbtable
{
    protected $_name = 'subject_type';
    const TABLE_NAME = 'subject_type';
    /*
	 * @return Subject Type
	 */
    public static function getSubjectTypes ()
    {
        $sql = self::getDefaultAdapter()->select()->from(self::TABLE_NAME);
        return $sql->query()->fetchAll();
    }
}