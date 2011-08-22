<?php
/**
 * NoattendancedayController
 * 
 * @author
 * @version 
 */
class NoattendancedayController extends Acadz_Base_BaseController
{
    /**
     * The default action - show the home page
     */
    public function getisnoattendancedayAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $department_id = $request->getParam('department_id');
        $degree_id = $request->getParam('degree_id');
        $semester_id = $request->getParam('semester_id');
        $check_date = $request->getParam('check_date');
        echo true;
    }
}
?>

