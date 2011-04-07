<?php
class StaffController extends Corez_Base_BaseController
{
    public function getdepartmentstaffAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $department_id = $this->getRequest()->getParam('department_id');
        if (isset($department_id)) {
            $result = Core_Model_DbTable_Staff::getDepartmentStaff(
            $department_id);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'jsonp':
                    $callback = $request->getParam('callback');
                    echo $callback . '(' . $this->_helper->json($result, false) .')';
                    return;
                case 'select' :/*
					echo '<select>';
					echo '<option>Select one</option>';
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['batch_start'] . '">' . $row ['batch_start'] . '</option>';
					}
					echo '</select>';*/
					return;
                default:
                    $this->getResponse()
                        ->setException('Unsupported format request')
                        ->setHttpResponseCode(400);
            }
        } else {
                    $this->getResponse()
                        ->setException('Valid parameter(s) required')
                        ->setHttpResponseCode(400);
        }
    }
    
public function getinfoAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $staff_id = $this->getRequest()->getParam('staff_id');
        if (isset($staff_id)) {
            $result = Core_Model_DbTable_StaffPersonal::staffInfo($staff_id);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'jsonp':
                    $callback = $request->getParam('callback');
                    echo $callback . '(' . $this->_helper->json($result, false) .')';
                    return;
                case 'select' :/*
					echo '<select>';
					echo '<option>Select one</option>';
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['batch_start'] . '">' . $row ['batch_start'] . '</option>';
					}
					echo '</select>';*/
					return;
                default:
                    $this->getResponse()
                        ->setException('Unsupported format request')
                        ->setHttpResponseCode(400);
            }
        } else {
                    $this->getResponse()
                        ->setException('Valid parameter(s) required')
                        ->setHttpResponseCode(400);
        }
    }
}