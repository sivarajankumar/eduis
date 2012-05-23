<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage Room
 * @since	   0.1
 */
class Core_Model_DbTable_Room extends Corez_Base_Model
{
    protected $_name = 'room';
    const TABLE_NAME = 'room';
    const SELECTQUERY = 'SELECT room_id,room_type_id,block_id FROM `aceis`.`room` where block_id = %s ';
    public static function getRooms ($block_id)
    {
        /*
		 * I have to switch to this way....but laterrrr
		$adapter = self::getDefaultAdapter();
		$sql = vsprintf(
		              self::SELECTQUERY,
		              array_walk($block, array($adapter, 'quoteInto')));
		$this->logger->log($sql,Zend_Log::INFO);
		return $adapter->fetchAll($sql);
		*/
        $sql = self::getDefaultAdapter()->select()
            ->from(self::TABLE_NAME, array('room_id', 'room_type_id'))
            ->where('block_id = ?', $block_id);
        return $sql->query()->fetchAll();
    }
}