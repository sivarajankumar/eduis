<?php
class UtilityController extends Zend_Controller_Action
{
    /**
     * 
     * @var int
     */
    protected $_member_id;
    protected $_user_name;
    protected $_user_type;
    protected $_department_id;
    /**
     * @return the $_member_id
     */
    protected function getMember_id ()
    {
        return $this->_member_id;
    }
    /**
     * @return the $_user_name
     */
    protected function getUser_name ()
    {
        return $this->_user_name;
    }
    /**
     * @return the $_user_type
     */
    protected function getUser_type ()
    {
        return $this->_user_type;
    }
    /**
     * @return the $_department_id
     */
    protected function getDepartment_id ()
    {
        return $this->_department_id;
    }
    /**
     * @param int $_member_id
     */
    protected function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    /**
     * @param field_type $_user_name
     */
    protected function setUser_name ($_user_name)
    {
        $this->_user_name = $_user_name;
    }
    /**
     * @param field_type $_user_type
     */
    protected function setUser_type ($_user_type)
    {
        $this->_user_type = $_user_type;
    }
    /**
     * @param field_type $_department_id
     */
    protected function setDepartment_id ($_department_id)
    {
        $this->_department_id = $_department_id;
    }
    public function intersectAction ()
    {
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();
        $format = $this->_getParam('format', 'log');
        $request = $this->getRequest();
        $params = array_diff($request->getParams(), $request->getUserParams());
        $array_one = $params['myarray']['arrayOne'];
        $array_two = $params['myarray']['arrayTwo'];
        Zend_Registry::get('logger')->debug($array_one);
        Zend_Registry::get('logger')->debug($array_two);
        $result = array_intersect($array_one, $array_two);
        if (empty($result)) {
            $response = false;
        } else {
            $response = $result;
        }
        switch ($format) {
            case 'jsonp':
                $callback = $this->getRequest()->getParam('callback');
                echo $callback . '(' . $this->_helper->json($response, false) .
                 ')';
                break;
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
        }
    }
}

