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
	 * Print acc. no. of book
	 */
	public function accessnoAction() {
		$this->_helper->viewRenderer->setNoRender ( false );
		/*
		 ** The code was used for basic HTML but now ajax requests are being performed. **
		 * $request = $this->getRequest ();
		$accFrom = trim($request->getParam ( 'accFrom' ));
		$accUpto = trim($request->getParam ( 'accUpto', null ));
		if (isset ( $accFrom ) and ((string)$accFrom === (string)(int)$accFrom)) {
			
			$this->view->assign ( 'accFrom', $accFrom );
			$printAcc = null;
			
			if (((string)$accUpto === (string)(int)$accUpto) and ($accUpto >= $accFrom)) {
				for($acc_no = $accFrom; $acc_no <= $accUpto; $acc_no ++) {
					$printAcc [] = ( int ) $acc_no;
				}
			$this->view->assign ( 'accUpto', $accUpto );
			} else {
				$this->_helper->logger('accUpto is invalid or not set');
				$printAcc = ( int ) $accFrom;
			}
			$this->view->assign ( 'printAcc', $printAcc );
		} else {
			$this->_helper->logger('unacceptable accFrom');
		}*/
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
	
	/**
	 * Generate barcode for books.
	 * 
	 * Generate barcode in CODE39.
	 * @param string text - The text to be printed as barcode.
	 */
	public function generatecodeAction() {
		$request = $this->getRequest ();
		$text = $request->getParam ( 'text' );
		$format = $request->getParam ( 'format', 'CODE39' );
		$barcodeOptions = array ('text' => $text );
		$rendererOptions = array ();
		$this->getResponse()
				    ->setHeader('Cache-Control', 'public, proxy-revalidate')
				    ->setHeader('Set-Cookie', '',true);
		Zend_Barcode::render ( $format, 'image', $barcodeOptions, $rendererOptions );
	}
}
?>