<?php
 
class Smackcoders_Magemultibackup_Model_Magemultibackupscheduler extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('magemultibackup/magemultibackupscheduler');
    }
}
