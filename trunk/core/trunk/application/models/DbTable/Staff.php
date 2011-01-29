<?php

class Core_Model_DbTable_Staff extends Corez_Base_Model {
	
public  static function getDepartmentStaff($department_id)
{
	$sql = self::getDefaultAdapter()->query('SELECT initial,staff_id, CONCAT(first_name," ",last_name) AS staff_name FROM staff_personal WHERE department_id = ?',array($department_id));
	return $sql->fetchAll(); 											 
}
}