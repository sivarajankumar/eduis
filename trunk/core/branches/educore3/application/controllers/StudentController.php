<?php
class StudentController extends Zend_Controller_Action
{
    public function init ()
    {
        /* Initialize action controller here */
    }
    public function indexAction ()
    {
        // action body
    }
    /**
     * 
     *to show the form on view for personal information
     */
    public function createprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function saveprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        //print_r($params);
        $critical_data = array('programme_id' => 'mtech', 
        'department_id' => 'cse', 'semester_id' => '8', 'roll_no' => '2308009', 
        'registration_id' => '08-ECA-238', 'first_name' => 'harsh', 
        'middle_name' => 'kumar', 'last_name' => 'yadav', 'dob' => '1990-01-11', 
        'gender' => 'MALE', 'nationality_id' => '1', 'blood_group' => 'A+', 
        'religion_id' => '1', 'cast_id' => '0', 'email' => 'mtech');
        
        $relative_data = array(
        '1'=>array('name'=>'lal singh',
                   'office_add'=>'123,hmt',
                   'landline_no'=>'263923',
                    'occupation'=>'emp',
                    'designation'=>'manager',
                    'contact'=>'9416375238'),
        '2'=>array('name'=>'susheela',
                   'office_add'=>'147,hmt',
                   'landline_no'=>'263923',
                    'occupation'=>'hf',
                    'designation'=>'',
                    'contact'=>'123456789'),
        '3'=>array('name'=>'anon',
                   'office_add'=>'567,hmt',
                   'landline_no'=>'879',
                    'occupation'=>'sssdd',
                    'designation'=>'aaaaa',
                    'contact'=>'769089'));
        $address = array('urban'=>'true',
        'resedential'=>array('postal_code'=>'134101',
                             'state'=>'haryana',
                             'district'=>'pkl',
                             'city'=>'pinjore',
                             'address'=>'147,hmt'),
        'correspondence'=>array('postal_code'=>'134101',
                             'state'=>'haryana',
                             'district'=>'pkl',
                             'city'=>'pinjore',
                             'address'=>'147,hmt'));
        
        $dummy_data = array('myarray' => 
        array('critical_data'=>$critical_data,
              'relative_data'=>$relative_data,
              'address'=>$address));
        print_r($dummy_data);
        }
    public function viewprofileAction ()
    {}
}

