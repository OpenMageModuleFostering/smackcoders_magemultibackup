<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackupmanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('magemultibackupremoveGrid');
        $this->setDefaultSort('magemultibackup_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('magemultibackup/magemultibackup')->getCollection()->addFieldToFilter('ftpied', array('eq' => 0))->addFieldToFilter('localfiledeleted', array('eq' => 0))->addFieldToFilter('status',array('eq' => 1));
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
  protected function _prepareMassaction()
    {
        $this->setMassactionIdField('magemultibackup_id');
        $block = $this->getMassactionBlock();
  	$block->addItem('delete', array(
            'label' => Mage::helper('index')->__('Delete'),
            'url'   => $this->getUrl('*/*/delete'),
        ));
	return $this;
}
    protected function _prepareColumns()
    {
        $this->addColumn('magemultibackup_id', array(
            'header'    => Mage::helper('magemultibackup')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'magemultibackup_id',
        ));
	 $this->addColumn('filename', array(
            'header'    => Mage::helper('magemultibackup')->__('File Name'),
            'align'     =>'left',
            'index'     => 'filename',
  //          'width'     =>'70px',
        ));

 
        $this->addColumn('createdat', array(
            'header'    => Mage::helper('magemultibackup')->__('Created At'),
            'align'     =>'left',
            'index'     => 'createdat',
        ));
            $this->addColumn('rollback', array(
                    'header'   => Mage::helper('magemultibackup')->__('Action'),
                    'type'     => 'action',
                    'width'    => '80px',
                    'filter'   => false,
                    'sortable' => false,
                    'actions'  => array(array(
                        'url'     => '#',
                        'caption' => Mage::helper('magemultibackup')->__('Rollback'),
                        'onclick' => 'return backup.rollback(\'local\', \'$filename\');'
                    )),
                    'index'    => 'type',
                    'sortable' => false
            ));

       $this->addColumn('mode', array(

            'header'    => Mage::helper('magemultibackup')->__('Mode'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'mode',
            'type'      => 'options',
            'options'   => array(
                1 => 'Manual',
                0 => 'Automatic',
            ),
        ));
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($row)
    {
//        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
return null;
    }
 
    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }
 
 
}
