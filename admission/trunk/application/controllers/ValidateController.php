<?php
/**
 * ValidateController
 * 
 * @author Hemant
 * @version 0.1
 * @since 0.1
 */
class ValidateController extends Admsnz_Base_BaseController
{
    public function rollnoAction ()
    {
        $rollNo = $this->getRequest()->getParam('roll_no');
        $application_basis = $this->getRequest()->getParam('application_basis');
        $candidate = new Admsn_Model_Member_Candidate();
        $status = $candidate->setRoll_no($rollNo)->exists();
        
        $applicant = new Zend_Session_Namespace('applicant');
        $applicant->unsetAll();
        if (isset($status['is_locked']) and $status['is_locked'] == 1) {
            throw new Zend_Exception($rollNo.' has locked the application.',Zend_Log::ERR);
        } elseif ($status) {
            $applicant->roll_no = $status['roll_no'];
            $applicant->application_basis = $status['application_basis'];
            
        } else {
            $applicant->roll_no = $rollNo;
            $applicant->application_basis = $application_basis;
        }
        
        $this->_helper->json($status);
    }
}
