<?php
class UtilitiesController extends Zend_Controller_Action
{
    public function init ()
    {}
    public function indexAction ()
    {}
    public function intersectionAction ()
    {}
    public function extractnumbersAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $request_object = $this->getRequest();
        $params = array_diff($request_object->getParams(), 
        $request_object->getUserParams());
        //$number_string = $params['myarray']['number_string'];
        $number_string = '#$23080110,&%21564188,$s2346778';
        $format = $this->_getParam('format', 'log');
        $exploded = explode(',', $number_string);
        $result = array();
        /*$specialChars = array(" ", "$", "%", "#", "&", "\r", "\n");
        $replaceChars = array("", "", "");*/
        /*$splitted_value = str_replace($specialChars, $replaceChars, 
            $splitted_value);*/
        foreach ($exploded as $splitted_value) {
            $splitted_value = preg_replace("/[^A-Za-z0-9]/", "", 
            $splitted_value);
            Zend_Registry::get('logger')->debug($splitted_value);
            $result[] = intval($splitted_value);
        }
        Zend_Registry::get('logger')->debug($result);
        /* switch ($format) {
            case 'json':
                $this->_helper->json($response);
                break;
            case 'log':
                Zend_Registry::get('logger')->debug('No format was provided..');
                Zend_Registry::get('logger')->debug($response);
                break;
            default:
                ;
                break;
        }*/
    }
}
