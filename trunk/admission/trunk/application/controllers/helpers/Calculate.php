<?php
/**
 * Logger helper class
 * 
 * @author 
 * @version
 *
 */
class Admsn_Controller_Helper_Calculate extends Zend_Controller_Action_Helper_Abstract
{
    /**
     * Percentage of marks
     * Calculate various operations of marks. direct() is for percentage
     * @param integer $marksObt
     * @param integer $totMarks
     */
    function direct ($marksObt, $totMarks)
    {
        return self::percentage($marksObt, $totMarks);
    }
    
    
    /**
     * Percentage of marks
     * Calculate various operations of marks. direct() is for percentage
     * @param integer $marksObt
     * @param integer $totMarks
     */
    function percentage($marksObt, $totMarks) {
        $result = ($marksObt*$totMarks)/100;
        //$result = null;
        return $result;
    }
}
