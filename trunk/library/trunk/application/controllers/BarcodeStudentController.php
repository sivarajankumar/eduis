<?php

/**
 * BarcodeController
 * 
 * @author HeAvi
 * @version 0.1
 */

class BarcodeStudentController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
	}
	
	/**
	 * The default action - show the home page
	 */
	public function printcodeAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$request = $this->getRequest ();
		$department = $request->getParam ( 'department_id' );
		$degree =  $request->getParam ( 'degree_id' );
		$batch = $request->getParam ( 'batch' );
		if (isset ( $degree ) and isset ( $department ) and isset ( $batch )) {
			$client = new Zend_Http_Client('http://'.CORE_SERVER.'/');
			$client->setCookie ( 'PHPSESSID', $_COOKIE ['PHPSESSID'] );
			$response = $client->request ();
			if ($response->isError ()) {
				$remoteErr = 'REMOTE ERROR: ('.$response->getStatus () . ') ' . $response->getMessage ();
				throw new Zend_Exception ( $remoteErr, Zend_Log::ERR );
			} else {
				$jsonContent = $response->getBody ( $response );
				$memberInfo = $membership;
				$memberInfo['info'] = Zend_Json_Decoder::decode ( $jsonContent );
				return $memberInfo;
			}
			$students = Department_Model_DbTable_StudentDepartment::getBatchStudent ( $department, $degree, $batch );
            $this->view->assign ( 'students', $students );
            $this->view->assign ( 'department', $department );
            $this->view->assign ( 'degree', $degree );
            $this->view->assign ( 'batch', $batch );
			
		}
	}
	public function generatecodeAction() {
		// Only the text to draw is required
		$text = $_GET ['text'];
		$barcodeOptions = array ('text' => $text );
		// No required options
		$rendererOptions = array ();
		
		Zend_Barcode::render ( 'code39', 'image', $barcodeOptions, $rendererOptions );
	}

}
?>