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
        $final_data = array();
        $final_data = array(
        3 => array('roll_number' => 2308011, 'registration_id' => '08-ECA-75', 
        'first_name' => 'SUMIT', 'last_name' => 'DHIMAN', 
        'middle_name' => 'null', 'dob' => '1990-05-19', 'gender' => 'MALE', 
        'father_name' => 'mam chand', 'postal_code' => 134003, 
        'city' => 'Ambala City', 'district' => 'Ambala', 'state' => 'Punjab', 
        'address' => '192, AMBALA , CANAL COLONY', 'home_landline' => 0184567654, 
        'home_mobile' => 9812996312, 'email' => 'sumit.dhiman91@gmail.com', 
        'SEMESTER 1' => '88.8 % ', 'SEMESTER 2' => '87.5 % ', 
        'SEMESTER 3' => '72.3 % ', 'SEMESTER 4' => 'null', 
        'SEMESTER 5' => '67.9 % ', 'SEMESTER 6' => 'null', 
        'SEMESTER 7' => '84.2 % ', 'SEMESTER 8' => '81.1 % ', 
        'TENTH BOARD' => 'CBSE', 'TENTH MARKS' => 90, 'TENTH YEAR' => 2008, 
        'TWELFTH BOARD' => 'ICSE', 'TWELFTH MARKS' => 490, 
        'TWELFTH YEAR' => 2008, 'AIEEE RANK' => 30, 'LEET RANK' => 30768));
        $fnal_data = $final_data;
        $headings = array_pop($fnal_data);
        $headers = array_keys($headings);
        $this->exportToExcelOwn($headers, $final_data);
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

