<?php

class Lib_Model_DbTable_Book extends Libz_Base_Model {
	protected $_name = 'book';
	const TABLE_NAME = 'book';
	
	/*
	 * Customized insert
	 * @version 2.0
	 */
	public function insert(array $data) {
		if (isset ( $data ['acc_no'] )) {
			if (strchr ( $data ['acc_no'], '-' )) {
				$range = explode ( '-', $data ['acc_no'] );
				if ((2 == count ( $range )) 
					and (( string ) $range [0] === ( string ) ( int ) $range [0]) 
					and (( string ) $range [1] === ( string ) ( int ) $range [1]) 
					and ($range [0] <= $range [1])) {
					$cols = array ();
					$vals = array ();
					foreach ( $data as $col => $val ) {
						$cols [] = $this->getAdapter ()->quoteIdentifier ( $col, true );
						for($acc = $range [0]; $acc <= $range [1]; $acc ++) {
							if ('acc_no' == $col) {
								$vals [$acc] [] = $this->getAdapter ()->quote ( $acc );
							} else {
								$vals [$acc] [] = $val ? $this->getAdapter ()->quote ( $val ) : 'null';
							}
						}
					}
					//build values statement
					$tmpVals = array ();
					foreach ( $vals as $acc => $values ) {
						$tmpVals [] = ' (' . implode ( ', ', $values ) . ') ';
					}
					// build the statement
					$sql = "INSERT INTO " 
							. $this->getAdapter ()->quoteIdentifier ( self::TABLE_NAME, true ) 
							. ' (' . implode ( ', ', $cols ) . ') ' 
							. 'VALUES ' . implode ( ', ', $tmpVals );
					
					// execute the statement and return the number of affected rows
					$stmt = $this->getAdapter ()->query ( $sql );
					$result = $stmt->rowCount ();
					return $result;
				} else {
						throw new Zend_Db_Table_Exception ( 'The range ' . $range [0] . ' - ' 
															. $range [1] . ' is not acceptable.' );
				}
			} elseif (( string ) $data ['acc_no'] === ( string ) ( int ) $data ['acc_no']) {
				return parent::insert ( $data );
			} else {
					throw new Zend_Db_Table_Exception ( "acc_no is not acceptable." );
			}
		} else {
			if ($this->debug) {
				throw new Zend_Db_Table_Exception ( 'Books cannot be added without acc_no!!' );
			}
		}
	}
	
	/**
	 * Get Book ISBN number
	 * @param int $acc_no
	 */
	public function getBookIsbn($acc_no) {
		$dbSelect = $this->select ()
						->from ( $this->_name, 'isbn_id' )
						->where ( "acc_no = ?", $acc_no );
		$dbstmt = $dbSelect->query ();
		return $dbstmt->fetch ( Zend_db::FETCH_COLUMN );
	}
	
	/**
	 * Get Book Information i.e. Status,DocumentType,Remarks
	 * @param int $acc_no
	 */
	public static function getBookInfo($acc_no) {
		$sql = self::getDefaultAdapter ()
					->select ()
					->from ( 'book', 
							array ('isbn_id', 
									'document_type_id', 
									'status', 
									'remarks' ) )
					->where ( 'acc_no = ?', $acc_no );
		return $sql->query ()->fetch ();
	}
	
	public function setBookStatus($acc_no, $status = 1) {
		$data = array ('status' => $status );
		$where = $this->getAdapter ()->quoteInto ( 'acc_no = ?', $acc_no );
		return $this->update ( $data, $where );
	}
	
	public static function statusColValues() {
		//TODO fetch schema name dynamically.
		
		$sql = 'CALL GetEnumChoiceList("library","' . self::TABLE_NAME . '","status")';
		return self::getDefaultAdapter ()->fetchCol ( $sql );
	}
	
	/**
	 * Books of particular status and ISBN
	 * @situation Say, Number and Accession of AVAILABLE Books of ISBN 9780131660915
	 * @param string $isbn_id
	 * @param string $status
	 */
	public function isbnBooks($isbn_id, $status = NULL) {
	    $sql = $this->select()
	            ->from(self::info('name'), array('acc_no'))
	            ->where('isbn_id = ?',$isbn_id);
	            
        if ($status) {
            $sql->where('status = ?',$status);
        } else {
            $sql->columns('status');
        }
        
        return $sql->query()->fetchAll();
	}
}

?>