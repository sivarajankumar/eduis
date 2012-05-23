<?php
/**
 * IndexController
 * 
 * @author
 * @version 
 */
class IndexController extends Acadz_Base_BaseController
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {    
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $department_id = 'CSE';
        $degree_id = 'BTECH';
        $semester_id = '6';
        $rollno = '2308001';
        $name = 'Prarthana';
        $this->view->assign('name',$name);
        $this->view->assign('rollno',$rollno);
        $this->view->assign('sem',$semester_id);
        $this->view->assign('degree',$degree_id);
        $this->view->assign('deptt',$department_id);
    }
}
?>

