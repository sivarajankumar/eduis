<?php
/**
 * Holiday(s) management.
 *
 * @category   Aceis
 * @package    Default
 * @subpackage Holiday
 * @since	   0.1
 */
/*
 * HolidayController
 * 
 */
class HolidayController extends Corez_Base_BaseController
{
    /**
     * The default action - lists the holidays.
     */
    public function indexAction ()
    {
        //TODO Holiday Manager
    }
    public function getholidaysAction ()
    {
        $format = $this->getRequest()->getParam('format', 'json');
        $result = Core_Model_DbTable_Holiday::getCurrentSessionHolidays();
        switch (strtolower($format)) {
            case 'json':
                $this->_helper->json($result);
                return;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($result, false) . ')';
                return;
            case 'select':
                echo '<select>';
                echo '<option>Select one</option>';
                foreach ($result as $key => $row) {
                    echo '<option value="' . $row['batch_start'] . '">' .
                     $row['batch_start'] . '</option>';
                }
                echo '</select>';
                return;
            default:
                $this->getResponse()
                    ->setException('Unsupported format request')
                    ->setHttpResponseCode(400);
        }
    }
}
?>

