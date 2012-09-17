<?php
class AdminController extends Zend_Controller_Action
{
    public function init ()
    {
        /* Initialize action controller here */
    }
    public function indexAction ()
    {
        // action body
    }
    public function viewstudentprofileAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function filterstudentAction ()
    {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
    }
    public function exportexcelAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $core_data = $params['myarray']['core_data'];
        $academic_data = $params['myarray']['academic_data'];
        $final_data = array();
        foreach ($core_data as $member_id_core => $info) {
            if (! empty($academic_data[$member_id_core])) {
                $member_data = array_merge($core_data[$member_id_core], 
                $academic_data[$member_id_core]);
                $final_data[$member_id_core] = $member_data;
            }
        }
        $exportable_data = $final_data;
        $headings = array_pop($final_data);
        $column_headers = array_keys($headings);
        $this->exportToExcelOwn($column_headers, $exportable_data);
    }
    private function exportToExcelOwn ($headers, $exportable_data)
    {
        set_time_limit(0);
        $filename = DATA_EXCEL . "/Student_Data-" . date("m-d-Y") . ".xls";
        $realPath = realpath($filename);
        if (false === $realPath) {
            touch($filename);
            chmod($filename, 0777);
        }
        $filename = realpath($filename);
        $handle = fopen($filename, "w");
        foreach ($headers as $header_key => $header_value) {
            $headers[utf8_decode($header_key)] = strtoupper(
            utf8_decode($header_value));
        }
        $xport_headers[] = $headers;
        foreach ($xport_headers as $header) {
            fputcsv($handle, $header, "\t");
        }
        foreach ($exportable_data as $ekey => $erow) {
            foreach ($erow as $ecol => $evalue) {
                $exportable_data[$ekey][utf8_decode($ecol)] = utf8_decode(
                $evalue);
            }
        }
        foreach ($exportable_data as $member_data) {
            fputcsv($handle, $member_data, "\t");
        }
        fclose($handle);
        $this->getResponse()
            ->setRawHeader(
        "Content-Type: application/vnd.ms-excel; charset=UTF-8")
            ->setRawHeader(
        "Content-Disposition: attachment; filename=Student_Data.xls")
            ->setRawHeader("Content-Transfer-Encoding: binary")
            ->setRawHeader("Expires: 0")
            ->setRawHeader(
        "Cache-Control: must-revalidate, post-check=0, pre-check=0")
            ->setRawHeader("Pragma: public")
            ->setRawHeader("Content-Length: " . filesize($filename))
            ->sendResponse();
        readfile($filename);
    }
}

