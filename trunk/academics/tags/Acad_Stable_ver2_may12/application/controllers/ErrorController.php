<?php
class ErrorController extends Zend_Controller_Action
{
    public function errorAction ()
    {
        $this->_helper->layout()->disableLayout();
        $this->getResponse()->clearBody();
        $errors = $this->_getParam('error_handler');
        $message = null;
    
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $message = 'Page not found';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(403);
                break;
        }
        $exception = $errors->exception;
        if ($exception instanceof Exception) {
            $priority = $exception->getCode();
            $message = $exception->getMessage();
            
            // Log exception, if logger available
            $log = $this->getLog();
            if ($log) {
                if (0 <= $priority and $priority <= 8) {
		            $log->log($message, $priority, $errors->exception);
		            $log->log('Request Parameters', $priority, $errors->request->getParams());
                } else {
                    $log->crit($priority . ' ' . $message);
                }
            }
            
            $this->getResponse()->setHeader('Message', $message);
            
            if ($this->getRequest()->isXmlHttpRequest()) {
                $this->_helper->viewRenderer->setNoRender();
                $this->getResponse()->setBody($message);
                // conditionally display exceptions
                if ($this->getInvokeArg('displayExceptions') == true) {
                    $this->getResponse()->append('line', $exception->getLine());
                    $this->getResponse()->append('file', $exception->getFile());
                    $this->getResponse()->append('trace', $exception->getTraceAsString());
                }
            } else {
                $this->view->message = $message;
                
                // conditionally display exceptions
                if ($this->getInvokeArg('displayExceptions') == true) {
                    $this->view->exception = $exception;
                }
                
                $this->view->request = $errors->request;
            }
        }
    }
    /**
     * 
     * Enter description here ...
     * @return Zend_Log
     */
    public function getLog ()
    {
        if (Zend_Registry::isRegistered('logger')) {
            $log = Zend_Registry::get('logger');
            return $log;
        }
    }
}