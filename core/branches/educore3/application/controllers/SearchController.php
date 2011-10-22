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
        $this->_helper->logger($request);
        $dob_range = array('from' => $request['dob_from'],'to' =>$request['dob_to']);
        $with_range = array('dob'=>$dob_range);
        $without_range = array('gender'=>$request['gender'],
                               'nationality_id'=>$request['nationality_id'],
                               'cast_id'=>$request['cast']);
        $this->_helper->logger($with_range);
        $search_result = $model->search($without_range,$with_range);
        
        
       /* $model_rel = new Core_Model_Mapper_Relative();
        $rel_with_range = array('annual_income'=>$request['annual_income']);
        
        $search_result2 = $model_rel->search($rel_with_range);
        
        $response = array_intersect($search_result, $search_result2);*/
        $this->_helper->logger($search_result);
        $callback = $this->getRequest()->getParam('callback');
        echo $callback . '(' . $this->_helper->json($search_result, false) . ')';
        
       
        
    }


}

