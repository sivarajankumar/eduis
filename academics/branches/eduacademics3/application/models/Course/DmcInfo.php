<?php
class Acad_Model_Course_DmcInfo extends Acad_Model_Generic
{
    protected $_is_considered;
    protected $_dmc_info_id;
    protected $_dmc_id;
    protected $_result_type_id;
    protected $_class_id;
    protected $_member_id;
    protected $_examination;
    protected $_custody_date;
    protected $_is_granted;
    protected $_receiving_date;
    protected $_is_copied;
    protected $_dispatch_date;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_scaled_marks;
    protected $_percentage;
    protected $_mapper;
    /**
     * @return the $_is_considered
     */
    public function getIs_considered ($throw_exception = null)
    {
        $is_considered = $this->_is_considered;
        if (empty($is_considered) and $throw_exception == true) {
            $message = 'is_considered is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $is_considered;
        }
    }
    /**
     * @param field_type $_is_considered
     */
    public function setIs_considered ($_is_considered)
    {
        $this->_is_considered = $_is_considered;
    }
    /**
     * @return the $_dmc_info_id
     */
    public function getDmc_info_id ($throw_exception = null)
    {
        $dmc_info_id = $this->_dmc_info_id;
        if (empty($dmc_info_id) and $throw_exception == true) {
            $message = 'dmc_info_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $dmc_info_id;
        }
    }
    /**
     * @return the $_dmc_id
     */
    public function getDmc_id ($throw_exception = null)
    {
        $dmc_id = $this->_dmc_id;
        if (empty($dmc_id) and $throw_exception == true) {
            $message = 'dmc_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $dmc_id;
        }
    }
    /**
     * @return the $_result_type_id
     */
    public function getResult_type_id ($throw_exception = null)
    {
        $result_type_id = $this->_result_type_id;
        if (empty($result_type_id) and $throw_exception == true) {
            $message = 'result_type_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $result_type_id;
        }
    }
    /**
     * @return the $_class_id
     */
    public function getClass_id ($throw_exception = null)
    {
        $class_id = $this->_class_id;
        if (empty($class_id) and $throw_exception == true) {
            $message = 'class_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $class_id;
        }
    }
    /**
     * @return the $_member_id
     */
    public function getMember_id ($throw_exception = null)
    {
        $member_id = $this->_member_id;
        if (empty($member_id) and $throw_exception == true) {
            $message = 'member_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_id;
        }
    }
    /**
     * @return the $_examination
     */
    public function getExamination ()
    {
        return $this->_examination;
    }
    /**
     * @return the $_custody_date
     */
    public function getCustody_date ()
    {
        return $this->_custody_date;
    }
    /**
     * @return the $_is_granted
     */
    public function getIs_granted ()
    {
        return $this->_is_granted;
    }
    /**
     * @return the $_receiving_date
     */
    public function getReceiving_date ()
    {
        return $this->_receiving_date;
    }
    /**
     * @return the $_is_copied
     */
    public function getIs_copied ()
    {
        return $this->_is_copied;
    }
    /**
     * @return the $_dispatch_date
     */
    public function getDispatch_date ()
    {
        return $this->_dispatch_date;
    }
    /**
     * @return the $_marks_obtained
     */
    public function getMarks_obtained ()
    {
        return $this->_marks_obtained;
    }
    /**
     * @return the $_total_marks
     */
    public function getTotal_marks ()
    {
        return $this->_total_marks;
    }
    /**
     * @return the $_scaled_marks
     */
    public function getScaled_marks ()
    {
        return $this->_scaled_marks;
    }
    /**
     * @return the $_percentage
     */
    public function getPercentage ()
    {
        return $this->_percentage;
    }
    /**
     * @param field_type $_dmc_info_id
     */
    public function setDmc_info_id ($_dmc_info_id)
    {
        $this->_dmc_info_id = $_dmc_info_id;
    }
    /**
     * @param field_type $_dmc_id
     */
    public function setDmc_id ($_dmc_id)
    {
        $this->_dmc_id = $_dmc_id;
    }
    /**
     * @param field_type $_result_type_id
     */
    public function setResult_type_id ($_result_type_id)
    {
        $this->_result_type_id = $_result_type_id;
    }
    /**
     * @param field_type $_class_id
     */
    public function setClass_id ($_class_id)
    {
        $this->_class_id = $_class_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_examination
     */
    public function setExamination ($_examination)
    {
        $this->_examination = $_examination;
    }
    /**
     * @param field_type $_custody_date
     */
    public function setCustody_date ($_custody_date)
    {
        $this->_custody_date = $_custody_date;
    }
    /**
     * @param field_type $_is_granted
     */
    public function setIs_granted ($_is_granted)
    {
        $this->_is_granted = $_is_granted;
    }
    /**
     * @param field_type $_receiving_date
     */
    public function setReceiving_date ($_receiving_date)
    {
        $this->_receiving_date = $_receiving_date;
    }
    /**
     * @param field_type $_is_copied
     */
    public function setIs_copied ($_is_copied)
    {
        $this->_is_copied = $_is_copied;
    }
    /**
     * @param field_type $_dispatch_date
     */
    public function setDispatch_date ($_dispatch_date)
    {
        $this->_dispatch_date = $_dispatch_date;
    }
    /**
     * @param field_type $_marks_obtained
     */
    public function setMarks_obtained ($_marks_obtained)
    {
        $this->_marks_obtained = $_marks_obtained;
    }
    /**
     * @param field_type $_total_marks
     */
    public function setTotal_marks ($_total_marks)
    {
        $this->_total_marks = $_total_marks;
    }
    /**
     * @param field_type $_scaled_marks
     */
    public function setScaled_marks ($_scaled_marks)
    {
        $this->_scaled_marks = $_scaled_marks;
    }
    /**
     * @param field_type $_percentage
     */
    public function setPercentage ($_percentage)
    {
        $this->_percentage = $_percentage;
    }
    /**
     * Sets Mapper
     * @param Acad_Model_Mapper_Course_DmcInfo $mapper
     * @return Acad_Model_Course_DmcInfo
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Course_DmcInfo
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Course_DmcInfo());
        }
        return $this->_mapper;
    }
    /**
     * Provides correct db column names corresponding to model properties
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctDbKeys ($key)
    {
        switch ($key) {
            /*case 'nationalit':
                return 'nationality';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * Provides correct model property names corresponding to db column names
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctModelKeys ($key)
    {
        switch ($key) {
            /*case 'nationality':
                return 'nationalit';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * 
     */
    public function initInfo ()
    {}
    public function fetchInfo ()
    {
        $dmc_info_id = $this->getDmc_info_id(true);
        $info = $this->getMapper()->fetchInfo($dmc_info_id);
        if (empty($info)) {
            return false;
        } else {
            $this->setOptions($info);
            return $this;
        }
    }
    /**
     * 
     * Enter description here ...
     * @return dmc_info_id
     */
    public function checkDmcId ()
    {
        $dmc_id = $this->getDmc_id(true);
        $dmc_info_id = $this->getMapper()->fetchDmcInfoIds(null, null, null, 
        null, null, null, $dmc_id);
        if (empty($dmc_info_id)) {
            return false;
        } else {
            return array_search($dmc_id, $dmc_info_id);
        }
    }
    /**
     * Fetches DmcInfoIds in Descending order(
     * Form of array returned :array(dmc_info_id=>dmc_id))
     * @param bool $all
     */
    public function fetchDmcInfoIdsByDate ($all = null)
    {
        $member_id = $this->getMember_id(true);
        $dmc_info_ids = $this->getMapper()->fetchDmcInfoIdsByDate($member_id, 
        $all);
        if (empty($dmc_info_ids)) {
            return false;
        } else {
            return $dmc_info_ids;
        }
    }
    /**
     * 
     * Enter description here ...
     * @param int $member_id
     * @param int $class_specific 
     * @param int $result_type_specific
     * @param bool $all     
     * @param bool $considered_only
     * @param bool $ordered_by_date
     */
    public function fetchMemberDmcInfoIds ($class_specific = null, 
    $result_type_specific = null, $latest_only = null, $considered_only = null, 
    $ordered_by_date = null)
    {
        $member_id = $this->getMember_id(true);
        //
        $class_id = null;
        $result_type_id = null;
        $all_dmc_info_ids = null;
        $is_considered = null;
        //
        $dmc_info_ids = array();
        if ($class_specific == true) {
            $class_id = $this->getClass_id(true);
        }
        if ($result_type_specific == true) {
            $result_type_id = $this->getResult_type_id(true);
        }
        if ($considered_only == true) {
            $is_considered = $this->getIs_considered(true);
        }
        $dmc_info_ids = $this->getMapper()->fetchDmcInfoIds($member_id, 
        $class_id, $result_type_id, $latest_only, $is_considered, 
        $ordered_by_date);
        if (empty($dmc_info_ids)) {
            return false;
        } else {
            return $dmc_info_ids;
        }
    }
    /**
     * 
     * Enter description here ...
     * @param string $result_type ex : 'regular_pass'
     */
    public function fetchBackLogMembers ($number_of_backlogs)
    {
        $member_ids = $this->getMapper()->fetchBackLogMembers();
        if (empty($member_ids)) {
            return false;
        } else {
            $member_back_logs = array_count_values($member_ids);
            $result = array();
            foreach ($member_back_logs as $member_id => $backlog_count) {
                if ($backlog_count >= $number_of_backlogs) {
                    $result[$member_id]['back_log_count'] = $backlog_count;
                }
            }
            if (empty($result)) {
                return false;
            } else {
                return $result;
            }
        }
    }
    /**
     * 
     * Enter description here ...
     * @param string $result_type ex : 'regular_pass'
     */
    public function fetchFailedSubjectIds ()
    {
        $dmc_info_id = $this->getDmc_info_id(true);
        $stu_subj_ids = $this->getMapper()->fetchFailedSubjectIds($dmc_info_id);
        if (empty($stu_subj_ids)) {
            return false;
        } else {
            return $stu_subj_ids;
        }
    }
    public function hasBacklogCheck ()
    {
        $member_id = $this->getMember_id(true);
        return $this->getMapper()->hasBacklogCheck($member_id);
    }
    public function fetchResultTypes ()
    {
        return $this->getMapper()->fetchResultTypes();
    }
}