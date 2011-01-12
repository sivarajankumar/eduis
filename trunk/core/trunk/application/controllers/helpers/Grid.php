<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage Helper
 * @since	   0.1
 */
class Core_Controller_Helper_Grid extends Zend_Controller_Action_Helper_Abstract {
	
	// Zend_Db_Table_Select object
	public $sql;
	// Row Count
	protected $_count;
	public $total_pages;
	public $offset = 0;
	public $gridparam = array ();
	
	public function __construct() {
		return self::setGridparam ();
	}
	
	function direct() {
		return self::setGridparam ();
	}
	
	public function setGridparam() {
		$request = self::getRequest ();
		$this->gridparam ['page'] = $request->getParam ( 'page' ); // get the requested page
		$this->gridparam ['limit'] = $request->getParam ( 'rows' ); // rows limit in Grid
		$this->gridparam ['sidx'] = $request->getParam ( 'sidx' ); // get index column - i.e. user click to sort
		$this->gridparam ['sord'] = $request->getParam ( 'sord' ); // sort direction
		

		if (! isset ( $this->gridparam ['sidx'] ))
			$this->gridparam ['sidx'] = 1;
		return $this;
	}
	
	public function countRows() {
		$cols = $this->sql->getPart ( 'columns' );
		$this->sql->reset ( 'columns' );
		$this->sql->columns ( array ('count' => 'COUNT(1)' ) );
		$result = $this->sql->query ()->fetch ();
		$this->sql->reset ( 'columns' );
		foreach ( $cols as $key => $col ) {
			$this->sql->columns ( $col [1], $col [0] );
		}
		$this->_count = $result ['count'];
		return $this->_count;
	}
	
	public function pagelimit() {
		if (! isset ( $this->_count )) {
			self::countRows ();
		}
		
		if ($this->_count > 0) {
			$this->total_pages = ceil ( $this->_count / $this->gridparam ['limit'] );
		} else {
			$this->total_pages = 0;
		}
		if ($this->gridparam ['page'] > $this->total_pages) {
			$this->gridparam ['page'] = $this->total_pages;
		}
		if ($this->gridparam ['page']) {
			$this->offset = $this->gridparam ['limit'] * $this->gridparam ['page'] - $this->gridparam ['limit']; //don't put $gridparam['limit']*($gridparam['page']-1)
		} else {
			$this->offset = 0;
		}
	}
	
	public function prepareResponse() {
		
		if (! isset ( $this->total_pages )) {
			self::pagelimit ();
		}
		$response = new stdClass ();
		$response->page = $this->gridparam ['page'];
		$response->total = $this->total_pages;
		$response->records = $this->_count;
		return $response;
	}
	
	public function fetchdata($columns = NULL) {
		if (isset ( $columns )) {
			$this->sql->reset ( 'columns' );
			$this->sql->columns ( $columns );
		}
		
		if (isset ( $this->gridparam ['sidx'] ) and isset ( $this->gridparam ['sord'] )) {
			$orderstr = $this->gridparam ['sidx'] . ' ' . $this->gridparam ['sord'];
			$order = explode ( ',', $orderstr );
			$this->sql->order ( $order );
		}
		if (isset ( $this->offset )) {
			$this->sql->limit ( $this->gridparam ['limit'], $this->offset );
		}
		
		return $this->sql->query ()->fetchAll ();
	}
}
?>