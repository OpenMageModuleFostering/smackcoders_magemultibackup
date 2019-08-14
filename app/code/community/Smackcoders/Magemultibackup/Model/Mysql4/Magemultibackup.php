<?php
 
class Smackcoders_Magemultibackup_Model_Mysql4_Magemultibackup extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('magemultibackup/magemultibackup', 'magemultibackup_id');
    }
}
