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
    public function indexAction () {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
        $request = $this->getRequest();
        $q = $request->getParam('q');
        $offset = $request->getParam('start',0);
        $limit = 20;
        $this->view->assign('q', $q);
        $paging = NULL;
        if (! empty($q)) {
            $filter = $request->getParam('filter');
            $this->view->assign('checked', $filter);
            $searchObj = new Lib_Model_DbTable_Search();
            $result = $searchObj->search($q, $filter,$offset,$limit,'REG');
            $this->_helper->logger($result);
            $this->view->assign("search_result", $result);
            $row_num = $searchObj->resultCount();
            $page_no = ($offset / $limit) + 1;
            $this->view->assign("cur_page", $page_no);
            if ($page_no > $limit) {
                $page_no = $page_no - $limit;
            } else {
                $page_no = 0;
            }
            $tmp_start = $page_no * $limit;
            $cnt = 1;
            for ($cur_row = $page_no * $limit; ($cnt < 20 && $cur_row < $row_num); $cur_row += $limit) {
                $page_no ++;
                $paging[] = '<a name="'.$page_no.'" href="'. $_SERVER['REDIRECT_URL'] .
                 '?q=' . $q . '&start=' . ($tmp_start) . '&filter=' . $filter .
                 '">' . $page_no . '</a>';
                $tmp_start = $tmp_start + $limit;
                $cnt ++;
            }
            if ($row_num > 0) {
                $this->view->assign('paging', $paging);
            } else {
                echo "Your search <b><em> $q  </em></b> for $filter book did not match..";
            }
        } else {
            $this->view->assign("all_book", 'checked');
        }
    }

    public function gridAction () {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
    }

    public function fillgridAction () {
        $this->model = new Lib_Model_DbTable_Isbn();
        $request = $this->getRequest();
        $valid = $request->getParam('nd');
        if ($valid) {
            $this->grid = $this->_helper->grid();
            $this->grid->sql = $this->model->getDefaultAdapter()
                ->select()
                ->from($this->model->info('name'), 
            array('isbn_id','book.acc_no', 'title', 'author', 'edition','place_publisher'))
                ->join('book', 'book.isbn_id = isbn.isbn_id', 
            array( 'status','document_type_id','isbn.year','isbn.cost', 'rack_id', 'shelf'));
            $searchOn = $request->getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $request->getParams();
                foreach ($sarr as $key => $value) {
                    switch ($key) {
                        case 'isbn_id':
                            $this->grid->sql->where("book.isbn_id = ?", $value);
                            break;
                        case 'acc_no':
                        case 'edition':
                        case 'status':
                        case 'document_type_id':
                        case 'year':
                        case 'cost':
                            $this->grid->sql->where("$key = ?", $value);
                            break;
                        case 'title':
                        case 'long_title':
                        case 'author':
                            $this->grid->sql->where("$key LIKE ?", 
                            '%' . $value . '%');
                            break;
                    }
                }
            }
            self::fillgridfinal();
        } else {
            echo ('<b>Oops!! </b><br/>No use of peeping like that.. :)');
        }
    }

    public function fillgridfinal () {
        $response = $this->grid->prepareResponse();
        $result = $this->grid->fetchdata();
        foreach ($result as $key => $row) {
            $gridTuplekey = $row['acc_no'];
            //unset ( $row ['timetable_id'] );
            $response->rows[$key]['id'] = $gridTuplekey;
            $response->rows[$key]['cell'] = array_values($row);
        }
        //$this->_helper->logger($this->_helper->json($response, false));
        $this->_helper->json($response);
        //echo $this->_helper->json($response, false);
    }
    
    public function getisbnbooksAction() {
        $request = $this->getRequest();
        $isbn_id = $request->getParam('isbn_id');
        $status =  $request->getParam('status');
        $format =  $request->getParam('format','str');
        if ($isbn_id) {
            $table = new Lib_Model_DbTable_Book();
            $result = $table->isbnBooks($isbn_id,$status);
            switch ($format) {
                case 'str':
                    //@TODO Consider status if required.
                    $this->_helper->logger('Format "Str" ignores status');
                    $accNo = array();
                    foreach ($result as $key => $book) {
                        $accNo[] = $book['acc_no'];
                    }
                    echo implode(', ', $accNo);
                return;
                case 'json':
                    echo $this->_helper->json($result,false);
                default:
                    ;
                break;
            }
        }
    }
}
?>

