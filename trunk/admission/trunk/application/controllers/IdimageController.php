<?php

class IdimageController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // action body
    }
    
    public function setimageAction() {
    
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $this->_helper->viewRenderer->setNoRender(TRUE);
        $this->_helper->layout()->disableLayout();
        foreach ($params as $colName => $value) {
            $value = is_array($value)?$value:htmlentities(trim($value));
            $params[$colName] = $value;
        }
        $this->_helper->logger($params);
        $candidate = new Admsn_Model_Member_Candidate();
        $candidate->setRoll_no($params['rollno']);
        $this->_helper->logger('Hi');
        $status = $candidate->setImage_no($params['image_no']);
        if ($status) {
        echo 'Latest Update:<br/>';
        foreach ($params as $colName => $value) {
            
            $value = is_array($value)?var_export($value,true):htmlentities(trim($value));
            echo '<b>'.ucwords(str_ireplace('_', ' ', $colName)).'</b> : '.$value.'<br/>';
        }
        } else {
            throw new Exception('Not able to update!!', Zend_Log::ERR);
        }
    
    }

}

