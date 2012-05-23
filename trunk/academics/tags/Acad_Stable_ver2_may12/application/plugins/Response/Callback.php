<?php
class Acad_Plugin_Response_Callback extends Zend_Controller_Plugin_Abstract{
	
    /**
     * postDispatch() - Support jsonp
     *
     * @param  Zend_Controller_Request_Abstract $request
     */
    public function postDispatch(Zend_Controller_Request_Abstract $request) {
    	$callbackFn = $request->getParam('callback');
    	if ($callbackFn) {
    		$response = $this->getResponse();
    		$content = $response->getBody();
    		$response->setBody($callbackFn . '(' . $content .')');
    	}
    }
}