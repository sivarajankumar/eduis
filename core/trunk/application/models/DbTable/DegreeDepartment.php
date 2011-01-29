<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage DegreeDepartment
 * @since	   0.1
 */
class Core_Model_DbTable_DegreeDepartment extends Corez_Base_Model
{
    protected $_name = 'degree_department';
    /**
     * Academic departments
     */
    public static function academicDepartments ()
    {
        $sql = 'SELECT DISTINCT `degree_department`.`department_id`, `department`.`department_name` FROM `degree_department` INNER JOIN `department` ON department.department_id = degree_department.department_id';
        return self::getDefaultAdapter()->query($sql)->fetchAll();
    }
    /**
     * Deparment's Degree(s)
     * 
     * @param string Department
     * @return array Degree(s) of given department.
     */
    public static function departmentDegree ($departmentid)
    {
        $sql = 'SELECT DISTINCT `degree_department`.`degree_id`, `degree`.`degree_name` FROM `degree_department` INNER JOIN `degree` ON `degree_department`.`degree_id` = `degree`.`degree_id` WHERE (department_id = ?)';
        return self::getDefaultAdapter()->query($sql, $departmentid)->fetchAll();
    }
}