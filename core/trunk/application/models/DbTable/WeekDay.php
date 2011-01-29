<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage WeekDay
 * @since	   0.1
 */
class Core_Model_DbTable_WeekDay extends Corez_Base_Model
{
    protected $_name = 'weekday';
    const TABLE_NAME = 'weekday';
    public static function fillday ()
    {
        $sql = 'SELECT `weekday`.`weekday_number`, `weekday`.`weekday_name` FROM `weekday`';
        return self::getDefaultAdapter()->query($sql)->fetchAll();
    }
}