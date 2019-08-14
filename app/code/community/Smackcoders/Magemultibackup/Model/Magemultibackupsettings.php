<?php
 
class Smackcoders_Magemultibackup_Model_Magemultibackupsettings extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('magemultibackup/magemultibackupsettings');
    }
}
