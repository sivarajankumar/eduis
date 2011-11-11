<?php

class SearchController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    public function studentAction()
    {
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $without_rangeKeys = array('gender'=>'',
                               'nationality_id'=>'',
                               'cast_id'=>'');
        $without_range = array_intersect_key($params, $without_rangeKeys);
        $this->_helper->logger($without_range);
        
        $with_rangeKeys = array('dob'=>'');
        $with_range = array_intersect_key($params, $with_rangeKeys);
        $this->_helper->logger($with_range);
        
        $incomeKey = array('annual_income'=>''); 
        $income = array_intersect_key($params, $incomeKey);
        $this->_helper->logger($income);
        
        $relSearch = false;
        if (!empty($income)) {
            $model_rel = new Core_Model_Relative();
            $search_result_rel = $model_rel->search(NULL,$income);
            $relSearch = true;
            
        }
        $stuSearch = false;
        if (!empty($without_range) or !empty($with_range)) {
            $model = new Core_Model_Member_Student();
            $search_result = $model->search($without_range,$with_range);
            $stuSearch = true;
        }
        
        if ($stuSearch and $relSearch) {
            $response = array_intersect($search_result, $search_result_rel);
        } elseif ($stuSearch)
        {
           $response = $search_result; 
        } elseif ($relSearch)
        {
            $response = $search_result_rel; 
        }
        
        $info = array();
        foreach($response as $key => $memberId)
        {
            $model->setMember_id($memberId);
            $model->initStudentInfo();
            $model->fetchRollNumber();
            $info[$memberId] = array(
            'roll_no' => $model->getStudent_roll_no(),
            'name' => $model->getFirst_name());
        }
       
        $this->_helper->logger($info);
        $callback = $this->getRequest()->getParam('callback');
        echo $callback . '(' . $this->_helper->json($info, false) . ')';
       
        
    }


}

