<?php
/**
 * 
 * @author Administrator
 *
 */
/*
 * Search Books from library
 */
class SearchController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
		$request = $this->getRequest ();
		$q = $request->getParam ( 'q' );
		$start = ($request->getParam ( 'start' )) ? $request->getParam ( 'start' ) : 0;
		
		$this->view->assign ( 'q', $q );
		$paging = NULL;
		if (! empty ( $q )) {
			$filter = $request->getParam ( 'filter' ) ? $request->getParam ( 'filter' ) : 'all_book';
			$this->view->assign ( $filter, "checked" );
			$model = self::createModel();
			$this->view->assign ( "search_result", $model::search ( $q, $start, $filter ) );
			$row_num = $model::resultCount ( $q, $filter );
			
			$page_no = ($start / 10) + 1;
			$this->view->assign ( "cur_page", $page_no );
			if ($page_no > 10) {
				$page_no = $page_no - 10;
			} else {
				$page_no = 0;
			}
			
			$tmp_start = $page_no * 10;
			$cnt = 1;
			for($cur_row = $page_no * 10; ($cnt < 20 && $cur_row < $row_num); $cur_row += 10) {
				$page_no ++;
				$paging [] = "<a name= $page_no href=" . $_SERVER ['REDIRECT_URL'] . '?q=' . $q . '&start=' . ($tmp_start) . '&filter=' . $filter . ">" . $page_no . "</a>";
				$tmp_start = $tmp_start + 10;
				$cnt ++;
			}
			
			if ($row_num > 0) {
				$this->view->assign ( 'paging', $paging );
			} else {
				echo "Your search <b><em> $q  </em></b> for $filter book did not match..";
			}
		} else {
			$this->view->assign ( "all_book", 'checked' );
		}
	
	}
	public function gridAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$this->_helper->layout ()->enableLayout ();
		$this->view->assign ( 'controller', $this->_request->getControllerName () );
		$this->view->assign ( 'module', $this->_request->getModuleName () );
	}
	public function fillgridAction() {
		$this->model = new Lib_Model_DbTable_Isbn ();
        $this->dbCols [] = 'isbn.isbn_id';
        $this->dbCols [] = 'acc_no';
        $this->dbCols [] = 'title';
        $this->dbCols [] = 'author';
        //$this->dbCols [] = 'subject_code';
        $this->dbCols [] = 'edition';
        $this->dbCols [] = 'status_id';
        $this->dbCols [] = 'rack_id';
        $this->dbCols [] = 'shelf';
		$request = $this->getRequest ();
		$valid = $request->getParam ( 'nd' );
		if ($valid) {
			
			$this->grid = $this->_helper->grid();
			
			$this->grid->sql = $this->model->getDefaultAdapter ()->select ()->from ( $this->model->info ( 'name' ), array ('isbn_id', 'title', 'author', 'edition' ) )->join ( 'book', 'book.isbn_id = isbn.isbn_id', array ('acc_no', 'status', 'rack_id', 'shelf' ) );
			
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'isbn_id' :
						case 'acc_no' :
						case 'edition' :
							$this->grid->sql->where ( "$key = ?", $value );
							break;
						case 'status' :
							$this->grid->sql->where ( "$key = ?", $value . '%' );
							break;
						
						case 'title' :
						case 'long_title' :
						case 'author' :
							$this->grid->sql->where ( "$key LIKE ?", '%' . $value . '%' );
							break;
					}
				}
			}
			
			self::fillgridfinal ();
		
		} else {
			echo ('<b>Oops!! </b><br/>No use of peeping like that.. :)');
		}
	
	}
	
	public function fillgridfinal() {
		$response = $this->grid->prepareResponse ();
		
		$result = $this->grid->fetchdata ();
		foreach ( $result as $key => $row ) {
			$gridTuplekey = $row ['acc_no'];
			//unset ( $row ['timetable_id'] );
			$response->rows [$key] ['id'] = $gridTuplekey;
			$response->rows [$key] ['cell'] = array_values ( $row );
		}
		echo Zend_Json::encode ( $response );
	}
}

?>

