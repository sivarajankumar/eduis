<?php
/**
 *
 * @category   EduIS
 * @package    Core
 * @subpackage Session
 * @since	   0.2
 */
/**
 * Academic Session Information.
 * 
 */
class SessionController extends Corez_Base_BaseController
{
    /**
     * @about Interface.
     */
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
    }
    /**
     * Back end data provider to datagrid.
     * @return json
     */
    public function fillgridAction ()
    {
        //TODO make it according to SessionController
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
    /**
     * Show information about current semester session
     */
    public function getsessioninfoAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $result = Core_Model_DbTable_AcademicSession::currentSessionInfo();
        switch (strtolower($format)) {
            case 'json':
                $this->_helper->json($result);
                return;
            case 'select' :/*
					echo '<select>';
					echo '<option>Select one</option>';
					foreach ( $result as $key => $row ) {
						echo '<option value="' . $row ['batch_start'] . '">' . $row ['batch_start'] . '</option>';
					}
					echo '</select>';*/
					return;
            default:
                $this->getResponse()
                    ->setException('Unsupported format request')
                    ->setHttpResponseCode(400);
        }
    }
}
