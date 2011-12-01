<?php
/**
 * SearchController
 * 
 * @author
 * @version 
 */

class SearchController extends Zend_Controller_Action
{
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated SearchController::indexAction() default action
    }
    
    public function studentAction ()
    {
    	$request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $without_rangeKeys = array('gender'=>'',
                               'nationality_id'=>'',
                               'cast'=>'');
        $without_range = array_intersect_key($params, $without_rangeKeys);
        $this->_helper->logger($without_range);
    }
}
