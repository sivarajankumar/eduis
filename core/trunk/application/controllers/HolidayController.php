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
class HolidayController extends Corez_Base_BaseController {
	/**
	 * The default action - lists the holidays.
	 */
	public function indexAction() {
		//TODO Holiday Manager
	}
	public function getholidaysAction() {
		try {
			$holidays = Core_Model_DbTable_Holiday::getCurrentSessionHolydays ();
			$this->_helper->json ( $holidays );
		} catch ( Exception $e ) {
			$this->_helper->json ( null );
		}		
	//echo json_encode($holidays);
	}
}
?>

