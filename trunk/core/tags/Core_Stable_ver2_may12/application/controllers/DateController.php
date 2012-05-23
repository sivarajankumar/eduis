<?php
/**
 * @category   Aceis
 * @package    Default
 * @subpackage Date
 * @version    0.1
 * @since	   0.1
 */
/*
 * Date of System
 *
 *
 */
class DateController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function gettodaydateAction ()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
        $dateobj = new Zend_Date();
        echo $dateobj->getDate();
    }
    public function getisvaliddateAction ()
    {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout()->disableLayout();
        $dateText = $this->getRequest()->getParam('dateText');
        $objSelectedDate = new Zend_Date($dateText, Zend_Date::ISO_8601);
        $objTodayDate = new Zend_Date(Zend_Date::now(), Zend_Date::ISO_8601);
        if ($objSelectedDate->isToday($dateText)) {
            echo 1;
            return;
        }
        if (($objSelectedDate->isEarlier($objTodayDate)) ||
         ($objSelectedDate->isDate($dateText))) {
            echo 0;
            return;
        }
        echo 1;
    }
}
?>

