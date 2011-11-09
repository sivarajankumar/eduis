<?php
class Tnp_Model_Profile_Components_Certification extends Tnp_Model_Generic
{
    protected $_member_certifications_info = array();
    protected $_certification_id;
    protected $_certification_name;
    protected $_technical_field_id;
    protected $_technical_field_name;
    protected $_technical_sector;
    protected $_member_id;
    protected $_start_date;
    protected $_complete_date;
    protected $_mapper;
    protected function getMember_certifications_info ()
    {
        $member_certifications_info = $this->_member_certifications_info;
        if (sizeof($member_certifications_info) == 0) {
            $member_certifications_info = $this->getMapper()->fetchMemberCertificationInfo(
            $this);
            $this->setMember_certifications_info($member_certifications_info);
        }
        return $this->_member_certifications_info;
    }
    protected function setMember_certifications_info (
    $_member_certifications_info)
    {
        $this->_member_certifications_info = $_member_certifications_info;
    }
    public function getCertification_id ()
    {
        $certification_id = $this->_certification_id;
        if (! isset($certification_id)) {
            $this->getMapper()->fetchCertification_id($this);
        }
        return $this->_certification_id;
    }
    public function setCertification_id ($_certification_id)
    {
        $this->_certification_id = $_certification_id;
    }
    public function getCertification_name ()
    {
        return $this->_certification_name;
    }
    public function setCertification_name ($_certification_name)
    {
        $this->_certification_name = $_certification_name;
    }
    public function getTechnical_field_id ()
    {
        $technical_field_id = $this->_technical_field_id;
        if (! isset($technical_field_id)) {
            $this->getMapper()->fetchTechnical_field_id($this);
        }
        return $this->_technical_field_id;
    }
    public function setTechnical_field_id ($_technical_field_id)
    {
        $this->_technical_field_id = $_technical_field_id;
    }
    public function getTechnical_field_name ()
    {
        return $this->_technical_field_name;
    }
    public function setTechnical_field_name ($_technical_field_name)
    {
        $this->_technical_field_name = $_technical_field_name;
    }
    public function getTechnical_sector ()
    {
        return $this->_technical_sector;
    }
    public function setTechnical_sector ($_technical_sector)
    {
        $this->_technical_sector = $_technical_sector;
    }
    public function getMember_id ()
    {
        return $this->_member_id;
    }
    public function setMember_id ($_member_id)
    {
        $this->_member_id = $_member_id;
    }
    public function getStart_date ()
    {
        return $this->_start_date;
    }
    public function setStart_date ($_start_date)
    {
        $this->_start_date = $_start_date;
    }
    public function getComplete_date ()
    {
        return $this->_complete_date;
    }
    public function setComplete_date ($_complete_date)
    {
        $this->_complete_date = $_complete_date;
    }
    /**
     * Set Mapper
     * @param Tnp_Model_Mapper_Profile_Components_Certification $mapper
     * @return Tnp_Model_Profile_Components_Certification
     */
    public function setMapper ($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }
    /**
     * gets the mapper from the object class
     * @return Tnp_Model_Mapper_Profile_Components_Certification
     */
    public function getMapper ()
    {
        if (null === $this->_mapper) {
            $this->setMapper(
            new Tnp_Model_Mapper_Profile_Components_Certification());
        }
        return $this->_mapper;
    }
    /**
     * 
     * Enter description here ...
     */
    public function initMemberCertificationInfo ()
    {
        $certifications_info = $this->getMember_certifications_info();
        $certifications_id = $this->getCertification_id();
        if (! isset($certifications_id)) {
            $error = 'No Certification Id provided';
            throw new Exception($error);
        } else {
            if (! array_key_exists($certifications_id, $certifications_info)) {
                $error = 'Certification Id : ' . $certifications_id . 'for user ' .
                 $this->getMember_id() . ' is invalid';
                throw new Exception($error);
            } else {
                $options = $certifications_info[$certifications_id];
                $this->setOptions($options);
            }
        }
    }
    public function getMemberCertificationIds ()
    {
        $certifications_info = $this->getMember_certifications_info();
        return array_keys($certifications_info);
    }
    public function initCertificationInfo ()
    {
        $options = $this->getMapper()->fetchCertificationInfo($this);
        $this->setOptions($options);
    }
    public function initTechnicalFieldInfo ()
    {
        $options = $this->getMapper()->fetchTechnicalFieldInfo($this);
        $this->setOptions($options);
    }
}