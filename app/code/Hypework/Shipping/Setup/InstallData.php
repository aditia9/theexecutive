<?php

namespace Hypework\Shipping\Setup;
 
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
 
class InstallData implements InstallDataInterface
{
    /**
     * EAV setup factory
     *
     * @var EavSetupFactory
     */
    private $eavSetupFactory;
 
    /**
     * Init
     *
     * @param EavSetupFactory $eavSetupFactory
     */
    public function __construct(EavSetupFactory $eavSetupFactory)
    {
        $this->eavSetupFactory = $eavSetupFactory;
    }
 
    /**
     * {@inheritdoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        if(!$context->getVersion()) {
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance(); // Instance of object manager
            $resource = $objectManager->get('Magento\Framework\App\ResourceConnection');
            $connection = $resource->getConnection();

            $tableName = $resource->getTableName('hypework_shipping_carrier');
            $dateObject = $objectManager->create('Magento\Framework\Stdlib\DateTime\DateTime');
            $now = $dateObject->gmtDate();
            $sql = "Insert Into " . $tableName . " (name, status, created_at, updated_at) Values ('jne','1','".$now."', '".$now."'); ";
            $connection->query($sql);

            $sql = "Insert Into " . $tableName . " (name, status, created_at, updated_at) Values ('tiki','1','".$now."', '".$now."'); ";
            $connection->query($sql);

            $sql = "Insert Into " . $tableName . " (name, status, created_at, updated_at) Values ('ekspedisi','1','".$now."', '".$now."'); ";
            $connection->query($sql);

            $sql = "Insert Into " . $tableName . " (name, status, created_at, updated_at) Values ('hypework','1','".$now."', '".$now."'); ";
            $connection->query($sql);



            $dataArray = array(
                            array('ID','ID-AC','Aceh'),
                            array('ID','ID-SU','Sumatera Utara'),
                            array('ID','ID-SB','Sumatera Barat'),
                            array('ID','ID-RI','Riau'),
                            array('ID','ID-JA','Jambi'),
                            array('ID','ID-SS','Sumatera Selatan'),
                            array('ID','ID-BE','Bengkulu'),
                            array('ID','ID-LA','Lampung'),
                            array('ID','ID-BB','Kep. Bangka Belitung'),
                            array('ID','ID-KR','Kep. Riau'),
                            array('ID','ID-JK','DKI Jakarta'),
                            array('ID','ID-JB','Jawa Barat'),
                            array('ID','ID-JT','Jawa Tengah'),
                            array('ID','ID-YO','D.I Yogyakarta'),
                            array('ID','ID-JI','Jawa Timur'),
                            array('ID','ID-BT','Banten'),
                            array('ID','ID-BA','Bali'),
                            array('ID','ID-NB','Nusa Tenggara Barat'),
                            array('ID','ID-NT','Nusa Tenggara Timur'),
                            array('ID','ID-KB','Kalimantan Barat'),
                            array('ID','ID-KT','Kalimantan Tengah'),
                            array('ID','ID-KS','Kalimantan Selatan'),
                            array('ID','ID-KI','Kalimantan Timur'),
                            array('ID','ID-SA','Sulawesi Utara'),
                            array('ID','ID-ST','Sulawesi Tengah'),
                            array('ID','ID-SN','Sulawesi Selatan'),
                            array('ID','ID-SG','Sulawesi Tenggara'),
                            array('ID','ID-GO','Gorontalo'),
                            array('ID','ID-SR','Sulawesi Barat'),
                            array('ID','ID-MA','Maluku'),
                            array('ID','ID-MU','Maluku Utara'),
                            array('ID','ID-PB','Papua Barat'),
                            array('ID','ID-PA','Papua'),
                        );

            $tableName = $resource->getTableName('directory_country_region');
            foreach($dataArray as $data) {
                $sql = "Insert Into " . $tableName . " (country_id, code, default_name) Values ('".$data[0]."','".$data[1]."','".$data[2]."'); ";
                $connection->query($sql);
            }



            $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
            
            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'length',
                [
                    'type'          => 'varchar',
                    // 'group'         => 'Package L X W X H',
                    'input'         => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'source' => '',
                    'label'         => 'Package Length',
                    'visible' => true,
                    'required'      => false,
                    'global'        => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,                    
                    // 'note'          => 'Length in (cm)',
                    'searchable'                    => false,
                    'filterable'                    => false,
                    'comparable'                    => false,
                    'visible_on_front'              => false,
                    'visible_in_advanced_search'    => false,
                    'user_defined' => false,
                    'default' => '',
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => '',
                ]
            );

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'width',
                [
                    'type'          => 'varchar',
                    // 'group'         => 'Package L X W X H',
                    'input'         => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'source' => '',
                    'label'         => 'Package Width',
                    'visible' => true,
                    'required'      => false,
                    'global'        => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,                    
                    // 'note'          => 'Width in (cm)',
                    'searchable'                    => false,
                    'filterable'                    => false,
                    'comparable'                    => false,
                    'visible_on_front'              => false,
                    'visible_in_advanced_search'    => false,
                    'user_defined' => false,
                    'default' => '',
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => '',
                ]
            );

            $eavSetup->addAttribute(
                \Magento\Catalog\Model\Product::ENTITY,
                'height',
                [
                    'type'          => 'varchar',
                    // 'group'         => 'Package L X W X H',
                    'input'         => 'text',
                    'backend' => '',
                    'frontend' => '',
                    'class' => '',
                    'source' => '',
                    'label'         => 'Package Height',
                    'visible' => true,
                    'required'      => false,
                    'global'        => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_GLOBAL,                    
                    // 'note'          => 'Height in (cm)',
                    'searchable'                    => false,
                    'filterable'                    => false,
                    'comparable'                    => false,
                    'visible_on_front'              => false,
                    'visible_in_advanced_search'    => false,
                    'user_defined' => false,
                    'default' => '',
                    'used_in_product_listing' => false,
                    'unique' => false,
                    'apply_to' => '',
                ]
            );
        }
 
        $setup->endSetup();
    }
}