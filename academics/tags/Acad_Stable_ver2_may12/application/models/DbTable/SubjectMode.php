<?php
class Acad_Model_DbTable_SubjectMode extends Acadz_Base_Model_Dbtable
{
    protected $_name = 'subject_mode';
    const TABLE_NAME = 'subject_mode';
    /*
	 * @return Subject Mode
	 */
    public static function getActiveSubjectMode ($subject_code, 
    $groupMode = NULL)
    {
        $sql = self::getDefaultAdapter()->select()
            ->distinct()
            ->from(self::TABLE_NAME, 'subject_mode_id')
            ->join('subject_faculty', 
        '(subject_mode.subject_mode_id = subject_faculty.subject_mode_id)', 
        array())
            ->where('subject_faculty.subject_code = ?', $subject_code);
        if ($groupMode) {
            $sql->where('subject_mode.group_together <> ?', 1);
        }
        return $sql->query()->fetchAll();
    }
    public static function getSubjectModes ($subject_code, $groupMode = NULL)
    {
        $sql = self::getDefaultAdapter()->select()
            ->from(self::TABLE_NAME, array('subject_mode_id', 'group_together'))
            ->join('subject', 
        '( subject.subject_type_id = subject_mode.subject_type_id)', array('suggested_duration'))
            ->where('subject.subject_code = ? ', $subject_code);
        if ($groupMode) {
            $sql->where('subject_mode.group_together <> ?', 1);
        }
        return $sql->query()->fetchAll();
    }
    /*
	 * To check if given subject mode includes ALL groups or not.
	 */
    public static function groupTogether ($subjectMode)
    {
        $sql = 'SELECT
				    group_together
				FROM
				    nwaceis.subject_mode
				WHERE (subject_mode_id = ?)';
        $result = self::getDefaultAdapter()->fetchAll($sql, $subjectMode);
        return $result[0]['group_together'];
    }
}