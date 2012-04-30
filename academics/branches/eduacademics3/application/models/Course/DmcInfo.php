<?php
class Acad_Model_Course_DmcInfo extends Acad_Model_Generic
{
    protected $_dmc_info_id;
    protected $_dmc_id;
    protected $_result_type_id;
    protected $_class_id;
    protected $_member_id;
    protected $_roll_no;
    protected $_examination;
    protected $_custody_date;
    protected $_is_granted;
    protected $_grant_date;
    protected $_recieveing_date;
    protected $_is_copied;
    protected $_dispatch_date;
    protected $_marks_obtained;
    protected $_total_marks;
    protected $_scaled_marks;
    protected $_percentage;
    protected $_mapper;
    /**
     * @return the $_dmc_info_id
     */
    public function getDmc_info_id ()
    {
        return $this->_dmc_info_id;
    }
    /**
     * @param field_type $_dmc_info_id
     */
    public function setDmc_info_id ($_dmc_info_id)
    {
        $this->_dmc_info_id = $_dmc_info_id;
    }
    /**
     * @return the $_dmc_id
     */
    public function getDmc_id ()
    {
        return $this->_dmc_id;
    }
    /**
     * @param field_type $_dmc_id
     */
    public function setDmc_id ($_dmc_id)
    {
        $this->_dmc_id = $_dmc_id;
    }
    /**
     * @return the $_result_type_id
     */
    public function getResult_type_id ()
    {
        return $this->_result_type_id;
    }
    /**
     * @param field_type $_result_type_id
     */
    public function setResult_type_id ($_result_type_id)
    {
        $this->_result_type_id = $_result_type_id;
    }
    /**
     * @return the $_class_id
     */
    public function getClass_id ()
    {
        return $this->_class_id;
    }
    /**
     * @param field_type $_class_id
     */
    public function setClass_id ($_class_id)
    {
        $this->_class_id = $_class_id;
    }
    /**
     * @return the $_member_id
     */
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @return the $_roll_no
     */
    public function getRoll_no ()
    {
        return $this->_roll_no;
    }
    /**
     * @param field_type $_roll_no
     */
    public function setRoll_no ($_roll_no)
    {
        $this->_roll_no = $_roll_no;
    }
    /**
     * @return the $_examination
     */
    public function getExamination ()
    {
        return $this->_examination;
    }
    /**
     * @param field_type $_examination
     */
    public function setExamination ($_examination)
    {
        $this->_examination = $_examination;
    }
    /**
     * @return the $_custody_date
     */
    public function getCustody_date ()
    {
        return $this->_custody_date;
    }
    /**
     * @param field_type $_custody_date
     */
    public function setCustody_date ($_custody_date)
    {
        $this->_custody_date = $_custody_date;
    }
    /**
     * @return the $_is_granted
     */
    public function getIs_granted ()
    {
        return $this->_is_granted;
    }
    /**
     * @param field_type $_is_granted
     */
    public function setIs_granted ($_is_granted)
    {
        $this->_is_granted = $_is_granted;
    }
    /**
     * @return the $_grant_date
     */
    public function getGrant_date ()
    {
        return $this->_grant_date;
    }
    /**
     * @param field_type $_grant_date
     */
    public function setGrant_date ($_grant_date)
    {
        $this->_grant_date = $_grant_date;
    }
    /**
     * @return the $_recieveing_date
     */
    public function getRecieveing_date ()
    {
        return $this->_recieveing_date;
    }
    /**
     * @param field_type $_recieveing_date
     */
    public function setRecieveing_date ($_recieveing_date)
    {
        $this->_recieveing_date = $_recieveing_date;
    }
    /**
     * @return the $_is_copied
     */
    public function getIs_copied ()
    {
        return $this->_is_copied;
    }
    /**
     * @param field_type $_is_copied
     */
    public function setIs_copied ($_is_copied)
    {
        $this->_is_copied = $_is_copied;
    }
    /**
     * @return the $_dispatch_date
     */
    public function getDispatch_date ()
    {
        return $this->_dispatch_date;
    }
    /**
     * @param field_type $_dispatch_date
     */
    public function setDispatch_date ($_dispatch_date)
    {
        $this->_dispatch_date = $_dispatch_date;
    }
    /**
     * @return the $_marks_obtained
     */
    public function getMarks_obtained ()
    {
        return $this->_marks_obtained;
    }
    /**
     * @param field_type $_marks_obtained
     */
    public function setMarks_obtained ($_marks_obtained)
    {
        $this->_marks_obtained = $_marks_obtained;
    }
    /**
     * @return the $_total_marks
     */
    public function getTotal_marks ()
    {
        return $this->_total_marks;
    }
    /**
     * @param field_type $_total_marks
     */
    public function setTotal_marks ($_total_marks)
    {
        $this->_total_marks = $_total_marks;
    }
    /**
     * @return the $_scaled_marks
     */
    public function getScaled_marks ()
    {
        return $this->_scaled_marks;
    }
    /**
     * @param field_type $_scaled_marks
     */
    public function setScaled_marks ($_scaled_marks)
    {
        $this->_scaled_marks = $_scaled_marks;
    }
    /**
     * @return the $_percentage
     */
    public function getPercentage ()
    {
        return $this->_percentage;
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
     * @param Acad_Model_Mapper_DmcInfo $mapper
     * @return Acad_Model_Course_DmcInfo
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_DmcInfo
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_DmcInfo());
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
        $dmc_info_id = $this->getDmc_info_id();
        if (empty($dmc_info_id)) {
            $careless_error = 'Please provide a DmcInfoId.';
            throw new Exception($careless_error);
        } else {
            $info = $this->getMapper()->fetchInfo($dmc_info_id);
            if (sizeof($info) == 0) {
                return false;
            } else {
                $this->setOptions($info);
                return true;
            }
        }
    }
    /**
     * 
     * Enter description here ...
     * @param boolean $class_specific
     * @param boolean $all
     * @param boolean $result_type_specific
     */
    public function fetchMemberDmcInfoIds ($class_specific = null, 
    $result_type_specific = null, $all = null)
    {
        $dmc_info_ids = array();
        $basis = '';
        if (! empty($class_specific) and ! empty($all)) {
            $careless_error = 'In fetchMemberDmcInfoIds() set ATMOST one parameter. More than One set';
            throw new Exception($careless_error);
        } else {
            /*
             * Statement 1
             */
            if (! empty($class_specific) and $class_specific == true) {
                $basis = 'class';
                $class_id = $this->getClass_id();
                if (empty($class_id)) {
                    throw new Exception(
                    'Class_specific flag was set to TRUE but No Class_id was provided to fetchMemberDmcInfoIds()');
                }
            }
            /*
             * Statement 2
             */
            if (! empty($all) and $all == true) {
                $basis = 'all';
            }
            /*
             * over writes the $basis variable if already set by Statement 1
             */
            if (! empty($result_type_specific) and $result_type_specific == true) {
                $result_type_id = $this->getResult_type_id();
                if (empty($result_type_id)) {
                    throw new Exception(
                    'Result_type_specific flag was set to TRUE but No Result_type_id was provided to fetchMemberDmcInfoIds()');
                } else {
                    $basis = 'result_type';
                }
            }
        }
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            throw new Exception(
            'No Member Id provided to fetchMemberDmcInfoIds()');
        } else {
            switch ($basis) {
                case 'class':
                    $class_id = $this->getClass_id();
                    $dmc_info_ids = $this->getMapper()->fetchDmcInfoIds(
                    $member_id, $class_id);
                    break;
                case 'all':
                    $class_id = $this->getClass_id();
                    $dmc_info_ids = $this->getMapper()->fetchDmcInfoIds(
                    $member_id);
                    break;
                case 'result_type':
                    $class_id = $this->getClass_id();
                    if (isset($class_id)) {
                        $dmc_info_ids = $this->getMapper()->fetchDmcInfoIds(
                        $member_id, $class_id, $result_type_id);
                    } else {
                        $dmc_info_ids = $this->getMapper()->fetchDmcInfoIds(
                        $member_id, null, $result_type_id);
                    }
                    break;
                default:
                    if ($basis == '') {
                        throw new Exception(
                        'Invalid Basis provided to fetchMemberDmcInfoIds()');
                    }
                    break;
            }
            if (empty($dmc_info_ids)) {
                return false;
            } else {
                return $dmc_info_ids;
            }
        }
    }
    public function save ($data_array)
    {
        $preparedDataForSaveProcess = $this->prepareDataForSaveProcess(
        $data_array);
        $this->setOptions($preparedDataForSaveProcess);
        $this->getMapper()->save($preparedDataForSaveProcess);
    }
}