<?php
class SearchController extends Zend_Controller_Action
{
    public function init ()
    {
        /* Initialize action controller here */
    }
    public function indexAction ()
    {
        // action body
    }
    public function testAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $ranges = array('annual_income' => '');
        $property_range = array(
        'annual_income' => array('from' => 1, 'to' => 1000000), 
        'ann_income' => array('from' => 1, 'to' => 1000000), 
        'an_income' => array('from' => 1, 'to' => 1000000));
        $ann_income = array();
        $model_rel = new Core_Model_MemberRelatives();
        $search_result_rel = $model_rel->search(NULL, $property_range);
        Zend_Registry::get('logger')->debug($search_result_rel);
    }
    public function searchAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'log');
        $critical_fields = array();
        $rel_fields = array();
        foreach ($params as $key => $value) {
            switch (substr($key, 0, 1)) {
                case ('0'):
                    $critical_key = substr($key, 1);
                    $critical_fields = array($critical_key => $params[$key]);
                case ('1'):
                    $rel_key = substr($key, 1);
                    $rel_fields = array($rel_key => $params[$key]);
                default:
                    throw new Exception('invalid params');
            }
        }
        /* -------------------------------------- */
        if (! empty($critical_fields)) {
            $critical_range_fields = array('dob' => '');
            $critical_range_params = array_intersect_key($critical_fields, 
            $critical_range_fields);
            $critical_exact_params = array_diff_key($critical_fields, 
            $critical_range_params);
            $student = new Core_Model_Member_Student();
            $personal_matches = $student->search($critical_exact_params, 
            $critical_range_params);
        }
        if (! empty($rel_fields)) {
            $rel_range_fields = array('annual_income' => '');
            $rel_range_params = array_intersect_key($rel_fields, 
            $rel_range_fields);
            $rel_exact_params = array_diff_key($rel_fields, $rel_range_params);
            $relatives = new Core_Model_MemberRelatives();
            $rel_matches = $relatives->search($rel_exact_params, 
            $rel_range_params);
        }
        $callback = $this->getRequest()->getParam('callback');
        $member_ids = array_merge($rel_matches, $personal_matches);
        if (empty($member_ids)) {
            $member_ids = false;
        }
        switch ($format) {
            case 'html':
                $this->view->assign('response', $member_ids);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($member_ids, false) .
                 ')';
                break;
            case 'json':
                $this->_helper->json($member_ids);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug($member_ids);
                break;
            default:
                ;
                break;
        }
    }
}

