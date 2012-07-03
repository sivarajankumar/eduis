<?php
class Admsn_Model_DbTable_Applicant extends Zend_Db_Table
{
    protected $_name = 'applicants';
    protected $applicant = '';
    public function init ()
    {
        $this->applicant = new Zend_Session_Namespace('applicant');
    }
    public function save ()
    {
        $ever_disqualified = $this->applicant->ever_disqualified;
        if ($ever_disqualified == false) {
            $ever_disqualified = 0;
        } elseif ($ever_disqualified == true) {
            $ever_disqualified = 1;
        }
        $applicant = array('roll_no' => $this->applicant->roll_no, 
        'application_basis' => $this->applicant->application_basis, 
        'councelling_no' => $this->applicant->councelling_no, 
        'allotted_category' => $this->applicant->allotted_category, 
        'allotted_branch' => $this->applicant->allotted_branch, 
        'state_of_domicile' => $this->applicant->state_of_domicile, 
        'urban' => ('true' == $this->applicant->urban or
         true == $this->applicant->urban) ? 1 : 0, 
        'hostel' => ('true' == $this->applicant->hostel or
         true == $this->applicant->hostel) ? 1 : 0, 
        'bus' => ('true' == $this->applicant->bus or
         true == $this->applicant->bus) ? 1 : 0, 
        'ever_disqualified' => $ever_disqualified, 
        'image_no' => $this->applicant->image_no, 
        'councelling_fees' => $this->applicant->councelling_fees, 
        'councelling_bank' => $this->applicant->councelling_bank, 
        'councelling_type' => $this->applicant->councelling_type, 
        'specialities' => $this->applicant->specialities);
        $matric = array('roll_no' => $this->applicant->roll_no, 
        'matric_marks_obtained' => $this->applicant->matric_marks_obtained, 
        'matric_total_marks' => $this->applicant->matric_total_marks, 
        'matric_percentage' => $this->applicant->matric_percentage, 
        'matric_roll_no' => $this->applicant->matric_roll_no, 
        'matric_board' => $this->applicant->matric_board, 
        'matric_passing_year' => $this->applicant->matric_passing_year, 
        'matric_institution' => $this->applicant->matric_institution, 
        'matric_city' => $this->applicant->matric_city, 
        'matric_state' => $this->applicant->matric_state);
        $basic = array('roll_no' => $this->applicant->roll_no, 
        'first_name' => $this->applicant->first_name, 
        'middle_name' => $this->applicant->middle_name, 
        'last_name' => $this->applicant->last_name, 
        'dob' => $this->applicant->dob, 'gender' => $this->applicant->gender, 
        'blood_group_id' => $this->applicant->blood_group_id, 
        'nationality_id' => $this->applicant->nationality_id, 
        'religion_id' => $this->applicant->religion_id, 
        'cast' => $this->applicant->cast, 
        'contact_no' => $this->applicant->contact_no, 
        'e_mail' => $this->applicant->e_mail);
        $guardians = array('roll_no' => $this->applicant->roll_no, 
        'landline_no' => $this->applicant->landline_no, 
        'father_name' => $this->applicant->father_name, 
        'father_occupation' => $this->applicant->father_occupation, 
        'father_designation' => $this->applicant->father_designation, 
        'father_office_add' => $this->applicant->father_office_add, 
        'father_contact' => $this->applicant->father_contact, 
        'mother_name' => $this->applicant->mother_name, 
        'mother_occupation' => $this->applicant->mother_occupation, 
        'mother_designation' => $this->applicant->mother_designation, 
        'mother_office_add' => $this->applicant->mother_office_add, 
        'guardian_name' => $this->applicant->guardian_name, 
        'guardian_contact' => $this->applicant->guardian_contact, 
        'guardian_relation' => $this->applicant->guardian_relation, 
        'annual_income' => $this->applicant->annual_income);
        $address = array('roll_no' => $this->applicant->roll_no, 
        'c_pin' => $this->applicant->c_pin, 'c_city' => $this->applicant->c_city, 
        'c_state' => $this->applicant->c_state, 
        'c_add' => $this->applicant->c_add, 
        'is_cp_same' => ('true' == strtolower($this->applicant->is_cp_same) or
         true == $this->applicant->is_cp_same) ? 1 : 0, 
        'p_pin' => $this->applicant->p_pin, 'p_city' => $this->applicant->p_city, 
        'p_state' => $this->applicant->p_state, 
        'p_add' => $this->applicant->p_add, 
        'has_guardian' => ('true' == strtolower($this->applicant->has_guardian) or
         true == $this->applicant->has_guardian) ? 1 : 0, 
        'g_pin' => $this->applicant->g_pin, 'g_city' => $this->applicant->g_city, 
        'g_state' => $this->applicant->g_state, 
        'g_add' => $this->applicant->g_add);
        if ('null' != $this->applicant->boarding_station) {
            $bus = array('roll_no' => $this->applicant->roll_no, 
            'boarding_station' => $this->applicant->boarding_station);
        }
        try {
            $this->getAdapter()->beginTransaction();
            $this->getAdapter()->insert('applicants', $applicant);
            switch ($this->applicant->application_basis) {
                case 'aieee':
                    $aieee = array('roll_no' => $this->applicant->roll_no, 
                    'ai_rank' => $this->applicant->ai_rank, 
                    'ai_cat_rank' => $this->applicant->ai_cat_rank, 
                    'state_rank' => $this->applicant->state_rank, 
                    'state_cat_rank' => $this->applicant->state_cat_rank, 
                    'application_no' => $this->applicant->application_no, 
                    'aieee_marks' => $this->applicant->aieee_marks);
                    $this->getAdapter()->insert('aieee', $aieee);
                case 'twelfth':
                    $twelfth = array('roll_no' => $this->applicant->roll_no, 
                    'board_roll' => $this->applicant->board_roll, 
                    'marks_obtained' => $this->applicant->marks_obtained, 
                    'total_marks' => $this->applicant->total_marks, 
                    'percentage' => $this->applicant->percentage, 
                    'pcm_percent' => $this->applicant->pcm_percent, 
                    'passing_year' => $this->applicant->passing_year, 
                    'board' => $this->applicant->board, 
                    'school_rank' => $this->applicant->school_rank, 
                    'institution' => $this->applicant->institution, 
                    'institution_city' => $this->applicant->institution_city, 
                    'institution_state' => $this->applicant->institution_state);
                    $this->getAdapter()->insert('twelfth', $twelfth);
                    break;
                case 'leet':
                    $leet = array('roll_no' => $this->applicant->roll_no, 
                    'board_roll' => $this->applicant->board_roll, 
                    'marks_obtained' => $this->applicant->marks_obtained, 
                    'total_marks' => $this->applicant->total_marks, 
                    'percentage' => $this->applicant->percentage, 
                    'leet_rank' => $this->applicant->leet_rank, 
                    'passing_year' => $this->applicant->passing_year, 
                    'board' => $this->applicant->board, 
                    'branch' => $this->applicant->branch, 
                    'leet_marks' => $this->applicant->leet_marks, 
                    'institution' => $this->applicant->institution, 
                    'institution_city' => $this->applicant->institution_city, 
                    'institution_state' => $this->applicant->institution_state);
                    $this->getAdapter()->insert('leet', $leet);
                    break;
                default:
                    ;
                    break;
            }
            $this->getAdapter()->insert('matric_info', $matric);
            $this->getAdapter()->insert('basic_info', $basic);
            $this->getAdapter()->insert('guardians', $guardians);
            $this->getAdapter()->insert('address', $address);
            if ('null' != $this->applicant->boarding_station) {
                $this->getAdapter()->insert('bus', $bus);
            }
            $this->getAdapter()->commit();
            return true;
        } catch (Exception $e) {
            $this->getAdapter()->rollBack();
            throw $e;
        }
    }
}