<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage Block
 * @since	   0.1
 */
class Core_Model_DbTable_Block extends Corez_Base_Model
{
    protected $_name = 'block';
    const SELECTQUERY = 'SELECT block_id,block_name FROM `nwaceis`.`block`';
    public static function getblocks ()
    {
        $result = self::getDefaultAdapter()->fetchAll(self::SELECTQUERY);
        return $result;
    }
}