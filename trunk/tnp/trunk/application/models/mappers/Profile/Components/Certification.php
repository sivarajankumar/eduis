<<?php
class Tnp_Model_Mapper_Profile_Components_Certification
{
    /**
     * @var Zend_Db_Table_Abstract
     */
    protected $_dbTable;
    /**
     * Specify Zend_Db_Table instance to use for data operations
     * 
     * @param  Zend_Db_Table_Abstract $dbTable 
     * @return Tnp_Model_Mapper_Profile_Components_Certification
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
            $this->setDbTable('Tnp_Model_DbTable_StudentCertification');
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
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchMemberCertificationInfo (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $member_id = $certification->getMember_id();
        if (! isset($member_id)) {
            throw new Exception('Please provide member_id first. ');
        } else {
            $required_fields = array('certification_id', 'start_date', 
            'complete_date');
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from($this->getDbTable()
                ->info('name'), $required_fields)
                ->where('member_id = ?', $member_id);
            $certification_info = array();
            $certification_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $certification_info;
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchCertification_id (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $certification_name = $certification->getCertification_name();
        $technical_field_id = $certification->getTechnical_field_id();
        if (! isset($certification_name) or ! isset($technical_field_id)) {
            throw new Exception(
            'Insufficient Params.. certificationName, TechFieldId both are required');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('certification', 'certification_id')
                ->where('certification_name = ?', $certification_name)
                ->where('technical_field_id = ?', $technical_field_id);
            $certification_id = $select->query()->fetchColumn();
            $certification->setCertification_id($certification_id);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchCertificationInfo (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $certification_id = $certification->getCertification_id();
        if (! isset($certification_id)) {
            throw new Exception('Insufficient Params.. certificationId not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $requiredFields = array('certification_id','certification_name', 'technical_field_id');
            $select = $adapter->select()
                ->from('certification', $requiredFields)
                ->where('certification_id = ?', $certification_id);
            $certification_info = array();
            $certification_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $certification_info[$certification_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchTechnical_field_id (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $technical_field_name = $certification->getTechnical_field_name();
        $technical_sector = $certification->getTechnical_sector();
        if (! isset($technical_field_name) or ! isset($technical_sector)) {
            throw new Exception(
            'Insufficient Params.. Techsector, TechFieldName both are required to get tech field id');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $select = $adapter->select()
                ->from('technical_fields', 'technical_field_id')
                ->where('technical_field_name = ?', $technical_field_name)
                ->where('technical_sector = ?', $technical_sector);
            $technical_field_id = $select->query()->fetchColumn();
            $certification->setTechnical_field_id($technical_field_id);
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchTechnicalFieldInfo (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $technical_field_id = $certification->getTechnical_field_id();
        if (! isset($technical_field_id)) {
            throw new Exception(
            'Insufficient Params.. technical_field_id not set');
        } else {
            $adapter = $this->getDbTable()->getDefaultAdapter();
            $requiredFields = array('technical_field_id','technical_field_name', 'technical_sector');
            $select = $adapter->select()
                ->from('technical_fields', $requiredFields)
                ->where('technical_field_id = ?', $technical_field_id);
            $technical_field_info = $select->query()->fetchAll(
            Zend_Db::FETCH_UNIQUE);
            return $technical_field_info[$technical_field_id];
        }
    }
    /**
     * 
     * @param Tnp_Model_Profile_Components_Certification $certification
     */
    public function fetchMemberId (
    Tnp_Model_Profile_Components_Certification $certification)
    {
        $certification_id = $certification->getCertification_id();
        $searchPreReq = self::searchPreRequisite($certification);
        $start_date = $certification->getStart_date();
        $complete_date = $certification->getComplete_date();
        $adapter = $this->getDbTable()->getDefaultAdapter();
        $select = $adapter->select()->from(
        ($this->getDbTable()
            ->info('name')), 'member_id');
        if ($searchPreReq == true) {
            self::fetchTechnical_field_id($certification);
            self::fetchCertification_id($certification);
            $select->where('certification_id = ?', $certification_id);
        }
        if (isset($start_date)) {
            $select->where('start_date = ?', $start_date);
        }
        if (isset($complete_date)) {
            $select->where('complete_date = ?', $complete_date);
        }
        return $select->query()->fetchColumn();
    }
    /**
     * 
     */
    protected function searchPreRequisite ($certification)
    {
        /**
         * @todo search cant be made by using only one of techSec or TechFieldName.. both have to be specified
         *reason :we are looking for members with certification course ex: ccna(certName) in networking(field name) of CSE(techField)
         *this function cannot be used to search students with certification in hardware field of CSE and ECE sector together 
         */
        $techFieldName = $certification->getTechnical_field_name();
        $techSector = $certification->getTechnical_sector();
        $certiName = $certification->getCertification_name();
        if (! isset($techFieldName) or ! isset($techSector) or
         ! isset($certiName)) {
            throw new Exception(
            'Insufficient Params.. Techsector, TechFieldName, CetificationName are all required');
            return false;
        } else {
            return true;
        }
    }
}