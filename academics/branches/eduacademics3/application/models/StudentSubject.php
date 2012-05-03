<?php
class Acad_Model_StudentSubject extends Acad_Model_Generic
{
    protected $_student_subject_id;
    protected $_member_id;
    protected $_class_id;
    protected $_subject_id;
    protected $_mapper;
    /**
     * @return the $_student_subject_id
     */
    public function getStudent_subject_id ()
    {
        return $this->_student_subject_id;
    }
    /**
     * @return the $_member_id
     */
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @return the $_class_id
     */
    public function getClass_id ()
    {
        return $this->_class_id;
    }
    /**
     * @return the $_subject_id
     */
    public function getSubject_id ()
    {
        return $this->_subject_id;
    }
    /**
     * @param field_type $_student_subject_id
     */
    public function setStudent_subject_id ($_student_subject_id)
    {
        $this->_student_subject_id = $_student_subject_id;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_class_id
     */
    public function setClass_id ($_class_id)
    {
        $this->_class_id = $_class_id;
    }
    /**
     * @param field_type $_subject_id
     */
    public function setSubject_id ($_subject_id)
    {
        $this->_subject_id = $_subject_id;
    }
    /**
     * Sets Mapper
     * @param Acad_Model_Mapper_StudentSubject $mapper
     * @return Acad_Model_StudentSubject
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Acad_Model_Mapper_StudentSubject
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_Mapper_StudentSubject());
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
    public function fetchClassIds ()
    {
        $member_id = $this->getMember_id();
        $subject_id = $this->getSubject_id();
        if (empty($member_id) or empty($subject_id)) {
            $error = 'Insufficient params supplied to fetchClassIds() function.Please provide a Member Id and a Subject id';
            throw new Exception($error, Zend_Log::ERR);
        } else {
            $class_ids = $this->getMapper()->fetchClassIds($member_id, 
            $subject_id);
            if (empty($class_ids)) {
                return false;
            } else {
                return $class_ids;
            }
        }
    }
    /**
     * Fetches Marks scored by the student in the given Subject,
     * A student may have studied a Subject more than Once but in Different classes,
     * Ex - Detained Student,therefore subject_id and class_id are required and must be set in the object.Furthermore, a Subject may have multiple Marks corresponding to Different Result_Type_Ids,therefore result_type_id is also required and must be provided as parameter
     * @param integer $result_type_id
     * @param boolean $considered optional 
     * 
     */
    public function fetchDMC ($result_type_id, $considered = null)
    {
        $member_id = $this->getMember_id(true);
        $subject_id = $this->getSubject_id(true);
        $class_id = $this->getClass_id(true);
        if (empty($result_type_id)) {
            $error = 'Insufficient params supplied to fetchDMC() function .Result_type_id Required';
            throw new Exception($error, Zend_Log::ERR);
            return;
        } else {
            $student_subject_id = $this->fetchStudentSubjectId();
            if (! $student_subject_id) {
                $error = 'The Subject with subject id - ' . $subject_id .
                 'was not studied by member_id -' . $member_id;
                throw new Exception($error, Zend_Log::ERR);
            } else {
                $dmc_marks_obj = new Acad_Model_DmcMarks();
                $dmc_marks_obj->setStudent_subject_id($student_subject_id);
                $dmc_marks_obj->setResult_type_id($result_type_id);
                if (isset($considered)) {
                    $dmc_marks_obj->setIs_considered($considered);
                }
                $marks = $dmc_marks_obj->fetchInfo();
                if ($marks instanceof Acad_Model_DmcMarks) {
                    return $marks;
                } else {
                    return false;
                }
            }
        }
    }
    public function fetchStudentSubjectId ()
    {
        $member_id = $this->getMember_id(true);
        $class_id = $this->getClass_id(true);
        $subject_id = $this->getSubject_id(true);
        $stu_subj_id = $this->getMapper()->fetchStudentSubjectId($member_id, 
        $class_id, $subject_id);
        if (empty($stu_subj_id)) {
            return false;
        } else {
            return $stu_subj_id;
        }
    }
    /**
     * 
     * @todo
     * 
     */
    public function fetchSubjectsPassed ($class_id)
    {
        $member_id = $this->getMember_id(true);
        $student_subject_object = new Acad_Model_StudentSubject();
        $student_subject_object->setMember_id($member_id);
        $student_subject_object->setClass_id($class_id);
        $stu_sub_id = $student_subject_object->fetchStudentSubjectId();
        $student_subject_object->setStudent_subject_id($stu_sub_id);
        $dmc_marks = new Acad_Model_DmcMarks();
        $dmc_marks->fetchInfo();
    }
    public function fetchSubjectPassedStatus ()
    {
        $stu_sub_id = $this->fetchStudentSubjectId();
    }
    /**
     * Fetches Student_subject_id and Subject_id of All subjects studied by a student in an Academic Class
     *
     */
    public function fetchSubjects ()
    {
        $member_id = $this->getMember_id(true);
        $class_id = $this->getClass_id(true);
        $student_subjects = $this->getMapper()->fetchSubjects($member_id, 
        $class_id);
        if (empty($student_subjects)) {
            return false;
        } else {
            return $student_subjects;
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