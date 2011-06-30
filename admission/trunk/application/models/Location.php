<?php
class Admsn_Model_Location extends Zend_Db_Table
{
    public function getStates($state = NULL) {
        $select = $this->getAdapter()->select()->from('states');
        if ($state) {
            $select->where('state_name like ?','%'.$state.'%');
        }
        return $select->query()->fetchAll();
    }
}