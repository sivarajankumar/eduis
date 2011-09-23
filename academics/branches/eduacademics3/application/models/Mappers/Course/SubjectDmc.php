<?php
class Acad_Model_Mapper_Course_SubjectDmc
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_Mapper_Course_SubjectDmc
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
            $this->setDbTable('Acad_Model_DbTable_SubjectDmc');
        }
        return $this->_dbTable;
    }
    /**
     * 
     * @todo
     */
    public function save ()
    {}
    /**
     * 
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchMarksHistory (Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        $regNo = $subjectDmc->getU_regn_no();
        $subjCode = $subjectDmc->getSubject_code();
        $appearType = $subjectDmc->getAppear_type();
        if (! isset($regNo) or ! isset($subjCode)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug(
            'Insufficient data provided.. both regNO and subCode are required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('dmc_record', 'marks')
                ->where('u_regn_no = ?', $regNo)
                ->where('subject_code', $subjCode);
            if (isset($appearType)) {
                $select->where('appear_type = ?', $appearType);
            }
            return $select->query()->fetchColumn();
        }
    }
    /**
     * 
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchDetails (Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        $regNo = $subjectDmc->getU_regn_no();
        $subjCode = $subjectDmc->getSubject_code();
        $marks = $subjectDmc->getMarks();
        if (! isset($regNo) or ! isset($subjCode) or ! isset($marks)) {
            $logger = Zend_Registry::get('logger');
            $logger->debug(
            'Insufficient data provided..  regNO, subCode and subjMarks are ALL required');
        } else {
            $sql = 'SELECT
    `dmc_record`.`subject_code`
    , `dmc_record`.`marks`
    , `dmc_record`.`appear_type`
    , `dmc_info`.`custody_date`
    , `dmc_info`.`is_granted`
    , `dmc_info`.`grant_date`
    , `dmc_info`.`recieving_date`
    , `dmc_info`.`is_copied`
    , `dmc_info`.`dispatch_date`
    , `dmc_info`.`u_regn_no`
FROM
    `academics`.`dmc_record`
    INNER JOIN `academics`.`dmc_info` 
        ON (`dmc_record`.`dmc_id` = `dmc_info`.`dmc_id`)
WHERE (`dmc_record`.`subject_code` = ?
    AND `dmc_record`.`marks` = ?
    AND `dmc_info`.`u_regn_no` = ?)';
            $bind[] = $subjCode;
            $bind[] = $marks;
            $bind[] = $regNo;
            $fetchall = Zend_Db_Table::getDefaultAdapter()->query($sql, $bind)->fetchAll();
            $result = array();
            foreach ($fetchall as $row) {
                foreach ($row as $columnName => $columnValue) {
                    $result[$columnName] = $columnValue;
                }
            }
            return $result;
        }
    }
    /**
     * @todo incomplete
     * @param Acad_Model_Course_SubjectDmc $subjectDmc
     */
    public function fetchMemberId( Acad_Model_Course_SubjectDmc $subjectDmc)
    {
        
    }
}