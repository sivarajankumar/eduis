<?php
class TestingController extends Zend_Controller_Action
{
    public function init ()
    {}
    public function indexAction ()
    {}
    /**
     * Ftehces information about a batch on the basis of Btach_id
     * 
     * @param int $batch_id
     */
    public function getbatchinfoAction ($batch_id)
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $httpClient = new Zend_Http_Client(
        'http://' . CORE_SERVER . '/batch/getbatchinfo');
        $httpClient->setCookie('PHPSESSID', $_COOKIE['PHPSESSID']);
        $httpClient->setMethod('POST');
        $httpClient->setParameterPost(
        array('batch_id' => 1, 'format' => 'json'));
        $response = $httpClient->request();
        if ($response->isError()) {
            $remoteErr = 'REMOTE ERROR: (' . $response->getStatus() . ') ' .
             $response->getHeader('Message') . $response->getBody();
            throw new Zend_Exception($remoteErr, Zend_Log::ERR);
        } else {
            $jsonContent = $response->getBody($response);
            /* json_decode($jsonContent);
             Zend_Registry::get('logger')->debug(
            json_decode($jsonContent));*/
            Zend_Registry::get('logger')->debug(
            Zend_Json_Decoder::decode($jsonContent));
            $r = Zend_Json_Decoder::decode($jsonContent);
            $batch_info = $r['batch_info'];
            Zend_Registry::get('logger')->debug($batch_info);
        }
    }
    //This is the code used in bootstrap for the cookie problem:
    //rename function to _initSession
    protected function s ()
    {
        /*$sessName = 'PHPSESSID';
		$sessOptions = array('name' => $sessName);

		if (
		(stripos($_SERVER['REQUEST_URI'], '__tkn') !== false)
		and (preg_match('#__tkn/([a-z\d]{25,32})#si', $_SERVER['REQUEST_URI'], $matches))
		and (stripos($_SERVER[\"HTTP_COOKIE\"], $matches[1]) === false))
		{
		    $sid = $matches[1];
		    $prefix = '';
		    if (!empty($_SERVER[\"HTTP_COOKIE\"])) {
		        $prefix = '; ';
		    }
		    $_SERVER[\"HTTP_COOKIE\"] .= $prefix . $sessName . '=' . $sid;
		    $_COOKIE[$sessName] = $sid;
		    Zend_Session::setId($sid);
		}
		Zend_Session::setOptions($sessOptions);*/
    }
}