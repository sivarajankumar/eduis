<?php
class Tnp_Model_Core_Roles extends Tnp_Model_Generic
{
    protected $_role_id;
    protected $_role_name;
    protected $_mapper;
    /**
     * @return the $_role_id
     */
    public function getRole_id ($throw_exception = null)
    {
        $role_id = $this->_role_id;
        if (empty($role_id) and $throw_exception == true) {
            $message = '_role_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $role_id;
        }
    }
    /**
     * @return the $_role_name
     */
    public function getRole_name ($throw_exception = null)
    {
        $role_name = $this->_role_name;
        if (empty($role_name) and $throw_exception == true) {
            $message = '_role_name is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $role_name;
        }
    }
    /**
     * @param field_type $_role_id
     */
    public function setRole_id ($_role_id)
    {
        $this->_role_id = $_role_id;
    }
    /**
     * @param field_type $_role_name
     */
    public function setRole_name ($_role_name)
    {
        $this->_role_name = $_role_name;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Core_Roles $mapper
     * @return Tnp_Model_Core_Roles
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Core_Roles
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Core_Roles());
        }
        return $this->_mapper;
    }
}