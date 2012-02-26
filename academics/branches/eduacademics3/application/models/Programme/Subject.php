<?php
class Acad_Model_Programme_Subject extends Acad_Model_Generic
{
    protected $_semester_subjects = array();
    protected $_associated_departments = array();
    protected $_associated_programmes = array();
    protected $_associated_semesters = array();
    protected $_associated_members = array();
    protected $_subject_code;
    protected $_abbr;
    protected $_subject_name;
    protected $_subject_type_id;
    protected $_is_optional;
    protected $_lecture_per_week;
    protected $_tutorial_per_week;
    protected $_practical_per_week;
    protected $_suggested_duration;
    protected $_department_id;
    protected $_programme_id;
    protected $_semester_id;
    protected $_member_id;
    protected $_mapper;
    /**
     * @return the $_semester_subjects
     */
    public function getSemester_subjects ()
    {
        return $this->_semester_subjects;
    }
    /**
     * @param field_type $_semester_subjects
     */
    public function setSemester_subjects ($_semester_subjects)
    {
        $this->_semester_subjects = $_semester_subjects;
    }
    /**
     * @return the $_associated_departments
     */
    public function getAssociated_departments ()
    {
        return $this->_associated_departments;
    }
    /**
     * @param field_type $_associated_departments
     */
    public function setAssociated_departments ($_associated_departments)
    {
        $this->_associated_departments = $_associated_departments;
    }
    /**
     * @return the $_associated_programmes
     */
    public function getAssociated_programmes ()
    {
        return $this->_associated_programmes;
    }
    /**
     * @param field_type $_associated_programmes
     */
    public function setAssociated_programmes ($_associated_programmes)
    {
        $this->_associated_programmes = $_associated_programmes;
    }
    /**
     * @return the $_associated_semesters
     */
    public function getAssociated_semesters ()
    {
        return $this->_associated_semesters;
    }
    /**
     * @param field_type $_associated_semesters
     */
    public function setAssociated_semesters ($_associated_semesters)
    {
        $this->_associated_semesters = $_associated_semesters;
    }
    /**
     * @return the $_associated_members
     */
    public function getAssociated_members ()
    {
        return $this->_associated_members;
    }
    /**
     * @param field_type $_associated_members
     */
    public function setAssociated_members ($_associated_members)
    {
        $this->_associated_members = $_associated_members;
    }
    /**
     * @return the $_subject_code
     */
    public function getSubject_code ()
    {
        return $this->_subject_code;
    }
    /**
     * @param field_type $_subject_code
     */
    public function setSubject_code ($_subject_code)
    {
        $this->_subject_code = $_subject_code;
    }
    /**
     * @return the $_abbr
     */
    public function getAbbr ()
    {
        return $this->_abbr;
    }
    /**
     * @param field_type $_abbr
     */
    public function setAbbr ($_abbr)
    {
        $this->_abbr = $_abbr;
    }
    /**
     * @return the $_subject_name
     */
    public function getSubject_name ()
    {
        return $this->_subject_name;
    }
    /**
     * @param field_type $_subject_name
     */
    public function setSubject_name ($_subject_name)
    {
        $this->_subject_name = $_subject_name;
    }
    /**
     * @return the $_subject_type_id
     */
    public function getSubject_type_id ()
    {
        return $this->_subject_type_id;
    }
    /**
     * @param field_type $_subject_type_id
     */
    public function setSubject_type_id ($_subject_type_id)
    {
        $this->_subject_type_id = $_subject_type_id;
    }
    /**
     * @return the $_is_optional
     */
    public function getIs_optional ()
    {
        return $this->_is_optional;
    }
    /**
     * @param field_type $_is_optional
     */
    public function setIs_optional ($_is_optional)
    {
        $this->_is_optional = $_is_optional;
    }
    /**
     * @return the $_lecture_per_week
     */
    public function getLecture_per_week ()
    {
        return $this->_lecture_per_week;
    }
    /**
     * @param field_type $_lecture_per_week
     */
    public function setLecture_per_week ($_lecture_per_week)
    {
        $this->_lecture_per_week = $_lecture_per_week;
    }
    /**
     * @return the $_tutorial_per_week
     */
    public function getTutorial_per_week ()
    {
        return $this->_tutorial_per_week;
    }
    /**
     * @param field_type $_tutorial_per_week
     */
    public function setTutorial_per_week ($_tutorial_per_week)
    {
        $this->_tutorial_per_week = $_tutorial_per_week;
    }
    /**
     * @return the $_practical_per_week
     */
    public function getPractical_per_week ()
    {
        return $this->_practical_per_week;
    }
    /**
     * @param field_type $_practical_per_week
     */
    public function setPractical_per_week ($_practical_per_week)
    {
        $this->_practical_per_week = $_practical_per_week;
    }
    /**
     * @return the $_suggested_duration
     */
    public function getSuggested_duration ()
    {
        return $this->_suggested_duration;
    }
    /**
     * @param field_type $_suggested_duration
     */
    public function setSuggested_duration ($_suggested_duration)
    {
        $this->_suggested_duration = $_suggested_duration;
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
     * Set Subject Mapper
     * @param Acad_Model_Mapper_Programme_Subject $mapper
     * @return Acad_Model_Programme_Subject
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_Programme_Subject
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_Programme_Subject());
        }
        return $this->_mapper;
    }
    protected function condition ()
    {
        $subject_code = $this->getSubject_code(); // neccessary condition
        if (empty($subject_code) or ($subject_code == null)) {
            throw new Exception(
            'Insufficient data provided..  Please provide a Subject_code');
        } else {
            return true;
        }
    }
    public function findAssociatedDepartments ()
    {
        $flag = $this->condition();
        if ($flag) {
            $departments = $this->getMapper()->fetchAssociations($this, true);
            $this->setAssociated_departments($departments);
        }
    }
    public function findAssociatedProgrammes ()
    {
        $flag = $this->condition();
        if ($flag) {
            $programmes = $this->getMapper()->fetchAssociations($this, false, 
            true);
            $this->setAssociated_programmes($programmes);
        }
    }
    public function findAssociatedSemesters ()
    {
        $flag = $this->condition();
        if ($flag) {
            $semesters = $this->getMapper()->fetchAssociations($this, false, 
            false, true);
            $this->setAssociated_semesters($semesters);
        }
    }
    public function findAssociatedMembers ()
    {
        $flag = $this->condition();
        if ($flag) {
            $members = $this->getMapper()->fetchAssociations($this, false, 
            false, false, true);
            $this->setAssociated_members($members);
        }
    }
    public function findSemesterSubjects ()
    {
        $department_id = $this->getDepartment_id();
        $programme_id = $this->getProgramme_id();
        $semester_id = $this->getSemester_id();
        if ((empty($department_id)) or (empty($programme_id)) or
         (empty($semester_id))) {
            throw new Exception(
            'Insufficient data provided..All three neccessary paramters(Department,Programme,Semester) must be provided.');
        } else {
            $result = $this->getMapper()->fetchSemesterSubjects($this);
            $this->setSemester_subjects($result);
        }
    }
}
?>