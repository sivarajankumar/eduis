<?php
/**
 * @category   Authz
 * @package    Resource_Acl
 * @subpackage Acl
 * @copyright  Copyright (c) 2009-2010 HeAvi
 */
class Acadz_Resource_Acl_Guest implements Zend_Auth_Adapter_Interface
{
    /**
     * $_identity - Identity value
     *
     * @var string
     */
    protected $_identity = null;
    const GUEST_ID = 'anon';

	/**
     * __construct() - Sets user as guest if no identity provided.
     *
     * @param  string                   $identity
     * @return void
     */
    public function __construct($identity = null)
    {
        if (null == $identity) {
            $this->setIdentity(self::GUEST_ID);
        } else {
        	 $this->setIdentity(strtolower($identity));
        }
    }
    
    /**
     * setIdentity() - set the value to be used as the identity (in lowercase).
     *
     * @param  string $value
     * @return Zend_Auth_Adapter_DbTable Provides a fluent interface
     */
    public function setIdentity ($value)
    {
        $this->_identity = strtolower($value);
        return $this;
    }
    /**
     * authenticate() - defined by Zend_Auth_Adapter_Interface.  This method is called to
     * attempt an authentication.  Previous to this call, this adapter would have already
     * been configured with all necessary information to successfully connect to a database
     * table and attempt to find a record matching the provided identity.
     *
     * @return Zend_Auth_Result
     */
    public function authenticate ()
    {
        return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->_identity);
    }
}
