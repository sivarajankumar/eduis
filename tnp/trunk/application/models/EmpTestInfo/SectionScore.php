<?php
class Tnp_Model_EmpTestInfo_SectionScore extends Tnp_Model_Generic
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
     * @param Tnp_Model_Mapper_EmpTestInfo_SectionScore $mapper
     * @return Tnp_Model_Core_Training
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_EmpTestInfo_SectionScore
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_EmpTestInfo_SectionScore());
        }
        return $this->_mapper;
    }
}