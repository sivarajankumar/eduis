<?php
/**
 * 
 * @author Administrator
 *
 */
/*
 * Search Books from library
 */
class OpacController extends Libz_Base_BaseController {

    /**
     * The default action - show the home page
     */
    public function indexAction () {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
    }

    public function fillgridAction () {
        $request = $this->getRequest();
        $valid = $request->getParam('nd');
        if ($valid) {
            $this->grid = $this->_helper->grid();
            $this->grid->sql = Zend_Db_Table::getDefaultAdapter()
                ->select()
                ->from('opac_issue_return',array('acc_no','member_id',
                                                'title','author','edition',
                                                'issue_date','return_date',
                                                'isbn_id','status',
                                                'issued_by','accepted_by'));
            $searchOn = $request->getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $request->getParams();
                foreach ($sarr as $key => $value) {
                    switch ($key) {
                        case 'isbn_id':
                        case 'acc_no':
                        case 'edition':
                        case 'status':
                        case 'member_id':
                        case 'issued_by':
                        case 'accepted_by':
                            $this->grid->sql->where("$key = ?", $value);
                            break;
                        case 'title':
                        case 'author':
                        case 'issue_date':
                        case 'return_date':
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
            $response->rows[$key]['id'] = $gridTuplekey;
            $response->rows[$key]['cell'] = array_values($row);
        }
        //$this->_helper->logger($this->_helper->json($response, false));
        $this->_helper->json($response);
        //echo $this->_helper->json($response, false);
    }
    
    
}
?>

