<?php
class StudentController extends Corez_Base_BaseController
{
    /*
     * @about Interface.
     */
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
    }
    public function getinfoAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $rollno = $request->getParam('rollno');
        if (isset($rollno)) {
            $result = Core_Model_DbTable_Student::getStudentInfo($rollno);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'select' :
					/*echo '<select>';
					echo '<option>Select one</option>';
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['batch_start'] . '">' . $row ['batch_start'] . '</option>';
					}
					echo '</select>';
					*/
					return;
                case 'xml':
                    return;
                default:
                    $this->getResponse()
                        ->setException('Unsupported format request')
                        ->setHttpResponseCode(400);
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
        }
    }
    public function getprofileAction() 
    {
        $request = $this->getRequest();
        //$rollno = $request->getparam('rollno');
        $rollno = '2308009';
        
        $model = new Core_Model_Member_Student();       
        $model->setStudent_roll_no($rollno);
        $model->getMember_id();
        $model->getStudentInfo();
        
       $info = array(
       'roll_no'=>$model->getStudent_roll_no(),
       'regn_no'=>$model->getReg_no(),
       'first_name'=>$model->getFirst_name(),
       'middle_name'=>$model->getMiddle_name(),
       'last_name'=>$model->getLast_name(),
       'gender'=>$model->getGender(),
       'phone_no'=>$model->getContact_no(),
       'dob'=>$model->getDob(),
       'email'=>$model->getE_mail());
       $this->view->assign('$personal_info',$info);
       echo $info;
        
        
     
    }
    
}
