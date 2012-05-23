<?php
class Lib_Model_Membership {
	/**
	 * Membership type
	 * @var string
	 */
	protected $_membershipType;
	
	/**
	 * Document limit
	 * @var array
	 */
	protected $_doumentLimit;
	
	/**
	 * Loan day
	 * @var array
	 */
	protected $_loanDay = null;
	
	/**
	 * Set membership type
	 * @param string $membershipType Membership type
	 * @return Lib_Model_Membership
	 */
	public function setMembershipType($membershipType) {
		
		return $this;
	}
	
	/**
	 * Get membership type
	 * @return string $membershipType Membership type
	 */
	public function getMembershipType() {
	
	}
	
	/**
	 * Set document limit
	 * @param array $doumentLimit document limit
	 * @return Lib_Model_Membership
	 */
	public function setDocumentLimit($doumentLimit) {
		
		return $this;
	}
	
	/**
	 * Get document limit
	 * @return array $doumentLimit document limit
	 */
	public function getDocumentLimit() {
	
	}
	
	/**
	 * Set loan day
	 * @param array $loanDay loan day
	 * @return Lib_Model_Membership
	 */
	public function setLoanDay(array $loanDay = null) {
		
		return $this;
	}
	
	/**
	 * Get loan day
	 * @return array $loanDay loan day
	 */
	public function getLoanDay() {
	
	}

}
?>