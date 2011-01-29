<?php
/**
 * @author HeAvi
 *
 */
class Corez_Base_ReportController extends Zend_Controller_Action
{
    protected $debug;
    public function init ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $this->debug = 1;
    }
}
?>