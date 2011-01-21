<?php

class Lib_Model_Isbn {
	/**
	 * ISBN for a book
	 * @var string|int
	 */
	protected $_isbn;
	
	/**
	 * Title for a ISBN
	 * @var string
	 */
	protected $_title;
	
	/**
	 * Edition of ISBN
	 * @var int
	 */
	protected $_edition;
	
	/**
	 * Volume for a ISBN
	 * @var int
	 */
	protected $_volume;
	
	/**
	 * Year of publish
	 * @var year
	 */
	protected $_year;
	
	/**
	 * Author of book
	 * @var string|array
	 */
	protected $_author;
	
	/**
	 * Place and Publisher of ISBN
	 * @var string|array
	 */
	protected $_placePublisher;
	
	/**
	 * DDC of book
	 * @var string|int
	 */
	protected $_ddc;
	
	/**
	 * LCC of book
	 * @var string|int
	 */
	protected $_lcc;
	
	/**
	 * Language of book
	 * @var string
	 */
	protected $_language;
	
	/**
	 * Physical description of book
	 * @var string|array
	 */
	protected $_physicalDesc;
	
	/**
	 * Remark about ISBN
	 * @var string
	 */
	protected $_remark;
	
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
	 * Set ISBN of a book
	 * @param string|int $isbn
	 * @return Lib_Model_Isbn
	 */
	public function setIsbn($isbn) {
		
		return $this;
	}
	
	/**
	 * Get ISBN of a book
	 * @return string|int $isbn
	 */
	public function getIsbn() {
	
	}
	
	/**
	 * Set title of a book
	 * @param string $title
	 * @return Lib_Model_Isbn
	 */
	public function setTitle($title) {
		
		return $this;
	}
	
	/**
	 * Get title of a book
	 * @return string $title
	 */
	public function getTitle() {
	
	}
	
	/**
	 * Set edition number of book
	 * @param int $edition
	 * @return Lib_Model_Isbn
	 */
	public function setEdition($edition) {
		
		return $this;
	}
	
	/**
	 * Get edition number of book
	 * @return int $edition
	 */
	public function getEdition() {
	
	}
	
	/**
	 * Set volume number of book
	 * @param int $volume
	 * @return Lib_Model_Isbn
	 */
	public function setVolume($volume) {
		
		return $this;
	}
	
	/**
	 * Get volume number of book
	 * @return int $volume
	 */
	public function getVolume() {
	
	}
	
	/**
	 * Set year of publish of book
	 * @param year $year
	 * @return Lib_Model_Isbn
	 */
	public function setYear($year) {
		
		return $this;
	}
	
	/**
	 * Get year of publish of book
	 * @return year $year
	 */
	public function getYear() {
	
	}
	
	/**
	 * Set author(s) of the book
	 * @param string $author
	 * @return Lib_Model_Isbn
	 */
	public function setAuthor($author) {
		
		return $this;
	}
	
	/**
	 * Get author(s) of the book
	 * @return string $author
	 */
	public function getAuthor() {
	
	}
	
	/**
	 * Set place and publisher of Book
	 * @param string $placePublisher
	 * @return Lib_Model_Isbn
	 */
	public function setPlacePublisher($placePublisher) {
		
		return $this;
	}
	
	/**
	 * Get place and publisher of Book
	 * @return string $placePublisher
	 */
	public function getPlacePublisher() {
	
	}
	
	/**
	 * Set language of book
	 * @param string $language
	 * @return Lib_Model_Isbn
	 */
	public function setLanguage($language) {
		
		return $this;
	}
	
	/**
	 * Get language of book
	 * @return string $language
	 */
	public function getLanguage() {
	
	}
	
	/**
	 * Set physical description of book
	 * @param string|array $physicalDesc
	 * @return Lib_Model_Isbn
	 */
	public function setPhysicalDesc($physicalDesc) {
		
		return $this;
	}
	
	/**
	 * Get physical description of book
	 * @return string|array $physicalDesc
	 */
	public function getPhysicalDesc() {
	
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