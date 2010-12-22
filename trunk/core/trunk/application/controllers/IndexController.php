<?php

/**
 * IndexController
 * 
 * @author
 * @version 
 */

class IndexController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		echo '<pre>';
		print_r ($_REQUEST);
	}
	

}
?>

