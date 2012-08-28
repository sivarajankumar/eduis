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
    public function searchAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $format = $this->_getParam('format', 'log');
        $tenth_fields = array();
        $twelfth_fields = array();
        foreach ($params as $key => $value) {
            switch (substr($key, 0, 1)) {
                case ('0'):
                    $tenth_key = substr($key, 1);
                    $tenth_fields[$tenth_key] = $params[$key];
                    break;
                case ('1'):
                    $twelfth_key = substr($key, 1);
                    $twelfth_fields[$twelfth_key] = $params[$key];
                    break;
                case ('2'):
                    $diploma_key = substr($key, 1);
                    $diploma_fields[$diploma_key] = $params[$key];
                    break;
                default:
                    throw new Exception('invalid params');
                    break;
            }
        }
        $member_ids = array();
        if (! empty($tenth_fields)) {
            $tenth_range_fields = array('percentage' => '');
            $tenth_range_params = array_intersect_key($tenth_fields, 
            $tenth_range_fields);
            $tenth_exact_params = array_diff_key($tenth_fields, 
            $tenth_range_params);
            $matric = new Acad_Model_Qualification_Matric();
            $matric_matches = $matric->search($tenth_exact_params, 
            $tenth_range_params);
        }
        if (! empty($twelfth_fields)) {
            $twelfth_range_fields = array('percentage' => '');
            $twelfth_range_params = array_intersect_key($twelfth_fields, 
            $twelfth_range_fields);
            $twelfth_exact_params = array_diff_key($twelfth_fields, 
            $twelfth_range_params);
            $twelfth = new Acad_Model_Qualification_Twelfth();
            $twelfth_matches = $twelfth->search($twelfth_exact_params, 
            $twelfth_range_params);
        }
        if (! empty($diploma_fields)) {
            $diploma_range_fields = array('percentage' => '');
            $diploma_range_params = array_intersect_key($diploma_fields, 
            $diploma_range_fields);
            $diploma_exact_params = array_diff_key($diploma_fields, 
            $diploma_range_params);
            $diploma = new Acad_Model_Qualification_Diploma();
            $diploma_matches = $diploma->search($diploma_exact_params, 
            $diploma_range_params);
        }
        if (! empty($matric_matches)) {
            $member_ids = array_merge($member_ids, $matric_matches);
        }
        if (! empty($twelfth_matches)) {
            $member_ids = array_merge($member_ids, $twelfth_matches);
        }
        if (! empty($diploma_matches)) {
            $member_ids = array_merge($member_ids, $diploma_matches);
        }
        if (empty($member_ids)) {
            $member_ids = false;
        }
        $member_ids = array_unique($member_ids);
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

