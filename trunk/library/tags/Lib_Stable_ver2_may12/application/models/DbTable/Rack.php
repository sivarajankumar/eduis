<?php
class Lib_Model_DbTable_Rack extends Libz_Base_Model {
	
	protected $_name = 'rack';
	protected $logger;
	public function init() {
		$this->dbselect = $this->select ();
		$this->logger = Zend_Registry::get ( 'logger' );
	}
}