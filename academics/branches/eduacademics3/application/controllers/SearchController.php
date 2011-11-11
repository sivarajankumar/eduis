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
        
        foreach ($params as $key => $value)
        {
           
           switch (substr($key, 0,1))
           {
           case('0'):$tenth_keys = substr($key, 1);
                     $with_rangeKeys = array('percentage'=>'');
                     $without_rangeKeys = array('passing_year'=>'');
              
                     $with_range = array_intersect_key($tenth_keys, $with_rangeKeys);
                     $without_range = array_intersect_key($tenth_keys, $without_rangeKeys);
              
                     $this->_helper->logger($with_range);
                     $this->_helper->logger($without_range);
              
                     $tenth_model = new Acad_Model_Exam_Aisse();
                     $tenth_result = $tenth_model->search($with_range,$without_range);
                     
                     
           case('1'):$twelfth_keys = substr($key, 1);
                     $with_rangeKeys = array('percentage'=>'',
                                             'pcm_percent'=>'');
                     $without_rangeKeys = array('passing_year'=>'');
              
                     $with_range = array_intersect_key($twelfth_keys, $with_rangeKeys);
                     $without_range = array_intersect_key($twelfth_keys, $without_rangeKeys);
              
                     $this->_helper->logger($with_range);
                     $this->_helper->logger($without_range);
              
                     $twelfth_model = new Acad_Model_Exam_Aissce();
                     $twelfth_result = $twelfth_model->search($with_range,$without_range);
                     
                     
           case('2'):$diploma_keys = substr($key, 1);
                     $with_rangeKeys = array('percentage'=>'');
                     $without_rangeKeys = array('passing_year'=>'','discipline_name'=>'','university'=>'');
              
                     $with_range = array_intersect_key($diploma_keys, $with_rangeKeys);
                     $without_range = array_intersect_key($diploma_keys, $without_rangeKeys);
              
                     $this->_helper->logger($with_range);
                     $this->_helper->logger($without_range);
              
                     $diploma_model = new Acad_Model_Programme_Diploma();
                     $diploma_result = $diploma_model->search($with_range,$without_range);

           case('3'):$btech_keys = substr($key, 1);
                     $with_rangeKeys = array('percentage'=>'');
                     $without_rangeKeys = array('passing_year'=>'','discipline_name'=>'','university'=>'');
              
                     $with_range = array_intersect_key($btech_keys, $with_rangeKeys);
                     $without_range = array_intersect_key($btech_keys, $without_rangeKeys);
              
                     $this->_helper->logger($with_range);
                     $this->_helper->logger($without_range);
              
                     $btech_model = new Acad_Model_Programme_Diploma();
                     $btech_result = $btech_model->search($with_range,$without_range);
                     
           default:throw new Exception('invalid params');
           
           }
        }
        
    }
}
