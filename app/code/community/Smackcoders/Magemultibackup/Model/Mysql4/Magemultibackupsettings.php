<?php
 
class Smackcoders_Magemultibackup_Model_Mysql4_Magemultibackupsettings extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('magemultibackup/magemultibackupsettings', 'magemultibackupsettings_id');
    }
}
