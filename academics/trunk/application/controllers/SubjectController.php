<?php
class SubjectController extends Acadz_Base_BaseController
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
            $this->grid->setGridparam($request);
            $this->grid->sql = $this->model->select()->from(
            $this->model->info('name'));
            $searchOn = $request->getParam('_search');
            if ($searchOn != 'false') {
                $sarr = $request->getParams();
                foreach ($sarr as $key => $value) {
                    switch ($key) {
                        case 'subject_code':
                        case 'abbr':
                        case 'subject_name':
                        case 'subject_code':
                            $this->grid->sql->where("$key LIKE ?", $value . '%');
                            break;
                        case 'subject_type_id':
                        case 'is_optional':
                        case 'lecture_per_week':
                        case 'tutorial_per_week':
                        case 'practical_per_week':
                        case 'suggested_duration':
                            $this->grid->sql->where("$key = ?", $value);
                            break;
                    }
                }
            }
            self::fillgridfinal();
        } else {
            header("HTTP/1.1 403 Forbidden");
        }
    }
    /*
	 * Show basic information of a subject.
	 * @return array 
	 */
    public function getsubjecinfoAction ()
    {
        $request = $this->getRequest();
        $format = $request->getParam('format', 'json');
        $subject_code = $request->getParam('subject_code');
        if (isset($subject_code)) {
            $result = Acad_Model_DbTable_Subject::getSubjectInfo($subject_code);
            switch (strtolower($format)) {
                case 'json':
                    $this->_helper->json($result);
                    return;
                case 'select':
                    echo '<select>';
                    echo '<option>Select one</option>';
                    foreach ($result as $key => $row) {
                        echo '<option value="' . $row['batch_start'] . '">' .
                         $row['batch_start'] . '</option>';
                    }
                    echo '</select>';
                    return;
                default:
                    header("HTTP/1.1 400 Bad Request");
                    echo 'Unsupported format';
            }
        } else {
            header("HTTP/1.1 400 Bad Request");
        }
    }
}