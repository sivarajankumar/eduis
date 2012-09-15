<?php
class Core_Model_Relations extends Core_Model_Generic
{
    protected $_relation_id;
    protected $_relation_name;
    protected $_mapper;
    /**
     * @return the $_relation_id
     */
    public function getRelation_id ($throw_exception = null)
    {
        $relation_id = $this->_relation_id;
        if (empty($relation_id) and $throw_exception == true) {
            $message = '_relation_id is not set in ' . get_class($this);
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $relation_id;
        }
    }
    /**
     * @return the $_relation_name
     */
    public function getRelation_name ()
    {
        return $this->_relation_name;
    }
    public function setRelation_id ($_relation_id)
    {
        $this->_relation_id = $_relation_id;
    }
    /**
     * @param field_type $_relation_name
     */
    public function setRelation_name ($_relation_name)
    {
        $this->_relation_name = $_relation_name;
    }
    /**
     * Sets Mapper
     * @param Core_Model_Mapper_Relations $mapper
     * @return Core_Model_Relations
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Core_Model_Mapper_Relations
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Core_Model_Mapper_Relations());
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
     * Fetches all Relations
     * @return array
     */
    public function fetchRelations ()
    {
        $relations = $this->getMapper()->fetchRelations();
        if (empty($relations)) {
            return false;
        } else {
            return $relations;
        }
    }
}