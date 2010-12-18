<?php

/**
 * IndexController
 * 
 * @author
 * @version 
 */

class IndexController extends Acadz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		echo '<pre>';
		print_r ($_REQUEST);
	}

}
?>

