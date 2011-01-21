<?php
abstract class Lib_Model_Member_Generic {
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
	 * Membership Information
	 * @var Lib_Model_Membership
	 */
	protected $_membership;
	
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
	 * Borrowed documents by member
	 * @var array
	 */
	protected $_borrowed;
	
	/**
	 * Document Loan History
	 * @var mixed
	 */
	protected $_loanHistory;
	
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
			throw new Zend_Exception ( 'Invalid property specified', Zend_Log::ERR );
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
			throw new Zend_Exception ( 'Invalid property specified', Zend_Log::ERR );
		}
		return $this->$method ();
	}
	
	/**
	 * Set object state
	 * 
	 * @param  array $options 
	 * @return Lib_Model_Member_Generic
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
	 * @return Lib_Model_Member_Generic
	 */
	public function setMemberId($memberId) {
		
		return $this;
	}
	
	/**
	 * Get member identification
	 * @return string|int $memberId
	 */
	public function getMemberId() {
	
	}
	
	/**
	 * Set member type
	 * @param string $memberType
	 * @return Lib_Model_Member_Generic
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
	 * Set membership Information of member
	 * @param Lib_Model_Membership $membership
	 * @return Lib_Model_Member_Generic
	 */
	public function setMembership(Lib_Model_Membership $membership) {
		
		return $this;
	}
	
	/**
	 * Get membership Information of member
	 * @return Lib_Model_Membership $membership
	 */
	public function getMembership() {
	
	}
	
	/**
	 * Set if member is active
	 * @param bool $isActive
	 * @return Lib_Model_Member_Generic
	 */
	public function setIsActive(bool $isActive = 1) {
		
		return $this;
	}
	
	/**
	 * Get if member is active
	 * @return bool $isActive
	 */
	public function getIsActive() {
	
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
	
	}
	
	/**
	 * Set borrowed documents
	 * @param array $borrowed Borrowed documents
	 * @return Lib_Model_Member_Generic
	 */
	public function setBorrowed($borrowed) {
		
		return $this;
	}
	
	/**
	 * Get borrowed documents
	 * @return array $borrowed Borrowed documents
	 */
	public function getBorrowed() {
	
	}
	
	/**
	 * Set Document Loan History
	 * @param mixed $loanHistory Document Loan History
	 * @return Lib_Model_Member_Generic
	 */
	public function setLoanHistory($loanHistory) {
		
		return $this;
	}
	
	/**
	 * Get Document Loan History
	 * @return mixed $loanHistory Document Loan History
	 */
	public function getLoanHistory() {
	
	}

}
?>