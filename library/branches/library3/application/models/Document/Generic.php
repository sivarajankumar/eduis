<?php

abstract class Lib_Model_Document_Generic {
	protected $_status;
	protected $_mold;
	protected $_cost;
	protected $_publisher;
	
	/**
	 * Last borrowed information
	 * 
	 * Information about last borrow date, borrower etc
	 * @var array
	 */
	protected $_lastBorrowed = array ();
	
	protected $_remarks;
	
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
	 * @return Default_Model_Guestbook
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
	 * Set status of document
	 * 
	 * @example AVAILABLE|ISSUED|LOST|TORN
	 */
	public function setStatus($status) {
		return $this;
	}
	
	public function getStatus() {
		;
	}
	
	/**
	 * Set mold/form of document
	 * 
	 * @example BOOK|CD|JOURNAL|MAGZINE
	 * @param string $formFactor
	 */
	public function setMold($formFactor) {
		return $this;
	}
	
	public function getMold() {
		;
	}
	
	/**
	 * 
	 * Set cost/price of document
	 * @param int $cost
	 * @param char $currency
	 */
	public function setCost($cost, $currency = 'INR') {
		return $this;
	}
	
	public function getCost() {
		;
	}
	
	/**
	 * 
	 * Set publisher of document
	 * @param string $publisher
	 */
	public function setPublisher($publisher) {
		return $this;
	}
	
	public function getPublisher() {
		;
	}
	
	
	/**
	 * Set Last borrowed information
	 * @param array $lastBorrowed Last borrowed information
	 * @return Lib_Model_Document_Generic
	 */
	public function setLastBorrowed(array $lastBorrowed) {
		
		return $this;
	}
	
	/**
	 * Get Last borrowed information
	 * @return array $lastBorrowed Last borrowed information
	 */
	public function getLastBorrowed() {
	
	}
	
	/**
	 * Set Remark about ISBN
	 * @param string $remark Remark about ISBN
	 * @return Lib_Model_Isbn
	 */
	public function setRemark($remark) {
		
		return $this;
	}
	
	/**
	 * Get Remark about ISBN
	 * @return string $remark Remark about ISBN
	 */
	public function getRemark() {
	
	}

}
?>