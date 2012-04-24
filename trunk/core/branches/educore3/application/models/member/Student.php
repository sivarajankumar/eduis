<?php
class Core_Model_Member_Student extends Core_Model_Generic
{
    // critical information
    protected $_member_id;
    protected $_member_type_id;
    protected $_member_type_name;
    protected $_first_name;
    protected $_middle_name;
    protected $_last_name;
    protected $_dob;
    protected $_gender;
    protected $_blood_group;
    protected $_cast_id;
    protected $_nationality_id;
    protected $_religion_id;
    protected $_cast_name;
    protected $_nationality_name;
    protected $_religion_name;
    protected $_join_date;
    protected $_relieve_date;
    protected $_image_no;
    protected $_is_active;
    // Registartion properties
    protected $_reg_id;
    //  Other properties registered at the time of admission 
    protected $_marital_status;
    protected $_councelling_no;
    protected $_admission_date;
    protected $_alloted_category;
    protected $_alloted_branch;
    protected $_state_of_domicile;
    protected $_urban;
    protected $_avails_hostel;
    protected $_avails_bus;
    protected $_mapper;
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
     * @return the $_member_type_id
     */
    public function getMember_type_id ()
    {
        return $this->_member_type_id;
    }
    /**
     * @param field_type $_member_type_id
     */
    public function setMember_type_id ($_member_type_id)
    {
        $this->_member_type_id = $_member_type_id;
    }
    /**
     * @return the $_member_type_name
     */
    public function getMember_type_name ()
    {
        return $this->_member_type_name;
    }
    /**
     * @param field_type $_member_type_name
     */
    public function setMember_type_name ($_member_type_name)
    {
        $this->_member_type_name = $_member_type_name;
    }
    /**
     * @return the $_first_name
     */
    public function getFirst_name ()
    {
        return $this->_first_name;
    }
    /**
     * @param field_type $_first_name
     */
    public function setFirst_name ($_first_name)
    {
        $this->_first_name = $_first_name;
    }
    /**
     * @return the $_middle_name
     */
    public function getMiddle_name ()
    {
        return $this->_middle_name;
    }
    /**
     * @param field_type $_middle_name
     */
    public function setMiddle_name ($_middle_name)
    {
        $this->_middle_name = $_middle_name;
    }
    /**
     * @return the $_last_name
     */
    public function getLast_name ()
    {
        return $this->_last_name;
    }
    /**
     * @param field_type $_last_name
     */
    public function setLast_name ($_last_name)
    {
        $this->_last_name = $_last_name;
    }
    /**
     * @return the $_dob
     */
    public function getDob ()
    {
        return $this->_dob;
    }
    /**
     * @param field_type $_dob
     */
    public function setDob ($_dob)
    {
        $this->_dob = $_dob;
    }
    /**
     * @return the $_gender
     */
    public function getGender ()
    {
        return $this->_gender;
    }
    /**
     * @param field_type $_gender
     */
    public function setGender ($_gender)
    {
        $this->_gender = $_gender;
    }
    /**
     * @return the $_blood_group
     */
    public function getBlood_group ()
    {
        return $this->_blood_group;
    }
    /**
     * @param field_type $_blood_group
     */
    public function setBlood_group ($_blood_group)
    {
        $this->_blood_group = $_blood_group;
    }
    /**
     * @return the $_cast_id
     */
    public function getCast_id ()
    {
        return $this->_cast_id;
    }
    /**
     * @param field_type $_cast_id
     */
    public function setCast_id ($_cast_id)
    {
        $this->_cast_id = $_cast_id;
    }
    /**
     * @return the $_nationality_id
     */
    public function getNationality_id ()
    {
        return $this->_nationality_id;
    }
    /**
     * @param field_type $_nationality_id
     */
    public function setNationality_id ($_nationality_id)
    {
        $this->_nationality_id = $_nationality_id;
    }
    /**
     * @return the $_religion_id
     */
    public function getReligion_id ()
    {
        return $this->_religion_id;
    }
    /**
     * @param field_type $_religion_id
     */
    public function setReligion_id ($_religion_id)
    {
        $this->_religion_id = $_religion_id;
    }
    /**
     * @return the $_cast_name
     */
    public function getCast_name ()
    {
        return $this->_cast_name;
    }
    /**
     * @return the $_nationality_name
     */
    public function getNationality_name ()
    {
        return $this->_nationality_name;
    }
    /**
     * @return the $_religion_name
     */
    public function getReligion_name ()
    {
        return $this->_religion_name;
    }
    /**
     * @param field_type $_cast_name
     */
    public function setCast_name ($_cast_name)
    {
        $this->_cast_name = $_cast_name;
    }
    /**
     * @param field_type $_nationality_name
     */
    public function setNationality_name ($_nationality_name)
    {
        $this->_nationality_name = $_nationality_name;
    }
    /**
     * @param field_type $_religion_name
     */
    public function setReligion_name ($_religion_name)
    {
        $this->_religion_name = $_religion_name;
    }
    /**
     * @return the $_join_date
     */
    public function getJoin_date ()
    {
        return $this->_join_date;
    }
    /**
     * @param field_type $_join_date
     */
    public function setJoin_date ($_join_date)
    {
        $this->_join_date = $_join_date;
    }
    /**
     * @return the $_relieve_date
     */
    public function getRelieve_date ()
    {
        return $this->_relieve_date;
    }
    /**
     * @param field_type $_relieve_date
     */
    public function setRelieve_date ($_relieve_date)
    {
        $this->_relieve_date = $_relieve_date;
    }
    /**
     * @return the $_image_no
     */
    public function getImage_no ()
    {
        return $this->_image_no;
    }
    /**
     * @param field_type $_image_no
     */
    public function setImage_no ($_image_no)
    {
        $this->_image_no = $_image_no;
    }
    /**
     * @return the $_is_active
     */
    public function getIs_active ()
    {
        return $this->_is_active;
    }
    /**
     * @param field_type $_is_active
     */
    public function setIs_active ($_is_active)
    {
        $this->_is_active = $_is_active;
    }
    /**
     * @return the $_reg_id
     */
    public function getReg_id ()
    {
        return $this->_reg_id;
    }
    /**
     * @param field_type $_reg_id
     */
    public function setReg_id ($_reg_id)
    {
        $this->_reg_id = $_reg_id;
    }
    /**
     * @return the $_marital_status
     */
    public function getMarital_status ()
    {
        return $this->_marital_status;
    }
    /**
     * @param field_type $_marital_status
     */
    public function setMarital_status ($_marital_status)
    {
        $this->_marital_status = $_marital_status;
    }
    /**
     * @return the $_councelling_no
     */
    public function getCouncelling_no ()
    {
        return $this->_councelling_no;
    }
    /**
     * @param field_type $_councelling_no
     */
    public function setCouncelling_no ($_councelling_no)
    {
        $this->_councelling_no = $_councelling_no;
    }
    /**
     * @return the $_admission_date
     */
    public function getAdmission_date ()
    {
        return $this->_admission_date;
    }
    /**
     * @param field_type $_admission_date
     */
    public function setAdmission_date ($_admission_date)
    {
        $this->_admission_date = $_admission_date;
    }
    /**
     * @return the $_alloted_category
     */
    public function getAlloted_category ()
    {
        return $this->_alloted_category;
    }
    /**
     * @param field_type $_alloted_category
     */
    public function setAlloted_category ($_alloted_category)
    {
        $this->_alloted_category = $_alloted_category;
    }
    /**
     * @return the $_alloted_branch
     */
    public function getAlloted_branch ()
    {
        return $this->_alloted_branch;
    }
    /**
     * @param field_type $_alloted_branch
     */
    public function setAlloted_branch ($_alloted_branch)
    {
        $this->_alloted_branch = $_alloted_branch;
    }
    /**
     * @return the $_state_of_domicile
     */
    public function getState_of_domicile ()
    {
        return $this->_state_of_domicile;
    }
    /**
     * @param field_type $_state_of_domicile
     */
    public function setState_of_domicile ($_state_of_domicile)
    {
        $this->_state_of_domicile = $_state_of_domicile;
    }
    /**
     * @return the $_urban
     */
    public function getUrban ()
    {
        return $this->_urban;
    }
    /**
     * @param field_type $_urban
     */
    public function setUrban ($_urban)
    {
        $this->_urban = $_urban;
    }
    /**
     * @return the $_avails_hostel
     */
    public function getAvails_hostel ()
    {
        return $this->_avails_hostel;
    }
    /**
     * @param field_type $_avails_hostel
     */
    public function setAvails_hostel ($_avails_hostel)
    {
        $this->_avails_hostel = $_avails_hostel;
    }
    /**
     * @return the $_avails_bus
     */
    public function getAvails_bus ()
    {
        return $this->_avails_bus;
    }
    /**
     * @param field_type $_avails_bus
     */
    public function setAvails_bus ($_avails_bus)
    {
        $this->_avails_bus = $_avails_bus;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_Member_Student $mapper
     * @return Core_Model_Member_Student
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Member_Student
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Member_Student());
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
    /**
     * Fetches CRITICAL information of a Student
     *
     */
    public function fetchCriticalInfo ()
    {
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            $careless_error = 'Please provide a Member Id';
            throw new Exception($careless_error);
        } else {
            $options = $this->getMapper()->fetchCriticalInfo($member_id);
            if (sizeof($options) == 0) {
                $no_data_error = 'NO DATA EXISTS FOR MEMBER ID : ' . $member_id;
                throw new Exception($no_data_error);
            } else {
                $this->setOptions($options);
                return true;
            }
        }
    }
    /**
     * Fetches information regarding CLASS of a Student
     * 
     */
    public function fetchClassInfo ()
    {
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            $error = 'Please provide a Member Id';
            throw new Exception($error);
        } else {
            $options = $this->getMapper()->fetchClassInfo($member_id);
            if (sizeof($options) == 0) {
                $no_data_error = 'NO INFORMATION REGARDING CLASS EXISTS FOR MEMBER ID : ' .
                 $member_id;
                throw new Exception($no_data_error);
            } else {
                $this->setOptions($options);
                return true;
            }
        }
    }
    public function fetchAdmissionInfo ()
    {
        $member_id = $this->getMember_id();
        if (empty($member_id)) {
            $error = 'Please provide a Member Id';
            throw new Exception($error);
        } else {
            $options = $this->getMapper()->fetchAdmissionInfo($member_id);
            if (sizeof($options) == 0) {
                $no_data_error = 'NO INFORMATION REGARDING ADMISSION EXISTS FOR MEMBER ID : ' .
                 $member_id;
                throw new Exception($no_data_error);
            } else {
                $this->setOptions($options);
                return true;
            }
        }
    }
    public function saveCriticalInfo ($data_array)
    {
        $preparedDataForSaveProcess = $this->prepareDataForSaveProcess(
        $data_array);
        $this->getMapper()->saveCriticalInfo($preparedDataForSaveProcess);
    }
    public function saveAdmissionInfo ($data_array)
    {
        $preparedDataForSaveProcess = $this->prepareDataForSaveProcess(
        $data_array);
        $this->setOptions($preparedDataForSaveProcess);
        $this->getMapper()->saveAdmissionInfo($preparedDataForSaveProcess);
    }
    public function saveClassInfo ($data_array)
    {
        $preparedDataForSaveProcess = $this->prepareDataForSaveProcess(
        $data_array);
        $this->setOptions($preparedDataForSaveProcess);
        $this->getMapper()->saveClassInfo($preparedDataForSaveProcess);
    }
}