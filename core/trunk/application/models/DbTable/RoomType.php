<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage RoomType
 * @since	   0.1
 */
class Core_Model_DbTable_RoomType extends Corez_Base_Model
{
    protected $_name = 'room_type';
    const TABLE_NAME = 'room_type';
    public static function roomTypes ()
    {
        $sql = self::getDefaultAdapter()->select()->from(self::TABLE_NAME, 
        array('room_type_id', 'room_type_name'));
        return $sql->query()->fetchAll();
    }
}