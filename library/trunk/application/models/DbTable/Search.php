<?php
class Lib_Model_DbTable_Search extends Libz_Base_Model {
	protected $_resultCount = NULL;
	protected $_result = NULL;
	protected  $_processedResult = NULL;
	 
	protected function _search($q, $filter = NULL, $offset = 0,$limit = 10, $docType = NULL) {
	    $select = $this->getAdapter()->select()
	                    ->from('book',array('isbn_id','status',
	                    					'COUNT(`acc_no`) AS counts'))
	                    ->join('isbn',
	                    		'isbn.isbn_id = book.isbn_id',
	                            array('title','author',
                						'edition'=> 'IFNULL(isbn.edition,"-")',
                						'pub_year'=>'IFNULL(isbn.year,"-")',
                						'place_publisher'));
                        
        $qArray = array();
        $qArray[] = $this->getAdapter ()->quoteInto ( "isbn.title LIKE ?", '%'.$q.'%' );
        $qArray[] = $this->getAdapter ()->quoteInto ( "isbn.author LIKE ?", '%'.$q.'%' );
        $qArray[] = $this->getAdapter ()->quoteInto ( "isbn.place_publisher LIKE ?", '%'.$q.'%' );
        $qArray[] = $this->getAdapter ()->quoteInto ( "book.acc_no = ?", $q );
        $qArray[] = $this->getAdapter ()->quoteInto ( "isbn.isbn_id = ?", $q );
        $select->where(implode(' OR ', $qArray));
		if ($filter) {
			$select->where('book.status = ?',$filter);
		}
		$select->group(array('isbn_id','status'));
		$this->_resultCount = $select->query(Zend_Db::FETCH_GROUP)->rowCount();
		$select->limit($limit,$offset);
		$select->order(array('title','author','status'));
		if ($docType) {
		    $select->where('document_type_id = ?', $docType);
		}
		$this->_result = $select->query ()->fetchAll (Zend_Db::FETCH_GROUP);
		return $this;
	}
	public function search($q, $filter = NULL, $offset = 0,$limit = 10, $docType= NULL) {
	    self::_search($q, $filter, $offset,$limit,$docType);
	    $processedresult = array();
	    foreach ($this->_result as $isbn_id =>$isbn) {
	        foreach ($isbn as $key => $book) {
    	        $status = $book['status'];
    	        $counts = $book['counts'];
    	        $processedresult[$isbn_id]['status'][$status] = $counts;
    	        $processedresult[$isbn_id]['info'] = array_diff_key($book, array('status'=>'',
        																		'counts'=>''));
	        }
	    }
	    $this->_processedResult = $processedresult;
	    return $this->_processedResult;
	}
	public function resultCount() {
	    if (!isset($this->_result)) {
	        throw new Zend_Exception('Result is not set yet!!',Zend_Log::INFO);
	    }
	    return $this->_resultCount;
	}
}
?>
