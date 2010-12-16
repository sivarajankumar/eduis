<?php
class Lib_Model_DbTable_Search extends Libz_Base_Model {
	
	public static function search($q, $start, $filter) {
		$sql = "SELECT
  isbn.title,
  isbn.author,
  isbn.place_publisher,
  IFNULL(isbn.year,'-') AS pub_year,
  IFNULL(isbn.edition,'-') AS edition,
  book.status,
  book.isbn_id,
  book.acc_no
	FROM isbn
  INNER JOIN book
    ON isbn.isbn_id = book.isbn_id
WHERE (isbn.title LIKE '%$q%'
     OR isbn.author LIKE '%$q%'	
     OR isbn.place_publisher LIKE '%$q%'	
     OR book.acc_no = '$q'
     OR isbn.isbn_id = '$q')";
		if ($filter == 'avail_book') {
			$sql .= " AND book.status = 'AVAILABLE'";
		}
		if ($filter == 'issued_book') {
			$sql .= " AND book.status = 'ISSUED '";
		}
		$sql .= "LIMIT $start,10";
		$result = self::getDefaultAdapter ()->query ( $sql )->fetchAll ();
		return $result;
	}
	public static function resultCount($q, $filter) {
		$sql = "SELECT
  isbn.title,
  isbn.author,
  isbn.place_publisher,
  IFNULL(isbn.year,'-') AS pub_year,
  IFNULL(isbn.edition,'-') AS edition,
  book.status,
  book.isbn_id,
  book.acc_no
	FROM isbn
  INNER JOIN book
    ON isbn.isbn_id = book.isbn_id
WHERE (isbn.title LIKE '%$q%'
     OR isbn.author LIKE '%$q%'	
     OR isbn.place_publisher LIKE '%$q%'	
     OR book.acc_no = '$q'
     OR isbn.isbn_id = '$q')";
		if ($filter == 'avail_book') {
			$sql .= " AND book.status = 'AVAILABLE'";
		}
		if ($filter == 'issued_book') {
			$sql .= " AND book.status = 'ISSUED '";
		}
		return self::getDefaultAdapter ()->query ( $sql )->rowCount ();
	}
}
?>
