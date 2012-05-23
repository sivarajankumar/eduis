<?php

/**
 * IndexController
 * 
 * @author
 * @version 
 */

class IndexController extends Libz_Base_BaseController {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
        $this->_helper->viewRenderer->setNoRender(false);
        $this->_helper->layout()->enableLayout();
	}

}
?>

