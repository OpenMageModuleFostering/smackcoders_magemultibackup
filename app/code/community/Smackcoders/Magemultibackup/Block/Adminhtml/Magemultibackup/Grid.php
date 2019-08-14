<?php
 
class Smackcoders_Magemultibackup_Block_Adminhtml_Magemultibackup_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('magemultibackupGrid');
        // This is the primary key of the database
        $this->setDefaultSort('magemultibackup_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('magemultibackup/magemultibackup')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {

	$this->addExportType('*/*/exportCsv', Mage::helper('magemultibackup')->__('CSV'));
	$this->addExportType('*/*/exportXml', Mage::helper('magemultibackup')->__('XML'));

	$this->addColumn('errorstatus',array(
         'header'=> Mage::helper('magemultibackup')->__('Status'),
         'width' => '50px',
         'type'  => 'image',
         'index' => 'image',
         'renderer' => 'magemultibackup/adminhtml_magemultibackup_renderer_image', //get the image HTML code
         'style' => 'margin:auto;'
    ));

        $this->addColumn('magemultibackup_id', array(
            'header'    => Mage::helper('magemultibackup')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'magemultibackup_id',
        ));
 
        $this->addColumn('createdat', array(
            'header'    => Mage::helper('magemultibackup')->__('Executed At'),
            'align'     =>'left',
            'index'     => 'createdat',
        ));
        $this->addColumn('filename', array(
            'header'    => Mage::helper('magemultibackup')->__('Filename'),
            'align'     =>'left',
            'index'     => 'filename',
        ));

        $this->addColumn('ftpied', array(
            'header'    => Mage::helper('magemultibackup')->__('Type'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'ftpied',
            'type'      => 'options',
            'options'   => array(
                1 => 'FTP',
                0 => 'Local',
            ),
        ));
 
        $this->addColumn('action', array(
            'header'    => Mage::helper('magemultibackup')->__('Action'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'action',
            'type'      => 'options',
            'options'   => array(
                1 => 'Create',
                0 => 'Delete',
		2 => 'Rollback'
            ),
        ));
      $this->addColumn('error', array(
            'header'    => Mage::helper('magemultibackup')->__('Status'),
            'align'     =>'left',
            'index'     => 'error',
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
