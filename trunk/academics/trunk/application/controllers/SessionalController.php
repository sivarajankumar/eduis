<?php

class SessionalController extends Acadz_Base_BaseController
{

    public function indexAction()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        // action body
    }
    
    
    /**
     * Back end data provider to datagrid.
     * @return json
     */
    public function fillgridAction ()
    {
        $request = $this->getRequest();
        $valid = $request->getParam('nd');
        if ($request->isXmlHttpRequest() and $valid) {
            self::createModel();
            $this->grid = $this->_helper->grid();
            $this->grid->sql = $this->model->select()->from(
            $this->model->info('name'));
            $searchOn = $request->getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $request->getParams();
                foreach ($sarr as $key => $value) {
                    switch ($key) {
                        case 'department_id':
                        case 'degree_id':
                            $this->grid->sql->where("$key LIKE ?", $value . '%');
                            break;
                        case 'batch_start':
                            $this->grid->sql->where("$key = ?", $value);
                            break;
                    }
                }
            }
            self::fillgridfinal();
        } else {
            $this->getResponse()
                ->setException('Non ajax request')
                ->setHttpResponseCode(400);
        }
    }

    public function manageAction()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        // action body
    }


}

