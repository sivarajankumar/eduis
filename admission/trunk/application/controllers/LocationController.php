<?php

class LocationController extends Admsnz_Base_BaseController
{
    public function indexAction()
    {
        // action body
    }

    public function getstatesAction()
    {
        $term = $this->getRequest()->getParam('term');
        $locator = new Admsn_Model_Location();
        $states = $locator->getStates($term);
        $response = array();
        foreach ($states as $key => $state) {
            $response[] = $state['states_name']." | ".$state['states_id'];
        }
        $this->_helper->json($response);
        /*$logger = Zend_Registry::get('logger');
        $logger->debug($states);*/
        // action body
    }

}

