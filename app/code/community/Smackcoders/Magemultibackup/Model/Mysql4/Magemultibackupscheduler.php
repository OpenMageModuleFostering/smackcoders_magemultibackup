<?php
 
class Smackcoders_Magemultibackup_Model_Mysql4_Magemultibackupscheduler extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('magemultibackup/magemultibackupscheduler', 'scheduler_id');
    }
}
