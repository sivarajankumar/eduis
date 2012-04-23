<?php
class Core_Model_Member_Student extends Core_Model_Generic
{
    protected $_save_student = false;
    protected $_save_stu_per = false;
    protected $_save_stu_dep = false;
    protected $_member_id;
    protected $_reg_no;
    protected $_cast_id;
    protected $_cast;
    protected $_nationality_id;
    protected $_religion_id;
    protected $_nationality;
    protected $_religion;
    protected $_first_name;
    protected $_middle_name;
    protected $_last_name;
    protected $_dob;
    protected $_gender;
    protected $_contact_no;
    protected $_e_mail;
    protected $_marital_status;
    protected $_councelling_no;
    protected $_admission_date;
    protected $_alloted_category;
    protected $_alloted_branch;
    protected $_state_of_domicile;
    protected $_urban;
    protected $_hostel;
    protected $_bus;
    protected $_boarding_station;
    protected $_image_no;
    protected $_blood_group;
    protected $_roll_no;
    protected $_department_id;
    protected $_programme_id;
    protected $_batch_start;
    protected $_group_id;
    protected $_semester_id;
    protected $_mapper;
    /**
     * @return the $_save_student
     */
    public function getSave_student ()
    {
        return $this->_save_student;
    }
    /**
     * @param field_type $_save_student
     */
    public function setSave_student ($_save_student)
    {
        $this->_save_student = $_save_student;
    }
    /**
     * @return the $_save_stu_per
     */
    public function getSave_stu_per ()
    {
        return $this->_save_stu_per;
    }
    /**
     * @param field_type $_save_stu_per
     */
    public function setSave_stu_per ($_save_stu_per)
    {
        $this->_save_stu_per = $_save_stu_per;
    }
    /**
     * @return the $_save_stu_dep
     */
    public function getSave_stu_dep ()
    {
        return $this->_save_stu_dep;
    }
    /**
     * @param field_type $_save_stu_dep
     */
    public function setSave_stu_dep ($_save_stu_dep)
    {
        $this->_save_stu_dep = $_save_stu_dep;
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
        return $this;
    }
    /**
     * @return the $_reg_no
     */
    public function getReg_no ()
    {
        return $this->_reg_no;
    }
    /**
     * @param field_type $_reg_no
     */
    public function setReg_no ($_reg_no)
    {
        $this->_reg_no = $_reg_no;
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
     * @return the $_cast
     */
    public function getCast ()
    {
        return $this->_cast;
    }
    /**
     * @param field_type $_cast
     */
    public function setCast ($_cast)
    {
        $this->_cast = $_cast;
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
     * @return the $_nationality
     */
    public function getNationality ()
    {
        return $this->_nationality;
    }
    /**
     * @param field_type $_nationality
     */
    public function setNationality ($_nationality)
    {
        $this->_nationality = $_nationality;
    }
    /**
     * @return the $_religion
     */
    public function getReligion ()
    {
        return $this->_religion;
    }
    /**
     * @param field_type $_religion
     */
    public function setReligion ($_religion)
    {
        $this->_religion = $_religion;
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
     * @return the $_contact_no
     */
    public function getContact_no ()
    {
        return $this->_contact_no;
    }
    /**
     * @param field_type $_contact_no
     */
    public function setContact_no ($_contact_no)
    {
        $this->_contact_no = $_contact_no;
    }
    /**
     * @return the $_e_mail
     */
    public function getE_mail ()
    {
        return $this->_e_mail;
    }
    /**
     * @param field_type $_e_mail
     */
    public function setE_mail ($_e_mail)
    {
        $this->_e_mail = $_e_mail;
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
     * @return the $_hostel
     */
    public function getHostel ()
    {
        return $this->_hostel;
    }
    /**
     * @param field_type $_hostel
     */
    public function setHostel ($_hostel)
    {
        $this->_hostel = $_hostel;
    }
    /**
     * @return the $_bus
     */
    public function getBus ()
    {
        return $this->_bus;
    }
    /**
     * @param field_type $_bus
     */
    public function setBus ($_bus)
    {
        $this->_bus = $_bus;
    }
    /**
     * @return the $_boarding_station
     */
    public function getBoarding_station ()
    {
        return $this->_boarding_station;
    }
    /**
     * @param field_type $_boarding_station
     */
    public function setBoarding_station ($_boarding_station)
    {
        $this->_boarding_station = $_boarding_station;
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
     * @return the $_department_id
     */
    public function getDepartment_id ()
    {
        return $this->_department_id;
    }
    /**
     * @param field_type $_department_id
     */
    public function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    /**
     * @return the $_programme_id
     */
    public function getProgramme_id ()
    {
        return $this->_programme_id;
    }
    /**
     * @param field_type $_programme_id
     */
    public function setProgramme_id ($_programme_id)
    {
        $this->_programme_id = $_programme_id;
    }
    /**
     * @return the $_batch_start
     */
    public function getBatch_start ()
    {
        return $this->_batch_start;
    }
    /**
     * @param field_type $_batch_start
     */
    public function setBatch_start ($_batch_start)
    {
        $this->_batch_start = $_batch_start;
    }
    /**
     * @return the $_group_id
     */
    public function getGroup_id ()
    {
        return $this->_group_id;
    }
    /**
     * @param field_type $_group_id
     */
    public function setGroup_id ($_group_id)
    {
        $this->_group_id = $_group_id;
    }
    /**
     * @return the $_semester_id
     */
    public function getSemester_id ()
    {
        return $this->_semester_id;
    }
    /**
     * @param field_type $_semester_id
     */
    public function setSemester_id ($_semester_id)
    {
        $this->_semester_id = $_semester_id;
    }
    /**
     * Set Mapper
     * @param Core_Model_Mapper_Member_Student $mapper
     * @return Core_Model_Mapper_Member_Student
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
     * @todo reg no included in search
     * Enter description here ...
     * @throws Exception
     */
    public function findMemberId ()
    {
        $roll_no = $this->getRoll_no();
        $department_id = $this->getDepartment_id();
        $programme_id = $this->getProgramme_id();
        $semester_id = $this->getSemester_id();
        if (! isset($roll_no) or ! isset($department_id) or
         ! isset($programme_id) or ! isset($semester_id)) {
            throw new Exception(
            'Insufficient data provided..   roll_no,department_id,programme_id and semester_id are ALL required');
        } else {
            $member_id = $this->getMapper()->fetchMemberID($this);
            $this->setMember_id($member_id);
        }
    }
    public function findRollNo ()
    {
        $member_id = $this->getMember_id();
        $department_id = $this->getDepartment_id();
        $programme_id = $this->getProgramme_id();
        $semester_id = $this->getSemester_id();
        if (! isset($member_id)) {
            throw new Exception(
            'Insufficient data provided..   department_id,programme_id and semester_id are ALL required');
        } else {
            $options = $this->getMapper()->fetchRollNo($this);
            $this->setOptions($options);
        }
    }
    /**
     * 
     * Enter description here ...
     * @param boolean $personal
     * @param boolean $basic
     * returns false if no data exists for member 
     */
    public function initStudentInfo ($personal = false, $basic = false)
    {
        if ($personal) {
            $options = $this->getMapper()->fetchStudentInfo($this, true);
        } elseif ($basic) {
            $options = $this->getMapper()->fetchStudentInfo($this, false, true);
        } else { //for backward compatibility .. older code calls this
            //function for personal info
            $options = $this->getMapper()->fetchStudentInfo(
            $this, true);
        }
        if ($options === false) {
            return false;
        } else {
            $this->setOptions($options);
            return true;
        }
    }
    public function enroll ($options)
    {
        $roll_no = $options['roll_no'];
        if (! isset($roll_no)) {
            throw new Exception(
            'Insufficient data provided..   roll_no is required');
        } else {
            $this->setSave_student(true);
            parent::save($options);
        }
    }
}