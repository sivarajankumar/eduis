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
        $params_v = array_diff($request->getParams(), $request->getUserParams());
        $params = $params_v['myarray'];
        $format = $this->_getParam('format', 'log');
        $tenth_fields = array();
        $twelfth_fields = array();
        $member_ids = array();
        $matric_matches = array();
        $twelfth_matches = array();
        $matric_matches = array();
        $diploma_matches = array();
        $backlog_filtered = array();
        if (! empty($params)) {
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
                        //throw new Exception('invalid params');
                        break;
                }
            }
            if (! empty($tenth_fields)) {
                $matric_matches = $this->tenthSearch($tenth_fields);
                if (empty($matric_matches)) {
                    return $this->returnResult($format, false);
                }
            }
            $member_ids = $this->combineResult($member_ids, $matric_matches);
            if (! empty($twelfth_fields)) {
                $twelfth_matches = $this->twelfthSearch($twelfth_fields);
                if (empty($twelfth_matches)) {
                    return $this->returnResult($format, false);
                }
            }
            $member_ids = $this->combineResult($member_ids, $twelfth_matches);
            if (! empty($diploma_fields)) {
                $diploma_matches = $this->DiplomaSearch($diploma_fields);
                if (empty($diploma_matches)) {
                    return $this->returnResult($format, false);
                }
            }
            $member_ids = $this->combineResult($member_ids, $diploma_matches);
        }
        if (! empty($params['backlogs'])) {
            $back_logs = $params['backlogs'];
            if ($back_logs == 'never') {
                $backlog_filtered = $this->neverbackLogSearch($member_ids);
            } else {
                //if (is_int($back_logs)) {
                $back_log_limit = $back_logs;
                $backlog_filtered = $this->backLogSearch($back_log_limit, 
                $member_ids);
                 //}
            }
            if (empty($backlog_filtered)) {
                return $this->returnResult($format, false);
            }
        }
        $member_ids = $this->combineResult($member_ids, $backlog_filtered);
        $this->returnResult($format, $member_ids);
    }
    private function returnResult ($format, $member_ids)
    {
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
    private function neverbackLogSearch ($member_ids)
    {
        $student = new Acad_Model_Member_Student();
        $backlog_filter = array();
        $backlog_filtered = array();
        foreach ($member_ids as $member_id) {
            $student->setMember_id($member_id);
            $has_backlog = $student->hasBacklogCheck();
            if ($has_backlog) {
                $backlog_filtered[] = $member_id;
            }
        }
        return $backlog_filtered;
    }
    private function backLogSearch ($back_log_limit, $member_ids)
    {
        $student = new Acad_Model_Member_Student();
        $backlog_filter = array();
        $backlog_filtered = array();
        foreach ($member_ids as $member_id) {
            $student->setMember_id($member_id);
            $backlog_filter[$member_id] = $student->fetchCurrentBacklogCount();
        }
        foreach ($backlog_filter as $member_id => $backlog_count) {
            if ($backlog_count <= $back_log_limit) {
                $backlog_filtered[] = $member_id;
            }
        }
        return $backlog_filtered;
    }
    private function tenthSearch ($tenth_fields)
    {
        $tenth_range_fields = array('percentage' => '');
        $tenth_range_params = array_intersect_key($tenth_fields, 
        $tenth_range_fields);
        $tenth_exact_params = array_diff_key($tenth_fields, $tenth_range_params);
        $matric = new Acad_Model_Qualification_Matric();
        $matric_matches = $matric->search($tenth_exact_params, 
        $tenth_range_params);
        return $matric_matches;
    }
    private function twelfthSearch ($twelfth_fields)
    {
        $twelfth_range_fields = array('percentage' => '');
        $twelfth_range_params = array_intersect_key($twelfth_fields, 
        $twelfth_range_fields);
        $twelfth_exact_params = array_diff_key($twelfth_fields, 
        $twelfth_range_params);
        $twelfth = new Acad_Model_Qualification_Twelfth();
        $twelfth_matches = $twelfth->search($twelfth_exact_params, 
        $twelfth_range_params);
        return $twelfth_matches;
    }
    private function DiplomaSearch ($diploma_fields)
    {
        $diploma_range_fields = array('percentage' => '');
        $diploma_range_params = array_intersect_key($diploma_fields, 
        $diploma_range_fields);
        $diploma_exact_params = array_diff_key($diploma_fields, 
        $diploma_range_params);
        $diploma = new Acad_Model_Qualification_Diploma();
        $diploma_matches = $diploma->search($diploma_exact_params, 
        $diploma_range_params);
        return $diploma_matches;
    }
    /**
     * 
     * Enter description here ...
     * @param array $member_ids the original array to start with
     * @param array $array_to_try the search results
     */
    private function combineResult ($member_ids, $search_results)
    {
        if (empty($member_ids)) {
            if (! empty($search_results)) {
                $member_ids = array_merge($member_ids, $search_results);
            }
        } else {
            if (! empty($search_results)) {
                $member_ids = array_intersect($member_ids, $search_results);
            }
        }
        return array_unique($member_ids);
    }
}

