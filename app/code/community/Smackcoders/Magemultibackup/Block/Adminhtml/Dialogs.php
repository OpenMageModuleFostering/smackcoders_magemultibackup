<?php
class Smackcoders_Magemultibackup_Block_Adminhtml_Dialogs extends Mage_Adminhtml_Block_Template
{
    /**
     * Block's template
     *
     * @var string
     */
    protected $_template = 'magemultibackup/dialogs.phtml';

    /**
     * Include backup.js file in page before rendering
     *
     * @see Mage_Core_Block_Abstract::_prepareLayout()
     */
    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('head')->addJs('magemultibackup/backup.js');
        parent::_prepareLayout();
    }
}
