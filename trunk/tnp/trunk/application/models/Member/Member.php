<?php
class Tnp_Model_Member_Member extends Tnp_Model_Generic
{
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
    protected $_mapper;
    /**
     * @param bool $throw_exception optional
     * @return the $_member_id
     */
    public function getMember_id ($throw_exception = null)
    {
        $member_id = $this->_member_id;
        if (empty($member_id) and $throw_exception == true) {
            $message = 'Member_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_id;
        }
    }
    /**
     * @return the $_member_type_id
     */
    public function getMember_type_id ($throw_exception = null)
    {
        $member_type_id = $this->_member_type_id;
        if (empty($member_type_id) and $throw_exception == true) {
            $message = 'Member_type_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_type_id;
        }
    }
    /**
     * @return the $_member_type_name
     */
    public function getMember_type_name ()
    {
        return $this->_member_type_name;
    }
    /**
     * @return the $_first_name
     */
    public function getFirst_name ()
    {
        return $this->_first_name;
    }
    /**
     * @return the $_middle_name
     */
    public function getMiddle_name ()
    {
        return $this->_middle_name;
    }
    /**
     * @return the $_last_name
     */
    public function getLast_name ()
    {
        return $this->_last_name;
    }
    /**
     * @return the $_dob
     */
    public function getDob ()
    {
        return $this->_dob;
    }
    /**
     * @return the $_gender
     */
    public function getGender ()
    {
        return $this->_gender;
    }
    /**
     * @return the $_blood_group
     */
    public function getBlood_group ()
    {
        return $this->_blood_group;
    }
    /**
     * @return the $_cast_id
     */
    public function getCast_id ()
    {
        return $this->_cast_id;
    }
    /**
     * @return the $_nationality_id
     */
    public function getNationality_id ()
    {
        return $this->_nationality_id;
    }
    /**
     * @return the $_religion_id
     */
    public function getReligion_id ()
    {
        return $this->_religion_id;
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
     * @return the $_join_date
     */
    public function getJoin_date ()
    {
        return $this->_join_date;
    }
    /**
     * @return the $_relieve_date
     */
    public function getRelieve_date ()
    {
        return $this->_relieve_date;
    }
    /**
     * @return the $_image_no
     */
    public function getImage_no ()
    {
        return $this->_image_no;
    }
    /**
     * @return the $_is_active
     */
    public function getIs_active ($throw_exception = null)
    {
        return $this->_is_active;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_member_type_id
     */
    public function setMember_type_id ($_member_type_id)
    {
        $this->_member_type_id = $_member_type_id;
    }
    /**
     * @param field_type $_member_type_name
     */
    public function setMember_type_name ($_member_type_name)
    {
        $this->_member_type_name = $_member_type_name;
    }
    /**
     * @param field_type $_first_name
     */
    public function setFirst_name ($_first_name)
    {
        $this->_first_name = $_first_name;
    }
    /**
     * @param field_type $_middle_name
     */
    public function setMiddle_name ($_middle_name)
    {
        $this->_middle_name = $_middle_name;
    }
    /**
     * @param field_type $_last_name
     */
    public function setLast_name ($_last_name)
    {
        $this->_last_name = $_last_name;
    }
    /**
     * @param field_type $_dob
     */
    public function setDob ($_dob)
    {
        $this->_dob = $_dob;
    }
    /**
     * @param field_type $_gender
     */
    public function setGender ($_gender)
    {
        $this->_gender = $_gender;
    }
    /**
     * @param field_type $_blood_group
     */
    public function setBlood_group ($_blood_group)
    {
        $this->_blood_group = $_blood_group;
    }
    /**
     * @param field_type $_cast_id
     */
    public function setCast_id ($_cast_id)
    {
        $this->_cast_id = $_cast_id;
    }
    /**
     * @param field_type $_nationality_id
     */
    public function setNationality_id ($_nationality_id)
    {
        $this->_nationality_id = $_nationality_id;
    }
    /**
     * @param field_type $_religion_id
     */
    public function setReligion_id ($_religion_id)
    {
        $this->_religion_id = $_religion_id;
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
     * @param field_type $_join_date
     */
    public function setJoin_date ($_join_date)
    {
        $this->_join_date = $_join_date;
    }
    /**
     * @param field_type $_relieve_date
     */
    public function setRelieve_date ($_relieve_date)
    {
        $this->_relieve_date = $_relieve_date;
    }
    /**
     * @param field_type $_image_no
     */
    public function setImage_no ($_image_no)
    {
        $this->_image_no = $_image_no;
    }
    /**
     * @param field_type $_is_active
     */
    public function setIs_active ($_is_active)
    {
        $this->_is_active = $_is_active;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Member_Member $mapper
     * @return Tnp_Model_Member_Member
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Member_Member
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Member_Member());
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
     * Checks if member is registered in the core
     * 
     * @return true if member_id is registered, false otherwise
     */
    public function memberIdCheck ()
    {
        $member_id = $this->getMember_id(true);
        return $this->getMapper()->memberIdCheck($member_id);
    }
    public function fetchInfo ()
    {
        $member_id = $this->getMember_id(true);
        $info = $this->getMapper()->fetchInfo($member_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function saveInfo ($data_array)
    {
        $member_id = $this->getMember_id(true);
        $data_array['member_id'] = $member_id;
        $check = $this->getMapper()->memberIdCheck($member_id);
        if ($check) {
            unset($data_array['member_id']);
            $this->initSave();
            $preparedData = $this->prepareDataForSaveProcess($data_array);
            return $this->getMapper()->update($preparedData, $member_id);
        } else {
            $data_array['member_id'];
            $this->initSave();
            $preparedData = $this->prepareDataForSaveProcess($data_array);
            return $this->getMapper()->save($preparedData);
        }
    }
    public function register ($registration_info)
    {
        $this->initSave();
        $preparedData = $this->prepareDataForSaveProcess($registration_info);
        $member_id = $preparedData['member_id'];
        $check = $this->getMapper()->memberIdCheck($member_id);
        if ($check) {
            Zend_Registry::get('logger')->debug($member_id);
            Zend_Registry::get('logger')->debug($preparedData['member_type_id']);
            $this->getMapper()->update(
            array('member_type_id' => $preparedData['member_type_id']), 
            $member_id);
        } else {
            return $this->getMapper()->save($preparedData);
        }
    }
    public function saveImageNo ($data_to_save)
    {
        $member_id = $this->getMember_id(true);
        $this->initSave();
        $preparedData = $this->prepareDataForSaveProcess($data_to_save);
        $this->getMapper()->saveImageNo($member_id, $preparedData);
    }
}