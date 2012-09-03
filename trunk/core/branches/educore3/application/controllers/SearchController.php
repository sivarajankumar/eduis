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
        $param_view = array_diff($request->getParams(), 
        $request->getUserParams());
        $format = $this->_getParam('format', 'log');
        $params = $param_view['myarray'];
        $member_ids = array();
        $member_ids = $this->fetchAllStudents();
        if (empty($member_ids)) {
            return $this->returnResult($format, false);
        }
        $member_ids = $this->combineResult($member_ids, $member_ids);
        $batch_member_ids = array();
        $department_member_ids = array();
        $programme_member_ids = array();
        $personal_matches = array();
        $rel_matches = array();
        $student = new Core_Model_Member_Student();
        $critical_fields = array();
        $rel_fields = array();
        if (! empty($params)) {
            if (! empty($params['programme_id'])) {
                $p_search = $this->programmeSearch($params['programme_id']);
                if (empty($p_search)) {
                    return $this->returnResult($format, false);
                }
            }
            $member_ids = $this->combineResult($member_ids, 
            $programme_member_ids);
            if (! empty($params['discipline_id'])) {
                $d_search = $this->disciplineSearch($params['discipline_id']);
                if (empty($p_search)) {
                    return $this->returnResult($format, false);
                }
            }
            $member_ids = $this->combineResult($member_ids, 
            $department_member_ids);
            if (! empty($params['batch_start'])) {
                $b_search = $this->batchStartSearch($params['batch_start']);
                if (empty($b_search)) {
                    return $this->returnResult($format, false);
                }
            }
            $member_ids = $this->combineResult($member_ids, $batch_member_ids);
            foreach ($params as $key => $value) {
                switch (substr($key, 0, 1)) {
                    case ('0'):
                        $critical_key = substr($key, 1);
                        $critical_fields[$critical_key] = $params[$key];
                        break;
                    case ('1'):
                        $rel_key = substr($key, 1);
                        $rel_fields[$rel_key] = $params[$key];
                        break;
                    default:
                        //throw new Exception('invalid params');
                        break;
                }
            }
            if (! empty($critical_fields)) {
                $critical_range_fields = array('dob' => '');
                $critical_range_params = array_intersect_key($critical_fields, 
                $critical_range_fields);
                $critical_exact_params = array_diff_key($critical_fields, 
                $critical_range_params);
                $student = new Core_Model_Member_Student();
                $personal_matches = $student->search($critical_exact_params, 
                $critical_range_params);
                if (empty($personal_matches)) {
                    return $this->returnResult($format, false);
                }
            }
            $member_ids = $this->combineResult($member_ids, $personal_matches);
            if (! empty($rel_fields)) {
                $rel_range_fields = array('annual_income' => '');
                $rel_range_params = array_intersect_key($rel_fields, 
                $rel_range_fields);
                $rel_exact_params = array_diff_key($rel_fields, 
                $rel_range_params);
                $relatives = new Core_Model_MemberRelatives();
                $rel_matches = $relatives->search($rel_exact_params, 
                $rel_range_params);
                if (empty($rel_matches)) {
                    return $this->returnResult($format, false);
                }
            }
            $member_ids = $this->combineResult($member_ids, $rel_matches);
        }
        $this->returnResult($format, $member_ids);
    }
    private function programmeSearch ($programme_id)
    {
        $student = new Core_Model_Member_Student();
        $programme_member_ids = $student->fetchClassStudents(null, null, 
        $programme_id);
        return $programme_member_ids;
    }
    private function disciplineSearch ($discipline_id)
    {
        $student = new Core_Model_Member_Student();
        $department_member_ids = $student->fetchClassStudents(null, 
        $discipline_id);
        return $department_member_ids;
    }
    private function batchStartSearch ($batch_start)
    {
        $student = new Core_Model_Member_Student();
        $batch_start_member_ids = $student->fetchClassStudents($batch_start);
        return $batch_start_member_ids;
    }
    private function fetchAllClassesStudents ()
    {
        $student = new Core_Model_Member_Student();
        return $student->fetchClassStudents();
    }
    private function fetchAllStudents ()
    {
        $student = new Core_Model_Member_Student();
        return $student->fetchAllStudents();
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
    public function fetchrollnumbersAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $param_view = array_diff($request->getParams(), 
        $request->getUserParams());
        //$member_ids = $param_view['myarray'];
        $member_ids = array(1, 2, 3, 4, 5);
        $format = $this->_getParam('format', 'log');
        $student = new Core_Model_Member_Student();
        $member_rolls = array();
        foreach ($member_ids as $member_id) {
            $student->setMember_id($member_id);
            $roll_number = $student->fetchRollNumber();
            $member_rolls[$member_id] = $roll_number;
        }
        if (empty($member_rolls)) {
            $member_rolls = false;
        }
        switch ($format) {
            case 'html':
                $this->view->assign('response', $member_rolls);
                break;
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($member_rolls, 
                false) . ')';
                break;
            case 'json':
                $this->_helper->json($member_rolls);
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

