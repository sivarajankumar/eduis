<?php
class Acad_Model_Member_StudentSemester extends Acad_Model_Generic
{
    protected $_save_student = false;
    protected $_save_stu_sem = false;
    protected $_member_id;
    protected $_roll_no;
    protected $_department_id;
    protected $_programme_id;
    protected $_semester_id;
    protected $_start_time;
    protected $_completion;
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
     * @return the $_save_stu_sem
     */
    public function getSave_stu_sem ()
    {
        return $this->_save_stu_sem;
    }
    /**
     * @param field_type $_save_stu_sem
     */
    public function setSave_stu_sem ($_save_stu_sem)
    {
        $this->_save_stu_sem = $_save_stu_sem;
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
     * @return the $_start_time
     */
    public function getStart_time ()
    {
        return $this->_start_time;
    }
    /**
     * @param field_type $_start_time
     */
    public function setStart_time ($_start_time)
    {
        $this->_start_time = $_start_time;
    }
    /**
     * @return the $_completion
     */
    public function getCompletion ()
    {
        return $this->_completion;
    }
    /**
     * @param field_type $_completion
     */
    public function setCompletion ($_completion)
    {
        $this->_completion = $_completion;
    }
    /**
     * Set Subject Mapper
     * @param Acad_Model_Mapper_Member_StudentSemester
     * @return Acad_Model_Member_StudentSemester
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Member_StudentSemester
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Member_StudentSemester());
        }
        return $this->_mapper;
    }
    public function enroll ($options)
    {
        $roll_no = $options['roll_no'];
        if (! isset($roll_no)) {
            throw new Exception(
            'Insufficient data provided..   roll_no is required');
        } else {
            $this->setSave_stu_sem(true);
            parent::save($options);
        }
    }
    /**
     * Enter description here ...
     * @throws Exception
     */
    public function findMemberID ()
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
            $options = $this->getMapper()->fetchMemberID($this);
            $this->setOptions($options);
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
}