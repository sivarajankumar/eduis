<?php
class Tnp_Model_Core_Industries extends Tnp_Model_Generic
{
    protected $_industry_id;
    protected $_industry_name;
    protected $_mapper;
    /**
     * @return the $_industry_id
     */
    public function getIndustry_id ($throw_exception = null)
    {
        $industry_id = $this->_industry_id;
        if (empty($industry_id) and $throw_exception == true) {
            $message = '_industry_id is not set';
            $code = Zend_Log::ERR;
            throw new Exception($message, $code);
        } else {
            return $industry_id;
        }
    }
    /**
     * @return the $_industry_name
     */
    public function getIndustry_name ()
    {
        return $this->_industry_name;
    }
    /**
     * @param field_type $_industry_id
     */
    public function setIndustry_id ($_industry_id)
    {
        $this->_industry_id = $_industry_id;
    }
    /**
     * @param field_type $_industry_name
     */
    public function setIndustry_name ($_industry_name)
    {
        $this->_industry_name = $_industry_name;
    }
    /**
     * Sets Mapper
     * @param Tnp_Model_Mapper_Core_Industries $mapper
     * @return Tnp_Model_Core_Industries
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Core_Industries
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Tnp_Model_Mapper_Core_Industries());
        }
        return $this->_mapper;
    }
    /**
     * Provides correct db column names corresponding to model properties
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctDbKeys ($key)
    {
        switch ($key) {
            /*case 'nationalit':
                return 'nationality';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * Provides correct model property names corresponding to db column names
     * @todo add correct names where required
     * @param string $key
     */
    protected function correctModelKeys ($key)
    {
        switch ($key) {
            /*case 'nationality':
                return 'nationalit';
                break;*/
            default:
                return $key;
                break;
        }
    }
    /**
     * 
     * @return array ,Format = array($industry_id=>$industry_names)
     */
    public function fetchIndustries ()
    {
        $industries = array();
        $industries = $this->getMapper()->fetchIndustries();
        if (empty($industries)) {
            return false;
        } else {
            return $industries;
        }
    }
    public function fetchInfo ()
    {
        $industry_id = $this->getIndustry_id(true);
        $info = array();
        $info = $this->getMapper()->fetchInfo($industry_id);
        if (empty($info)) {
            return false;
        } else {
            return $this->setOptions($info);
        }
    }
}