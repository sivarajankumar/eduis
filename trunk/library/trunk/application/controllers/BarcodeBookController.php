<?php

/**
 * BarcodeController
 * 
 * @author HeAvi
 * @version 0.1
 */

class BarcodeBookController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
	}
	
	/**
	 * The default action - show the home page
	 */
	public function printaccAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$request = $this->getRequest ();
		$accFrom = $request->getParam ( 'accfrom' );
		$accUpto = $request->getParam ( 'accupto' );
		if (isset ( $accFrom ) and ((string)$accFrom === (string)(int)$accFrom)) {
			
			$this->view->assign ( 'accFrom', $accFrom );
			$printAcc = null;
			
			if (((string)$accUpto === (string)(int)$accUpto) and ($accUpto >= $accFrom)) {
				for($acc_no = $accFrom; $acc_no <= $accUpto; $acc_no ++) {
					$printAcc [] = ( int ) $acc_no;
				}
			$this->view->assign ( 'accUpto', $accUpto );
			} else {
				$printAcc = ( int ) $accFrom;
			}
			$this->view->assign ( 'printAcc', $printAcc );
		}
	}
	

	/**
	 * The default action - show the home page
	 */
	public function isbnAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		$request = $this->getRequest ();
		$isbn = $request->getParam ( 'isbn' );
		$accUpto = $request->getParam ( 'accupto' );
		if ($isbn) {
			$newISBN = str_replace('-','',$isbn);
			$this->view->assign ( 'isbn', $newISBN );
		}
	}
	public function generatecodeAction() {
		// Only the text to draw is required
		$request = $this->getRequest ();
		$text = $request->getParam ( 'text' );
		$format = $request->getParam ( 'format', 'EAN8' );
		$barcodeOptions = array ('text' => $text );
		// No required options
		$rendererOptions = array ();
		
		Zend_Barcode::render ( $format, 'image', $barcodeOptions, $rendererOptions );
	}
}
?>