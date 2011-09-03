<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage Holiday
 * @since	   0.1
 */
class Core_Model_DbTable_Holiday extends Corez_Base_Model
{
    protected $_name = 'holiday';
    public static function getCurrentSessionHolidays ()
    {
        $session_startdate = Core_Model_DbTable_AcademicSession::getSessionStartDate();
        $session_enddate = Core_Model_DbTable_AcademicSession::getSessionEndDate();
        $sql = self::getDefaultAdapter()->select()
            ->from('holiday', array('date_from', 'date_upto', 'purpose'))
            ->where('date_from >= ? ', $session_startdate)
            ->where('date_from <= CURRENT_DATE() ');
        $holiday = $sql->query()->fetchAll();
        $dates = array();
        $cnt = 0;
        foreach ($holiday as $key => $value) {
            $start_date = $value['date_from'];
            $end_date = $value['date_upto'];
            $objstart = new Zend_Date($start_date, Zend_Date::ISO_8601);
            $objenddate = new Zend_Date($end_date, Zend_Date::ISO_8601);
            while (! ($objstart->isLater($objenddate))) {
                $dates[$cnt ++] = $objstart->get(Zend_date::YEAR) . '-' .
                 $objstart->get(Zend_date::MONTH) . '-' .
                 $objstart->get(Zend_date::DAY) . '-' . $value['purpose'];
                $objstart->addDay(1);
            }
            $objstart = NULL;
            $objenddate = NULL;
        }
        return $dates;
    }
}