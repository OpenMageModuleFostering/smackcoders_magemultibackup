<?php
 
class Smackcoders_Magemultibackup_Model_Mysql4_Magemultibackup_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        //parent::__construct();
        $this->_init('magemultibackup/magemultibackup');
//	$this->_init('magemultibackup/magemultibackupsettings');
    }
}
