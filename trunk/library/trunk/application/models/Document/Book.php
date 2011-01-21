<?php

class Lib_Model_Document_Book extends Lib_Model_Document_Generic {
	
	/**
	 * Accessian number of Book
	 * @var int
	 */
	protected $_accNo;
	
	/**
	 * Bind type of book
	 * @example HARD|PAPER|PLASTIC|METAL
	 * @var string
	 */
	protected $_bindType;
	
	/**
	 * Information related to ISBN of document
	 * @var Lib_Model_Isbn
	 */
	protected $_isbnInfo;
	
	/**
	 * Type of Book
	 * @example REG(Regular)|REF(Reference)|SPE(SPECIAL)
	 * @var string
	 */
	protected $_bookType;
	
	/**
	 * Location where the book can be found.
	 * @example array("RACK" => 1, "SHELF" => 2)
	 * @var array
	 */
	protected $_location;
	
	/**
	 * Invoice ID in which book was purchased.
	 * @var string|int
	 */
	protected $_invoice;
	
	/**
	 * Set accession number of Book
	 * @param int $AccNo
	 * @return Lib_Model_Document_Book
	 */
	public function setAccNo($AccNo) {
		;
        return $this;
	}
	
	public function getAccNo() {
		;
	}
	
	/**
	 * 
	 * Set bind type of book
	 * @example HARD|PAPER|PLASTIC|METAL
	 * @param string $bindType
	 * @return Lib_Model_Document_Book
	 */
	public function setBindType($bindType) {
		;
        return $this;
	}
	
	public function getBindType() {
		;
	}
	
	/**
	 * 
	 * Set information related to ISBN of document
	 * @param Lib_Model_Isbn $isbnInfo
	 * @return Lib_Model_Document_Book
	 */
	public function setIsbnInfo(Lib_Model_Isbn $isbnInfo) {
		;
        return $this;
	}
	
	public function getIsbnInfo() {
		;
	}
	
	/**
	 * 
	 * Set type of Book
	 * @example REG(Regular)|REF(Reference)|SPE(SPECIAL)
	 * @param string $bookType
	 * @return Lib_Model_Document_Book
	 */
	public function setBookType($bookType) {
		;
        return $this;
	}
	
	public function getBookType() {
		;
	}
	
	/**
	 * Set location where the book can be found.
	 * @example array("RACK" => 1, "SHELF" => 2)
	 * @param array $location
	 * @return Lib_Model_Document_Book
	 */
	public function setLocation(array $location) {
		;
        return $this;
	}
	
	public function getLocation() {
		;
	}
	
	/**
	 * 
	 * Set invoice ID in which book was purchased.
	 * @param string|int $invoiceId
	 * @return Lib_Model_Document_Book
	 */
	public function setInvoice($invoiceId) {
		;
        return $this;
	}
	
	public function getInvoice() {
		;
	}
}
?>