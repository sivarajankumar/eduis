<?php
class Auth_Model_Member_User extends Auth_Model_Generic
{
    protected $_member_id;
    protected $_login_id;
    protected $_sec_passwd;
    protected $_user_salt;
    protected $_user_type_id;
    protected $_department_id;
    protected $_valid_from;
    protected $_valid_upto;
    protected $_is_active;
    protected $_remarks;
    protected $_mapper;
    /**
     * @return the $_member_id
     */
    public function getMember_id ($throw_exception = null)
    {
        $member_id = $this->_member_id;
        if (empty($member_id) and $throw_exception == true) {
            $message = 'Member_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $member_id;
        }
    }
    /**
     * @return the $_login_id
     */
    public function getLogin_id ($throw_exception = null)
    {
        $login_id = $this->_login_id;
        if (empty($login_id) and $throw_exception == true) {
            $message = '_login_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $login_id;
        }
    }
    /**
     * @return the $_sec_passwd
     */
    public function getSec_passwd ($throw_exception = null)
    {
        $sec_passwd = $this->_sec_passwd;
        if (empty($sec_passwd) and $throw_exception == true) {
            $message = '_sec_passwd is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $sec_passwd;
        }
    }
    /**
     * @return the $_user_salt
     */
    public function getUser_salt ($throw_exception = null)
    {
        $user_salt = $this->_user_salt;
        if (empty($user_salt) and $throw_exception == true) {
            $message = '_user_salt is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $user_salt;
        }
    }
    /**
     * @return the $_user_type_id
     */
    public function getUser_type_id ($throw_exception = null)
    {
        $user_type_id = $this->_user_type_id;
        if (empty($user_type_id) and $throw_exception == true) {
            $message = '_user_type_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $user_type_id;
        }
    }
    /**
     * @return the $_department_id
     */
    public function getDepartment_id ($throw_exception = null)
    {
        $department_id = $this->_department_id;
        if (empty($department_id) and $throw_exception == true) {
            $message = '_department_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $department_id;
        }
    }
    /**
     * @return the $_valid_from
     */
    public function getValid_from ($throw_exception = null)
    {
        $valid_from = $this->_valid_from;
        if (empty($valid_from) and $throw_exception == true) {
            $message = '_valid_from is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $valid_from;
        }
    }
    /**
     * @return the $_valid_upto
     */
    public function getValid_upto ($throw_exception = null)
    {
        $valid_upto = $this->_valid_upto;
        if (empty($valid_upto) and $throw_exception == true) {
            $message = '_valid_upto is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $valid_upto;
        }
    }
    /**
     * @return the $_is_active
     */
    public function getIs_active ($throw_exception = null)
    {
        $is_active = $this->_is_active;
        if (empty($is_active) and $throw_exception == true) {
            $message = '_is_active is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $is_active;
        }
    }
    /**
     * @return the $_remarks
     */
    public function getRemarks ()
    {
        return $this->_remarks;
    }
    /**
     * @param field_type $_member_id
     */
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_login_id
     */
    public function setLogin_id ($_login_id)
    {
        $this->_login_id = $_login_id;
    }
    /**
     * @param field_type $_sec_passwd
     */
    public function setSec_passwd ($_sec_passwd)
    {
        $this->_sec_passwd = $_sec_passwd;
    }
    /**
     * @param field_type $_user_salt
     */
    public function setUser_salt ($_user_salt)
    {
        $this->_user_salt = $_user_salt;
    }
    /**
     * @param field_type $_user_type_id
     */
    public function setUser_type_id ($_user_type_id)
    {
        $this->_user_type_id = $_user_type_id;
    }
    /**
     * @param field_type $_department_id
     */
    public function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    /**
     * @param field_type $_valid_from
     */
    public function setValid_from ($_valid_from)
    {
        $this->_valid_from = $_valid_from;
    }
    /**
     * @param field_type $_valid_upto
     */
    public function setValid_upto ($_valid_upto)
    {
        $this->_valid_upto = $_valid_upto;
    }
    /**
     * @param field_type $_is_active
     */
    public function setIs_active ($_is_active)
    {
        $this->_is_active = $_is_active;
    }
    /**
     * @param field_type $_remarks
     */
    public function setRemarks ($_remarks)
    {
        $this->_remarks = $_remarks;
    }
    /**
     * Sets Mapper
     * @param Auth_Model_Mapper_Member_User $mapper
     * @return Auth_Model_Member_User
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Auth_Model_Mapper_Member_User
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Auth_Model_Mapper_Member_User());
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
    public function fetchAuthInfo ()
    {
        $member_id = $this->getMember_id(true);
        $info = array();
        $info = $this->getMapper()->fetchAuthUserInfo($member_id);
        if (empty($info)) {
            return false;
        } else {
            return $info;
        }
    }
    public function fetchMemberId ()
    {
        $login_id = $this->getLogin_id(true);
        return $this->getMapper()->fetchAuthUserInfo(null, $login_id);
    }
    public function saveAuthInfo ($data_array)
    {
        $member_id = isset($data_array['member_id'])?$data_array['member_id']:NULL;
        //$this->setLogin_id($login_id);
        //$member_id = $this->fetchMemberId($login_id);
        if (empty($member_id)) {
        	try {
        	Zend_Db_Table::getDefaultAdapter()->beginTransaction();
            $this->initSave();
            $preparedData = $this->prepareDataForSaveProcess($data_array);
            $member_id = $this->getMapper()->save($preparedData);
            //@TODO Orphan code needs a right place.
            $userRole = new Auth_Model_DbTable_UserRole();
            switch (strtolower($data_array['user_type_id'])) {
            	case 'stu':
            		$userRoleData = array('member_id'=>$member_id,'role_id'=>'student');
            	break;
            	case 'staff':
            		$userRoleData = array('member_id'=>$member_id,'role_id'=>'faculty');
            	break;
            }
            $userRole->insert($userRoleData);
        	Zend_Db_Table::getDefaultAdapter()->commit();
        	return $member_id;
        	} catch (Exception $e){
        		Zend_Db_Table::getDefaultAdapter()->rollBack();
        		throw new Exception("The user registration failed because ".$e->getMessage(), Zend_Log::ERR, $e);
        	}
        } else {
            $this->initSave();
            $preparedData = $this->prepareDataForSaveProcess($data_array);
            $rowsUpdated = $this->getMapper()->update($preparedData, $member_id);
            return $rowsUpdated;
        }
    }
}