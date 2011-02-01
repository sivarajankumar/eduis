<?php
class SubjectTypeController extends Acadz_Base_BaseController
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
            $this->grid = $this->_helper->grid();
            $this->grid->sql = $this->model->select()->from(
            $this->model->info('name'));
            /*
			$searchOn = $request->getParam ( '_search' );
			if ($searchOn != 'false') {
				$sarr = $request->getParams ();
				foreach ( $sarr as $key => $value ) {
					switch ($key) {
						case 'subject_mode_name' :
							$this->grid->sql->where ( "$key LIKE ?", $value . '%' );
							break;
						case 'subject_mode_id' :
						case 'subject_type_id' :
							$this->grid->sql->where ( "$key = ?", $value );
							break;
					}
				}
			}*/
            self::fillgridfinal();
        } else {
            header("HTTP/1.1 403 Forbidden");
        }
    }
    ////////combos//////////
    public function getsubjecttypeAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $result = Acad_Model_DbTable_SubjectType::getSubjectTypes();
        switch (strtolower($format)) {
            case 'json':
                $this->_helper->json($result);
                return;
            case 'select':
                echo '<select>';
                echo '<option>Select one</option>';
                foreach ($result as $key => $subject) {
                    echo '<option value="' . $subject['subject_type_id'] . '">' .
                     $subject['subject_type_id'] . '</option>';
                }
                echo '</select>';
                return;
            default:
                header("HTTP/1.1 400 Bad Request");
                echo 'Unsupported format';
        }
    }
}