<?php

/**
 * Period data mapper
 *
 * Implements the Data Mapper design pattern:
 * http://www.martinfowler.com/eaaCatalog/dataMapper.html
 * 
 * @uses       Acad_Model_DbTable_Period
 */
class Acad_Model_PeriodMapper
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;

    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Acad_Model_PeriodMapper
     */
    public function setDbTable($dbTable)
    {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
        if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Invalid table data gateway provided');
        }
        $this->_dbTable = $dbTable;
        return $this;
    }

    /**
     * Get registered Zend_Db_Table instance
     *
     * Lazy loads Acad_Model_DbTable_Period if no instance registered
     * 
     * @return Acad_Model_DbTable_Period
     */
    public function getDbTable()
    {
        if (null === $this->_dbTable) {
            $this->setDbTable('Acad_Model_DbTable_Period');
        }
        return $this->_dbTable;
    }

    /**
     * Save a period entry
     * 
     * @param  Acad_Model_Period $period 
     * @return void
     */
    public function save(Acad_Model_Period $period)
    {
        /*
        $data = array(
            'email'   => $guestbook->getEmail(),
            'comment' => $guestbook->getComment(),
            'created' => date('Y-m-d H:i:s'),
        );

        if (null === ($id = $guestbook->getId())) {
            unset($data['id']);
            $this->getDbTable()->insert($data);
        } else {
            $this->getDbTable()->update($data, array('id = ?' => $id));
        }*/
    }

    /**
     * Find a period entry by id
     * 
     * @param  int $id 
     * @param  Acad_Model_Period $period 
     * @return void
     */
    public function find($id, Acad_Model_Period $period)
    {
        $result = $this->getDbTable()->find($id);
        if (0 == count($result)) {
            return;
        }
        $row = $result->current();
    }

    /**
     * Fetch all guestbook entries
     * 
     * @return array
     */
    public function fetchAll()
    {
        /*$resultSet = $this->getDbTable()->fetchAll();
        $entries   = array();
        foreach ($resultSet as $row) {
            $entry = new Default_Model_Guestbook();
            $entry->setId($row->id)
                  ->setEmail($row->email)
                  ->setComment($row->comment)
                  ->setCreated($row->created)
                  ->setMapper($this);
            $entries[] = $entry;
        }
        return $entries;*/
    }
}
