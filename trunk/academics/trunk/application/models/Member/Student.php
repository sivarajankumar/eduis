<?php
class Acad_Model_Member_Student extends Acad_Model_Member_Generic {
     
    /**
     * Set roll number of student
     * 
     * Since roll number and member Id are same.
     * 
     * @param string|int $rollNumber Roll number
     * @return Acad_Model_Member_Student
     */
    public function setRollNumber($rollNumber){
        return self::setMemberId($rollNumber);
    }
    
    /**
     * Get roll number of student
     * 
     * Since roll number and member Id are same.
     * 
     * @return string|int $rollNumber Roll number
     */
    public function getRollNumber(){
        return self::getMemberId();
    }
    
	
}