<?php
/**
 * @category   Aceis
 * @package    Default
 * @subpackage Block
 */
/*
 * Blocks/Buildings in infrastructure.
 *
 */
class BlockController extends Corez_Base_BaseController
{
    /*
     * @about Interface.
     */
    public function indexAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
        $this->view->assign('controller', $this->_request->getControllerName());
        $this->view->assign('module', $this->_request->getModuleName());
    }
    /*
     * Back end data provider to datagrid.
     * @return JSON data
     */
    public function fillgridAction ()
    {
        self::createModel();
        $request = $this->getRequest();
        $valid = $request->getParam('nd');
        if ($request->isXmlHttpRequest() and $valid) {
            $this->grid = new $this->_helper->grid();
            $this->grid->sql = $this->model->select()->from(
            $this->model->info('name'));
            /*
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'department_id' :
						case 'degree_id' :
							$this->grid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'batch_start' :
							$this->grid->sql->where ( "$key = ?", $value );
							break;
					}
				}
			}*/
            self::fillgridfinal();
        } else {
            header("HTTP/1.1 403 Forbidden");
            die();
        }
    }
    ////////combos//////////
    public function getblockAction ()
    {
        $format = $this->getRequest()->getParam('format', 'json');
        $result = Core_Model_DbTable_Block::getblocks();
        switch (strtolower($format)) {
            case 'json':
                $this->_helper->json($result);
                return;
            case 'select':
                echo '<select>';
                echo '<option>Select one</option>';
                foreach ($result as $key => $row) {
                    echo '<option value="' . $row['block_id'] . '">' .
                     $row['block_name'] . '</option>';
                }
                echo '</select>';
                return;
        }
        header("HTTP/1.1 400 Bad Request");
        echo 'Either format type not supported or incorrect.';
        die();
    }
}
