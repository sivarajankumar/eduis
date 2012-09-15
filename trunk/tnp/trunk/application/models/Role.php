<?php
class Tnp_Model_Role extends Tnp_Model_Generic
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
            $message = '_role_id is not set in ' . get_class($this);
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
            $message = '_role_name is not set in ' . get_class($this);
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
     * @param Tnp_Model_Mapper_Role $mapper
     * @return Tnp_Model_Role
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Role
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Role());
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
     *@return array ,Format =array($role_id=>$role_name)
     */
    public function fetchRoles ()
    {
        $roles = array();
        $roles = $this->getMapper()->fetchRoles();
        if (empty($roles)) {
            return false;
        } else {
            return $roles;
        }
    }
    public function fetchInfo ()
    {
        $role_id = $this->getRole_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($role_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
    public function saveInfo ($data_array)
    {
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->save($prepared_data);
    }
    public function updateInfo ($data_array)
    {
        $role_id = $this->getRole_id(true);
        $this->initSave();
        $prepared_data = $this->prepareDataForSaveProcess($data_array);
        return $this->getMapper()->update($prepared_data, $role_id);
    }
    public function deleteRole ()
    {
        $role_id = $this->getRole_id(true);
        return $this->getMapper()->delete($role_id);
    }
}