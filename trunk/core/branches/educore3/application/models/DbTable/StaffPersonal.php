<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage StaffPersonal
 * @since	   0.1
 */
class Core_Model_DbTable_StaffPersonal extends Corez_Base_Model
{
    protected $_name = 'staff_personal';
    public static function staffDepartment ($staff_id)
    {
        $sql = 'SELECT initial,staff_id,first_name,last_name,department_id from staff_personal where staff_id = ?';
        return self::getDefaultAdapter()->fetchRow($sql, array($staff_id));
    }
    

    public static function staffInfo ($staff_id)
    {
        $sql = 'SELECT initial,first_name,middle_name,last_name,department_id from staff_personal where staff_id = ?';
        return self::getDefaultAdapter()->fetchRow($sql, array($staff_id));
    }
}