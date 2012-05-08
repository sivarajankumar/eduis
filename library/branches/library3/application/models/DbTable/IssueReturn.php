<?php
class Lib_Model_DbTable_IssueReturn extends Libz_Base_Model {

    const TABLE_NAME = 'issue_return';
    protected $_name = 'issue_return';
    protected $processes = array('issue','return');

    /**
     * Get date on which book is issued.
     * @param int $acc_no
     * @return date Issue Date of book.
     */
    public function getBookIssueDate ($acc_no) {
        $sql = $this->select()
            ->from(self::TABLE_NAME, 'issue_date')
            ->where('acc_no = ?', $acc_no)
            ->where("return_date is NULL");
        return $sql->query()->fetchColumn();
    }

    /**
     * Get current borrower of Book
     * @param int $acc_no
     */
    public function getBookBorrower ($acc_no) {
        $sql = $this->select()
            ->from($this->_name, 'member_id')
            ->where('acc_no = ?', $acc_no)
            ->where("return_date is NULL");
        return $sql->query()->fetchColumn();
    }

    public static function getIssuedBookInfo ($acc_no) {
        $sql = self::getDefaultAdapter()->select()
            ->from(self::TABLE_NAME, array('issue_date', 'member_id'))
            ->where('acc_no = ?', $acc_no)
            ->where("return_date is NULL");
        return $sql->query()->fetch();
    }

    /**
     * Get last borrower of book
     * 
     * If a book is not issued then it will return last borrower else current borrower.
     * @param int $acc_no
     */
    public function getBookLastBorrower ($acc_no) {
        ;
    }

    /**
     * Accept an issued book.
     * @param int $acc_no
     */
    public function returnBook ($acc_no) {
        //, $remark = NULL, $fineType = NULL, $fine = NULL
        $authContent = Zend_Auth::getInstance()->getIdentity();
        $accepted_by = $authContent['identity']; //$staff_detail[0]['first_name'] . ' '. $staff_detail[0]['last_name'] ;
        $where[] = $this->getAdapter()->quoteInto('acc_no = ?', $acc_no);
        $where[] = 'return_date IS NULL';
        $objToday = new Zend_Date();
        //$book = new Lib_Model_DbTable_Book ();
        //$book->setBookStatus ( $acc_no );
        $data = array(
        'return_date' => $objToday->toString('YYYY-MM-dd HH:mm:ss'), 
        'accepted_by' => $accepted_by);
        return $this->update($data, $where);
    }

    /**
     * Issue book to member.
     * @param int $acc_no
     * @param int $member_id
     */
    public function issueBook ($acc_no, $member_id, $remark = NULL) {
        //TODO issue_date must be a timestamp rather then DATE.
        $objToday = new Zend_Date();
        $book = new Lib_Model_DbTable_Book();
        $authContent = Zend_Auth::getInstance()->getIdentity();
        $issued_by = $authContent['identity']; //$staff_detail[0]['first_name'] . ' '. $staff_detail[0]['last_name'] ;
        
        $data = array('acc_no' => $acc_no, 
        			'member_id' => $member_id, 
        			'issue_date' => $objToday->toString('YYYY-MM-dd HH:mm:ss'),
                    'issued_by' => $issued_by);
        if (isset($remark)) {
            $data['remarks'] = $remark;
        }
        try {
            return $this->insert($data);
        } catch (Exception $e) {
            throw new Exception('The book can not be issued because ' . $e->getMessage(), Zend_Log::ERR) ;
        }
    }

    /**
     * List of documents issued to a member
     * 
     * @param string $member_id
     * @param string $documentType
     */
    public static function getIssuedDocumentList ($member_id, 
    $documentType = NULL) {
        $sql = self::getDefaultAdapter()->select()
            ->from('issue_return', array('acc_no', 'issue_date'))
            ->join('book', 'issue_return.acc_no = book.acc_no', 'status')
            ->where('member_id = ?', $member_id)
            ->where('return_date IS NULL');
        if (isset($documentType)) {
            $sql->where('book.document_type_id = ?', $documentType);
            return $sql->query()->fetch();
        } else {
            $sql->columns('document_type_id', 'book');
        }
        return $sql->query()->fetchAll();
    }

    /**
     * Count of documents issued to a member
     * 
     * @param unknown_type $member_id
     * @param unknown_type $documentType
     */
    public static function getIssuedDocumentCount ($member_id, 
    $documentType = NULL) {
        $incDocType = '';
        if (isset($documentType)) {
            $documentType = mysql_escape_string($documentType);
            $incDocType = ' and membership_limit.document_type_id = "' .
             $documentType . '"';
        }
        $sql = 'SELECT
				  document_type_id,
				  COALESCE(counts, 0) AS counts
				FROM (SELECT
				        membership_limit.document_type_id
				      FROM member
				        JOIN membership_limit
				          ON (member.membership_type_id = membership_limit.membership_type_id)
				      WHERE (member.member_id = ? ' .
         $incDocType . ')) AS memberDoc
				  LEFT JOIN (SELECT
				               `book`.`document_type_id` AS doctype,
				               COUNT(issue_return.acc_no) AS `counts`
				             FROM `book`
				               JOIN `issue_return`
				                 ON issue_return.acc_no = book.acc_no
				             WHERE (member_id = ?)
				                 AND (return_date IS NULL)
				             GROUP BY `book`.`document_type_id`) AS memberIssued
				    ON (memberDoc.document_type_id = memberIssued.doctype)';
        $sql = self::getDefaultAdapter()->query($sql, 
        array($member_id, $member_id));
        if (isset($documentType)) {
            return $sql->fetchColumn(2);
        }
        return $sql->fetchAll(Zend_Db::FETCH_UNIQUE);
    }
    
    public function fetchDatewiseCirculation(Zend_Date $date = NULL, $process = NULL,array $orderby = array('tranc_id')) {
        $select  = $this->select()->from($this->info('name'),array('acc_no','member_id'));
            if (empty($date)) {
                $dateobj = new Zend_Date();
            }
            $datestr = $date->toString('YYYY-MM-dd');
            // If process is given 
            if (!empty($process)) {
                $key = array_search(strtolower($process), $this->processes);
                if (isset($key)) {
                    $proName = array($this->processes[$key]);
                } else {
                    throw new Exception("The '$process' is not available.", Zend_Log::NOTICE);
                }
                //include possible processes
            } else {
                $proName = $this->processes;
                $select->columns(array('issue_date','return_date'));
            }
            foreach ($proName as $key => $pro) {
                $select->orwhere($pro.'_date LIKE ?',$datestr.'%');
            }
            $select->order($orderby);
            return $select->query()->fetchAll();
    }
}
?>