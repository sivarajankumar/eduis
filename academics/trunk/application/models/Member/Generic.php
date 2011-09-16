<?php
abstract class Acad_Model_Member_Generic {
	/**
	 * Member identification
	 * @var string|int
	 */
	protected $_memberId;
	
	/**
	 * Member type
	 * @var string
	 */
	protected $_memberType;
	
	/**
	 * Member active
	 * @var bool
	 */
	protected $_isActive;
	
	/**
	 * Member Details
	 * @var array
	 */
	protected $_memberDetails;
	
	/**
	 * Personal information of member
	 * @var array
	 */
	protected $_personalInfo;
	
	/**
	 * Professional/academic information of member
	 * @var array
	 */
	protected $_professionalInfo;
	
	/**
	 * Department of member
	 * @var string
	 */
	protected $_department;
	
	/**
	 * Constructor
	 * 
	 * @param  array|null $options 
	 * @return void
	 */
	public function __construct(array $options = null) {
		if (is_array ( $options )) {
			$this->setOptions ( $options );
		}
	}
	
	/**
	 * Overloading: allow property access
	 * 
	 * @param  string $name 
	 * @param  mixed $value 
	 * @return void
	 */
	public function __set($name, $value) {
		$method = 'set' . $name;
		if ('mapper' == $name || ! method_exists ( $this, $method )) {
			throw new Zend_Exception ( 'Invalid property specified "'.$method.'"', Zend_Log::ERR );
		}
		$this->$method ( $value );
	}
	
	/**
	 * Overloading: allow property access
	 * 
	 * @param  string $name 
	 * @return mixed
	 */
	public function __get($name) {
		$method = 'get' . $name;
		if ('mapper' == $name || ! method_exists ( $this, $method )) {
			throw new Zend_Exception ( 'Invalid property specified "'.$method.'"', Zend_Log::ERR );
		}
		return $this->$method ();
	}
	
	/**
	 * Set object state
	 * 
	 * @param  array $options 
	 * @return Acad_Model_Member_Generic
	 */
	public function setOptions(array $options) {
		$methods = get_class_methods ( $this );
		foreach ( $options as $key => $value ) {
			$method = 'set' . ucfirst ( $key );
			if (in_array ( $method, $methods )) {
				$this->$method ( $value );
			}
		}
		return $this;
	}
	
	/**
	 * Set member identification
	 * @param string|int $memberId
	 * @return Acad_Model_Member_Generic
	 */
	public function setMemberId($memberId = null) {
	    
        if ($memberId != null) {
            $this->_memberId = $memberId;
        } elseif (Zend_Auth::getInstance()->hasIdentity()) {
            $authInfo = Zend_Auth::getInstance()->getStorage()->read();
            $this->_memberId = $authInfo['identity'];
        } else {
            throw new Zend_Exception('Could not determine identity of member', 
            Zend_Log::ERR);
        }
        return $this;
	}
	
	/**
	 * Get member identification
	 * @return string|int $memberId
	 */
	public function getMemberId() {
	    
        if (! $this->_memberId) {
            $this->setMemberId();
        }
	    return $this->_memberId;
	}
	
	/**
	 * Set member type
	 * @param string $memberType
	 * @return Acad_Model_Member_Generic
	 */
	public function setMemberType($memberType) {
		
		return $this;
	}
	
	/**
	 * Get member type
	 * @return string $memberType
	 */
	public function getMemberType() {
	
	}
	
	/**
	 * Set if member is active
	 * @param bool $isActive
	 * @return Acad_Model_Member_Generic
	 */
	public function setIsActive($isActive = 1) {
		
		return $this;
	}
	
	/**
	 * Get if member is active
	 * @return bool $isActive
	 */
	public function getIsActive() {
	    return $this->_isActive;
	}
	
	/**
	 * Set member Details
	 * @param array $memberDetails Member Details
	 */
	public function setMemberDetails(array $memberDetails) {
	    
	}
	
	/**
	 * Get member Details
	 * @return array $memberDetails Member Details
	 */
	public function getMemberDetails() {
	    $this->_memberDetails;
	}
	 
	/**
	 * Set personal information of member
	 * @param array $personalInfo personal information of member
	 * @return Acad_Model_Member_Generic
	 */
	public function setPersonalInfo($personalInfo){
	    
	    return $this;
	}
	
	/**
	 * Get personal information of member
	 * @return array $personalInfo personal information of member
	 */
	public function getPersonalInfo(){
	    $this->_personalInfo;
	}
	
	 
	/**
	 * Set professional/academic information of member
	 * @param array $proInfo professional/academic information of member
	 * @return Acad_Model_Member_Generic
	 */
	public function setProfessionalInfo($proInfo){
	    return $this;
	}
	
	/**
	 * Get professional/academic information of member
	 * @return array $proInfo professional/academic information of member
	 */
	public function getProfessionalInfo(){
	    return $this->_professionalInfo;
	}
	
	 
	/**
	 * Set department of member
	 * @param string $department department of member
	 * @return Acad_Model_Member_Generic
	 */
	public function setDepartment($department){
	    
	    return $this;
	}
	
	/**
	 * Get department of member
	 * @return string $department department of member
	 */
	public function getDepartment(){
	    return $this->_department;
	}
	
}
?>