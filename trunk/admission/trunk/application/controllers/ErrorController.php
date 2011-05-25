<?php
class ErrorController extends Zend_Controller_Action
{
    public function errorAction ()
    {
        $errors = $this->_getParam('error_handler');
        $message = null;
        if (! $errors) {
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
                $this->getResponse()->setHttpResponseCode(500);
                $message = 'Application error';
                break;
        }
        // Log exception, if logger available
        $log = $this->getLog();
        $code = $errors->exception->getCode();
        if ($log) {
            if (0 <= $code and $code <= 8) {
                $log->log($errors->exception->getMessage(),$code);
            } else {
                $log->crit($errors->exception->getMessage());
            }
        }
        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $this->getResponse()->setHttpResponseCode(403);
            $this->getResponse()->clearBody(); 
            $this->getResponse()->setBody($errors->exception->getMessage());
        } else {
            // conditionally display exceptions
            if ($this->getInvokeArg('displayExceptions') == true) {
                $this->view->exception = $errors->exception;
            }
            $this->view->message = $message;
            $this->view->request = $errors->request;
        }
        
    }

	public function getLog() {
		if (Zend_Registry::isRegistered ( 'logger' )) {
			$log = Zend_Registry::get ( 'logger' );
			return $log;
		}
	}
}

