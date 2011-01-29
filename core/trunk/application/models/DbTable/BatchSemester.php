<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage BatchSemester
 * @since	   0.1
 */
class Core_Model_DbTable_BatchSemester extends Corez_Base_Model
{
    protected $_name = 'batch_semester';
    const TABLE_NAME = 'batch_semester';
    /**
     * An active batch's current semester.
     * 
     * @param string Batch's Department
     * @param string Batch's Degree
     * @param string Batch's start_year
     */
    public function getBatchSemester ($department, $degree, $batch_start)
    {
        $sql = $this->select()
            ->from($this->_name, array('semester_id'))
            ->where('degree_id = ?', $degree)
            ->where('department_id = ?', $department)
            ->where('batch_start = ?', $batch_start);
        return $sql->query()->fetchAll();
    }
    /**
     * Semester's Batch
     * 
     * @param string Department
     * @param string Degree
     * @param string Semester
     */
    public function semesterBatch ($department, $degree, $semester)
    {
        $sql = $this->select()
            ->from($this->_name, array('batch_start'))
            ->where('degree_id = ?', $degree)
            ->where('department_id = ?', $department)
            ->where('semester_id = ?', $semester);
        return $sql->query()->fetchAll();
    }
    /**
     * Increase Batch's Semester status
     */
    public function updateBatchSemester ()
    {
        ;
    }
}