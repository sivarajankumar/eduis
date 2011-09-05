<?php
/**
 * Period model
 *
 * Utilizes the Data Mapper pattern to persist data. Represents a single 
 * period.
 * 
 * @uses       Acad_Model_TimetableMapper
 */
class Acad_Model_Timetable
{
    /**
     * Constructor
     * 
     * @param  array|null $options 
     * @return Acad_Model_Timetable
     */
    public function __construct ($periodId)
    {
        self::setPeriodId($periodId);
        return $this;
    }
    /**
     * Set data mapper
     * 
     * @param  mixed $mapper 
     * @return Acad_Model_Timetable
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * Get data mapper
     *
     * Lazy loads Acad_Model_TimetableMapper instance if no mapper registered.
     * 
     * @return Acad_Model_TimetableMapper
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Acad_Model_TimetableMapper());
        }
        return $this->_mapper;
    }
    
    /**
     * Get Period Department
     * @return array $periodInfo Period Department
     */
    public function getDepartment ()
    {
        if (null === $this->_periodInfo) {
            $this->_setPeriodInfo();
        }
        return $this->_periodInfo['department_id'];
    }
    /**
     * Get Period Degree
     * @return array $periodInfo Period Degree
     */
    public function getDegree ()
    {
        if (null === $this->_periodInfo) {
            $this->_setPeriodInfo();
        }
        return $this->_periodInfo['degree_id'];
    }
    /**
     * Get Period Semester
     * @return array Period Semester
     */
    public function getSemester ()
    {
        if (null === $this->_periodInfo) {
            $this->_setPeriodInfo();
        }
        return $this->_periodInfo['semester_id'];
    }
    /**
     * Get group(s) assigned to this period. 
     * @return array $groups
     */
    public function getGroups ($periodDate, $faculty = null)
    {
        $sql = Acad_Model_DbTable_Period::getDefaultAdapter()->select()
            ->from('timetable', array('timetable_id', 'group_id'))
            ->where("period_id = ?  ", $this->_periodId)
            ->where(
        "? between `timetable`.valid_from AND `timetable`.valid_upto", 
        $periodDate);
        if (isset($faculty)) {
            $sql->where("staff_id = ?", $faculty);
        }
        $groups = $sql->query()->fetchAll();
        $resultSet = null;
        $is_all = false;
        $timetable_id = '';
        foreach ($groups as $key => $value) {
            if (strtoupper($value['group_id']) == 'ALL') {
                $is_all = true;
                $timetable_id = $value['timetable_id'];
                break;
            }
        }
        if ($is_all) {
            $all_Groups = Acad_Model_DbTable_Groups::getClassGroups(
            $this->getDepartment(), $this->getDegree());
            foreach ($all_Groups as $key => $value) {
                $resultSet[$key]['group_id'] = $value;
                $resultSet[$key]['timetable_id'] = $timetable_id;
            }
            return $resultSet;
        } else {
            return $groups;
        }
    }
    /**
     * Get students in this period. 
     * @return array $groups
     */
    public function getStudents ($periodDate, $faculty = null)
    {
        $class = new Acad_Model_Class();
        $class->setDepartment($this->getDepartment())
            ->setDegree($this->getDegree())
            ->setSemester($this->getSemester());
        $groupWiseStudents = array();
        $groups = self::getGroups($periodDate, $faculty);
        foreach ($groups as $key => $group) {
            $groupWiseStudents[$group['group_id']] = $class->getStudents($group['group_id']);
        }
    }
    /**
     * Save the current entry
     * 
     * @return void
     */
    public function save ()
    {
        $this->getMapper()->save($this);
    }
}
?>