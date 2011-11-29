<?php
/**
 * @todo incomplete
 * Enter description here ...
 * 
 */
class Tnp_Model_Mapper_Profile_Member_Student
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Profile_Components_Experience
     */
    public function setDbTable ($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (! $dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }
    /**
     * Get registered Zend_Db_Table instance
     * @return Zend_Db_Table_Abstract
     */
    public function getDbTable ()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Tnp_Model_DbTable_Student');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * Enter description here ...
     * @param array $options
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function save ($options, Tnp_Model_Profile_Member_Student $student)
    {
        $save_stu = $student->getSave_student();
        $save_skills = $student->getSave_skills();
        $save_stu_skills = $student->getSave_stu_skills();
        $save_lang = $student->getSave_lang();
        $save_stu_lang = $student->getSave_stu_lang();
        $save_profile_status = $student->getSave_profile_status();
        $save_job_pref = $student->getSave_job_pref();
        $save_co_curri = $student->getSave_co_curri();
        if (isset($save_stu)) {
            $dbtable = new Tnp_Model_DbTable_Student_Semester();
        }
        if (isset($save_skills)) {
            $dbtable = new Tnp_Model_DbTable_Skills();
        }
        if (isset($save_stu_skills)) {
            $dbtable = new Tnp_Model_DbTable_Student_Skills();
        }
        if (isset($save_lang)) {
            $dbtable = new Tnp_Model_DbTable_Languages();
        }
        if (isset($save_stu_lang)) {
            $dbtable = new Tnp_Model_DbTable_Student_Language();
        }
        if (isset($save_profile_status)) {
            $dbtable = new Tnp_Model_DbTable_Profile_Status();
        }
        if (isset($save_job_pref)) {
            $dbtable = new Tnp_Model_DbTable_Job_Preferred();
        }
        if (isset($save_co_curri)) {
            $dbtable = new Tnp_Model_DbTable_Co_Curicullar();
        }
        $cols = $dbtable->info('cols');
        //$db_options is $options with keys renamed a/q to db_columns
        $db_options = array();
        foreach ($options as $key => $value) {
            $db_options[$this->correctDbKeys($key)] = $value;
        }
        $db_options_keys = array_keys($db_options);
        $recieved_keys = array_intersect($db_options_keys, $cols);
        $data = array();
        foreach ($recieved_keys as $key_name) {
            $str = "get" . ucfirst($this->correctModelKeys($key_name));
            $data[$key_name] = $student->$str();
        }
        //$adapter = $this->getDbTable()->getAdapter();
        //$where = $adapter->quoteInto("$this->correctDbKeys('member_id') = ?", $student->getMember_id());
        $adapter = $this->getDbTable()->getAdapter();
        $table = $this->getDbTable()->info('name');
        $adapter->beginTransaction();
        try {
            $sql = $adapter->insert($table, $data);
            $adapter->commit();
        } catch (Exception $exception) {
            $adapter->rollBack();
            throw $exception;
        }
    }
    /**
     * @todo reg no
     * Enter description here ...
     * @param unknown_type $student
     */
    public function fetchMemberID (Tnp_Model_Profile_Member_Student $student)
    {
        $roll_no = $student->getRoll_no();
        $department_id = $student->getDepartment_id();
        $programme_id = $student->getProgramme_id();
        $semester_id = $student->getSemester_id();
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('student_semester', 'member_id')
            ->where('department_id = ?', $department_id)
            ->where('programme_id = ?', $programme_id)
            ->where('semester_id = ?', $semester_id)
            ->where('roll_no = ?', $roll_no);
        $result = $select->query()->fetchAll(Zend_Db::FETCH_NAMED);
        return $result[0];
    }
    public function fetchRollNo (Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        $department_id = $student->getDepartment_id();
        $programme_id = $student->getProgramme_id();
        $semester_id = $student->getSemester_id();
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()
            ->from('student_semester', 'roll_no')
            ->where('department_id = ?', $department_id)
            ->where('programme_id = ?', $programme_id)
            ->where('semester_id = ?', $semester_id)
            ->where('member_id = ?', $member_id);
        $result = $select->query()->fetchAll(Zend_Db::FETCH_NAMED);
        return $result[0];
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchSkillsPossessedInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Insufficient Params.. Member\'s Id is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('skill_id', 
            'skill_proficiency' => 'proficiency');
            $select = $adapter->select()
                ->from('student_skills', $required_fields)
                ->where('member_id = ?', $member_id);
            $skills_possessed = array();
            $skills_possessed = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            //Zend_Registry::get('logger')->debug($skills_possessed);
            return $skills_possessed;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchSkillInfo (Tnp_Model_Profile_Member_Student $student)
    {
        $skill_id = $student->getSkill_id();
        if (! isset($skill_id)) {
            $error = 'Insufficient Params.. Skill\'s id is required to get Skill Description';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('skill_id', 'skill_name', 'skill_field');
            $select = $adapter->select()
                ->from('skills', $required_fields)
                ->where('skill_id = ?', $skill_id);
            $skill_details = array();
            $skill_details = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            return $skill_details[$skill_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchLanguagesKnownInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Insufficient Params.. Member\'s Id is required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('language_id', 
            'language_proficiency' => 'proficiency');
            $select = $adapter->select()
                ->from('student_language', $required_fields)
                ->where('member_id = ?', $member_id);
            $languages_known = array();
            $languages_known = $select->query()->fetchAll(Zend_Db::FETCH_UNIQUE);
            //Zend_Registry::get('logger')->debug($languages_known);
            return $languages_known;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchLanguageInfo (Tnp_Model_Profile_Member_Student $student)
    {
        $languages_id = $student->getLanguage_id();
        if (! isset($languages_id)) {
            $error = 'Insufficient Params.. Language\'s id is required to get Language Description';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('language_id', 'language_name');
            $select = $adapter->select()
                ->from('languages', $required_fields)
                ->where('language_id = ?', $languages_id);
            $language_details = array();
            $language_details = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $language_details[$languages_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchCoCuricularInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            $error = 'Insufficient Params.. Member\'s id is required to get his co_curicular details';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('member_id', 'achievements' . 'activities', 
            'hobbies');
            $select = $adapter->select()
                ->from('co_curicullar', $required_fields)
                ->where('member_id = ?', $member_id);
            $co_curicular_details = array();
            $co_curicular_details = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $co_curicular_details[$member_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchJobPreferredInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            $error = 'Insufficient Params.. Member\'s id is required to get his profile status';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('member_id', 'type');
            $select = $adapter->select()
                ->from('job_preferred', $required_fields)
                ->where('member_id = ?', $member_id);
            $job_preferred_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $job_preferred_info[member_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Member_Student $student
     */
    public function fetchProfileStatusInfo (
    Tnp_Model_Profile_Member_Student $student)
    {
        $member_id = $student->getMember_id();
        if (! isset($member_id)) {
            $error = 'Insufficient Params.. Member\'s id is required to get his profile status';
            throw new Exception($error);
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $required_fields = array('member_id', 'exists' . 'is_locked', 
            'last_updated_on');
            $select = $adapter->select()
                ->from('profile_status', $required_fields)
                ->where('member_id = ?', $member_id);
            $profile_status_info = array();
            $profile_status_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $profile_status_info[$member_id];
        }
    }
    /**
     * Enter description here ...
     * @param Tnp_Model_Profile_Member_Student $student
     * @param array $property_range Example :array('name'=>array('from'=>n ,'to'=>m));
     * here 'from' stands for >= AND 'to' stands for <=
     * 
     */
    public function fetchStudents (Tnp_Model_Profile_Member_Student $student, 
    array $setter_options = null, array $property_range = null)
    {
        $setter_options_keys = array_keys($setter_options);
        $property_range_keys = array_keys($property_range);
        $merge = array_merge($setter_options_keys, $property_range_keys);
        //declare table name and table columns for join statement
        $table = array('st' => $this->getDbTable()->info('name'));
        //define 
        //(a)names of tables used for 'join' operation.
        //(b)corresponding join conditions 
        $name1 = array('pr_st' => 'profile_status');
        $cond1 = 'pr_st.member_id = st.member_id';
        $name2 = array('jp' => 'job_preferred');
        $cond2 = 'jb.member_id = st.member_id';
        $name3 = array('st_skl' => 'student_skills');
        $cond3 = 'st_skl.member_id = st.member_id';
        $name4 = array('skl' => 'skills');
        $cond4 = 'st_skl.skill_id = skl.skill_id';
        $name5 = array('st_lng' => 'student_language');
        $cond5 = 'st_lng.member_id = st.member_id';
        $name6 = array('lng' => 'languages');
        $cond6 = 'st_lng.language_id = lng.language_id';
        $name7 = array('co_clr' => 'co_curicullar');
        $cond7 = 'co_clr.member_id = st.member_id';
        //1)get column names of profile_status present in arguments received
        $profile_status_col = array('exists', 'is_locked', 
        'last_updated_on');
        $profile_status_intrsctn = array();
        $profile_status_intrsctn = array_intersect($profile_status_col, $merge);
        //2)get column names of job_preferred present in arguments received
        $job_preferred_col = array('type');
        $job_preferred_intrsctn = array();
        $job_preferred_intrsctn = array_intersect($job_preferred_col, $merge);
        //3)get column names of student_skills present in arguments received
        $student_skills_col = array('proficiency', 'skill_id');
        $student_skills_intrsctn = array_intersect($student_skills_col, $merge);
        //4)get column names of skills present in arguments received
        $skills_col = array('skill_name', 'skill_field');
        $skills_intrsctn = array();
        $skills_intrsctn = array_intersect($skills_col, $merge);
        //5)get column names of student_language present in arguments received
        $student_language_col = array('language_id', 'proficiency');
        $student_language_intrsctn = array();
        $student_language_intrsctn = array_intersect($student_language_col, 
        $merge);
        //6)get column names of languages present in arguments received
        $languages_col = array('language_name');
        $languages_intrsctn = array();
        $languages_intrsctn = array_intersect($languages_col, $merge);
        //7)get column names of co_curicullar present in arguments received
        $co_curicullar_col = array('achievements', 'activities', 
        'hobbies');
        $co_curicullar_intrsctn = array();
        $co_curicullar_intrsctn = array_intersect($co_curicullar_col, $merge);
        //
        $adapter = $this->getDbTable()->getAdapter();
        $select = $adapter->select()->from($table, 'member_id');
        if (! empty($profile_status_intrsctn)) {
            $select->join($name1, $cond1);
        }
        if (! empty($job_preferred_intrsctn)) {
            $select->join($name2, $cond2);
        }
        if (! empty($student_skills_intrsctn)) {
            $select->join($name3, $cond3);
        }
        if (! empty($skills_intrsctn)) {
            $select->join($name4, $cond4);
        }
        if (! empty($student_language_intrsctn)) {
            $select->join($name5, $cond5);
        }
        if (! empty($languages_intrsctn)) {
            $select->join($name6, $cond6);
        }
        if (! empty($co_curicullar_intrsctn)) {
            $select->join($name7, $cond7);
        }
        foreach ($property_range as $key => $range) {
            if (! empty($range['from'])) {
                $select->where("$key >= ?", $range['from']);
            }
            if (! empty($range['to'])) {
                $select->where("$key <= ?", $range['to']);
            }
        }
        foreach ($setter_options as $property_name => $value) {
            $getter_string = 'get' . ucfirst($property_name);
            $student->$getter_string();
            $condition = $property_name . ' = ?';
            $select->where($condition, $value);
        }
        $result = $select->query()->fetchAll(Zend_Db::FETCH_COLUMN);
        if (! empty($result)) {
            $serach_error = 'No results match your search criteria.';
            return $serach_error;
        } else {
            return $result;
        }
         //Zend_Registry::get('logger')->debug($select->__toString());
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
}