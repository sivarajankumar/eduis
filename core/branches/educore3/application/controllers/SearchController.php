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
        $request = $this->getRequest()->getParams();
        $model = new Core_Model_Member_Student();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $without_rangeKeys = array('gender'=>'',
                               'nationality_id'=>'',
                               'cast'=>'');
        $with_rangeKeys = array('dob'=>'');
        $without_range = array_intersect_key($params, $without_rangeKeys);
        $with_range = array_intersect_key($params, $with_rangeKeys);
        //$with_range = array_diff_key($params, $without_range);
        $this->_helper->logger($with_range);
        $this->_helper->logger($without_range);
        $search_result = $model->search($without_range,$with_range);
        
        $incomeKey = array('annual_income'=>''); 
        $income = array_intersect_key($params, $incomeKey);
        $model_rel = new Core_Model_Relative();
        $search_result2 = $model_rel->search($income);
        
        $response = array_intersect($search_result, $search_result2);
        $this->_helper->logger($search_result);
        //$callback = $this->getRequest()->getParam('callback');
        //echo $callback . '(' . $this->_helper->json($search_result, false) . ')';
       
        
    }


}

