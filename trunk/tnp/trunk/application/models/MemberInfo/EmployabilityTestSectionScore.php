<?php
class Tnp_Model_MemberInfo_EmployabilityTestSectionScore extends Tnp_Model_Generic
{
    protected $_section_score_id;
    protected $_member_id;
    protected $_test_section_id;
    protected $_employability_test_id;
    protected $_section_marks;
    protected $_section_percentile;
    protected $_mapper;
    /**
     * @return the $_section_score_id
     */
    public function getSection_score_id ($throw_exception = null)
    {
        $section_score_id = $this->_section_score_id;
        if (empty($section_score_id) and $throw_exception == true) {
            $message = '_section_score_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $section_score_id;
        }
    }
    /**
     * @param bool $throw_exception optional
     * @return the $_member_id
     */
    public function getMember_id ($throw_exception = null)
    {
        $member_id = $this->_member_id;
        if (empty($member_id) and $throw_exception == true) {
            $message = 'Member_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_id;
        }
    }
    /**
     * @return the $_test_section_id
     */
    public function getTest_section_id ($throw_exception = null)
    {
        $test_section_id = $this->_test_section_id;
        if (empty($test_section_id) and $throw_exception == true) {
            $message = '_test_section_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $test_section_id;
        }
    }
    /**
     * @return the $_employability_test_id
     */
    public function getEmployability_test_id ($throw_exception = null)
    {
        $employability_test_id = $this->_employability_test_id;
        if (empty($employability_test_id) and $throw_exception == true) {
            $message = '_employability_test_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $employability_test_id;
        }
    }
    /**
     * @return the $_section_marks
     */
    public function getSection_marks ()
    {
        return $this->_section_marks;
    }
    /**
     * @return the $_section_percentile
     */
    public function getSection_percentile ()
    {
        return $this->_section_percentile;
    }
    /**
     * @param field_type $_section_score_id
     */
    public function setSection_score_id ($_section_score_id)
    {
        $this->_section_score_id = $_section_score_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_test_section_id
     */
    public function setTest_section_id ($_test_section_id)
    {
        $this->_test_section_id = $_test_section_id;
    }
    /**
     * @param field_type $_employability_test_id
     */
    public function setEmployability_test_id ($_employability_test_id)
    {
        $this->_employability_test_id = $_employability_test_id;
    }
    /**
     * @param field_type $_section_marks
     */
    public function setSection_marks ($_section_marks)
    {
        $this->_section_marks = $_section_marks;
    }
    /**
     * @param field_type $_section_percentile
     */
    public function setSection_percentile ($_section_percentile)
    {
        $this->_section_percentile = $_section_percentile;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_EmployabilityTestSectionScore $mapper
     * @return Tnp_Model_MemberInfo_EmployabilityTestSectionScore
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_EmployabilityTestSectionScore
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(
            new Tnp_Model_Mapper_EmployabilityTestSectionScore());
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
     * Enter description here ...
     * @param bool $member_specific
     * @param bool $test_section_id_specific
     * @param bool $employability_test_specific
     */
    public function fetchSectionScoreIds ($member_specific = null, 
    $employability_test_specific = null, $test_section_id_specific = null)
    {
        $member_id = null;
        $test_section_id = null;
        $employability_test_id = null;
        if ($member_specific) {
            $member_id = $this->getMember_id(true);
        }
        if ($test_section_id_specific) {
            $test_section_id = $this->getTest_section_id(true);
        }
        if ($employability_test_specific) {
            $employability_test_id = $this->getEmployability_test_id(true);
        }
        $section_score_ids = array();
        $section_score_ids = $this->getMapper()->fetchSectionScoreIds(
        $member_id, $employability_test_id, $test_section_id);
        if (empty($section_score_ids)) {
            return false;
        } else {
            return $section_score_ids;
        }
    }
    public function fetchInfo ()
    {
        $section_score_id = $this->getSection_score_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($section_score_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
}