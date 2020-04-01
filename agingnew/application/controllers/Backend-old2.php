






















	// //mass upload product
	// public function uploadproduct(){
	// 	if($this->session->userdata('status') != "backend"){
	// 		redirect(base_url('login'));
	// 	}

	// 	$data['title'] = 'Mass Upload Product - '.BRAND;
	// 	$data['page']  = 'backend/massupload/uploadproduct';
	// 	$this->load->view('backend/thamplate', $data); 
 // 	}

	// public function uploadproduct_act(){
 // 		if($this->session->userdata('status') != "backend"){
	// 		redirect(base_url('login'));
	// 	}

	// 	if(isset($_FILES["file"]["name"])) {
	// 		$path = $_FILES["file"]["tmp_name"];
	// 		$object = PHPExcel_IOFactory::load($path);
	// 		foreach($object->getWorksheetIterator() as $worksheet) {

	// 			$highestRow = $worksheet->getHighestRow();
	// 			$highestColumn = $worksheet->getHighestColumn();
	// 			for($row=2; $row<=$highestRow; $row++) {

	// 				if($worksheet->getCellByColumnAndRow(1, $row)->getValue() == 0){ 
	// 					$qtystock 	 = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
	// 					$statusstock = 0;
	// 				}else{ 
	// 					$qtystock 	 = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
	// 					$statusstock = 1;
	// 				}


	// 				// catalog_product_entity
	// 				$data1['attribute_set_id'] 			= 4;
	// 				$data1['type_id'] 		  			= strtolower($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 				$data1['sku']  			  			= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
	// 				$data1['has_options'] 	  			= 1;
	// 				$data1['required_options'] 			= 1;
	// 				$data1['created_at'] 	  			= date('Y-m-d H:i:s');
	// 				$data1['updated_at'] 	  			= date('Y-m-d H:i:s');
	// 				$this->m_catalog_product_entity->InsertCatalogProductEntity($data1);
	// 				$entity_id = $this->m_catalog_product_entity->GetCatalogProductEntity($worksheet->getCellByColumnAndRow(0, $row)->getValue());


	// 				// cataloginventory_stock_cl
	// 				$data2['entity_id'] 	  			= $entity_id;
	// 				$this->m_catalog_product_entity->InsertCatalogInventoryStock($data2);


	// 				// cataloginventory_stock_item
	// 				$data3['product_id'] 	  			= $entity_id;
	// 				$data3['stock_id'] 		  			= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data3['qty']  			  			= $qtystock;
	// 				$data3['min_qty'] 	  				= 1;
	// 				$data3['use_config_min_qty'] 		= 1;
	// 				$data3['is_qty_decimal'] 	  		= 1;
	// 				$data3['backorders'] 	  			= 0;
	// 				$data3['use_config_backorders'] 	= 1;
	// 				$data3['min_sale_qty'] 	  			= 1.0000;
	// 				$data3['use_config_min_sale_qty'] 	= 1;
	// 				$data3['max_sale_qty'] 	  			= 10000.0000;
	// 				$data3['use_config_max_sale_qty'] 	= 1;
	// 				$data3['is_in_stock'] 	  			= $statusstock;
	// 				$data3['notify_stock_qty'] 	  		= 1.0000;
	// 				$data3['use_config_notify_stock_qty'] = 1;
	// 				$data3['manage_stock'] 	  			= 1;
	// 				$data3['use_config_manage_stock'] 	= 1;
	// 				$data3['stock_status_changed_auto'] = 1;
	// 				$data3['use_config_qty_increments'] = 1;
	// 				$data3['qty_increments'] 	  		= $statusstock;
	// 				$data3['use_config_enable_qty_inc'] = 1;
	// 				$data3['enable_qty_increments'] 	= 0;
	// 				$data3['is_decimal_divided'] 	  	= 0;
	// 				$data3['website_id'] 	  			= 0;
	// 				$this->m_catalog_product_entity->InsertCatalogInventoryStockItem($data3);


	// 				// cataloginventory_stock_status_replica
	// 				$data4['product_id'] 	  			= $entity_id;
	// 				$data4['website_id'] 		  		= 0;
	// 				$data4['stock_id']  			  	= 1;
	// 				$data4['qty'] 	  					= $statusstock;
	// 				$data4['stock_status'] 				= 1;
	// 				$this->m_catalog_product_entity->InsertcatalogInventoryStockStatusReplica($data4);


	// 				// catalogrule_product_cl
	// 				$data5['entity_id'] 	  			= $entity_id;
	// 				$this->m_catalog_product_entity->InsertcatalogSearchFulltextCl($data5);


	// 				// catalogsearch_fulltext_scope1
	// 				$data6['entity_id'] 	  			= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data6['attribute_id'] 	  			= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data6['data_index'] 	  			= $worksheet->getCellByColumnAndRow(3, $row)->getValue().' | '.
	// 													  $worksheet->getCellByColumnAndRow(3, $row)->getValue().' | '.
	// 													  $worksheet->getCellByColumnAndRow(3, $row)->getValue().' | '.
	// 													  $worksheet->getCellByColumnAndRow(3, $row)->getValue().' | '.
	// 													  $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogSearchFulltextScope1($data6);


	// 				// catalog_category_product
	// 		        $pecah = explode(", ", $worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 		        foreach($pecah as $i =>$key) {
	// 					$i >0;
	// 					$category = $this->m_catalog_product_entity->GetCatalogProduct($key);

	// 					$data7['category_id'] 	  		= $category;
	// 					$data7['product_id'] 	  		= $entity_id;
	// 					$data7['position'] 	  			= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogCategoryProduct($data7);

	// 					// catalog_category_product_index
	// 					$data8['category_id'] 	  		= $category;
	// 					$data8['product_id'] 		  	= $entity_id;
	// 					$data8['position']  			= 0;
	// 					$data8['is_parent'] 	  		= 1;
	// 					$data8['store_id'] 				= 1;
	// 					$data8['visibility'] 			= 4;
	// 					$this->m_catalog_product_entity->InsertcatalogCategoryProductIndex($data8);
	// 				}


	// 				// catalog_category_product_index
	// 				$data9['category_id'] 	  		= 3;
	// 				$data9['product_id'] 		  	= $entity_id;
	// 				$data9['position']  			= 10000;
	// 				$data9['is_parent'] 	  		= 0;
	// 				$data9['store_id'] 				= 1;
	// 				$data9['visibility'] 			= 4;
	// 				$this->m_catalog_product_entity->InsertcatalogCategoryProductIndex($data9);


	// 				// cataloginventory_stock_status_replica
	// 				$data10['entity_id'] 		  	= $entity_id;
	// 				$this->m_catalog_product_entity->InsertcatalogProductAttributeCl($data10);


	// 				// catalog_product_category_cl
	// 				$data11['entity_id'] 		  	= $entity_id;
	// 				$this->m_catalog_product_entity->InsertcatalogProductCategoryCl($data11);


	// 				// catalog_product_entity_decimal
	// 				$data12['attribute_id'] 		= 82;
	// 				$data12['store_id'] 		  	= 0;
	// 				$data12['entity_id'] 		  	= $entity_id;
	// 				$data12['value'] 		  		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityDecimal($data12);


	// 				//catalog_product_entity_int
	// 				$data13['attribute_id'] 		= 93;
	// 				$data13['store_id'] 		  	= 0;
	// 				$data13['entity_id'] 		  	= $entity_id;
	// 				$data13['value'] 		  		= $this->m_catalog_product_entity->GetColorProduct($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 				$this->m_catalog_product_entity->catalog_product_entity_int($data13);

	// 				$data14['attribute_id'] 		= 97;
	// 				$data14['store_id'] 		  	= 0;
	// 				$data14['entity_id'] 		  	= $entity_id;
	// 				$data14['value'] 		  		= 1;
	// 				$this->m_catalog_product_entity->catalog_product_entity_int($data14);

	// 				$data15['attribute_id'] 		= 99;
	// 				$data15['store_id'] 		  	= 0;
	// 				$data15['entity_id'] 		  	= $entity_id;
	// 				$data15['value'] 		  		= 4;
	// 				$this->m_catalog_product_entity->catalog_product_entity_int($data15);

	// 				$data16['attribute_id'] 		= 115;
	// 				$data16['store_id'] 		  	= 0;
	// 				$data16['entity_id'] 		  	= $entity_id;
	// 				$data16['value'] 		  		= 1;
	// 				$this->m_catalog_product_entity->catalog_product_entity_int($data16);

	// 				$data16['attribute_id'] 		= 134;
	// 				$data16['store_id'] 		  	= 0;
	// 				$data16['entity_id'] 		  	= $entity_id;
	// 				$data16['value'] 		  		= 0;
	// 				$this->m_catalog_product_entity->catalog_product_entity_int($data16);


	// 				//catalog_product_entity_media_gallery_value
	// 				$gambar1							= '/1/-/1-'.$worksheet->getCellByColumnAndRow(1, $row)->getValue();
	// 				$gambar2							= '/1/-/1-'.$worksheet->getCellByColumnAndRow(2, $row)->getValue();
	// 				$gambar3							= '/1/-/1-'.$worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$gambar4							= '/1/-/1-'.$worksheet->getCellByColumnAndRow(4, $row)->getValue();
	// 				$gambar5							= '/1/-/1-'.$worksheet->getCellByColumnAndRow(5, $row)->getValue();

	// 					//gambar1
	// 					$data17['attribute_id'] 			= 90;
	// 					$data17['value'] 		  			= $gambar1;
	// 					$data17['media_type']  			  	= 'image';
	// 					$data17['disabled'] 	  			= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data17);
	// 					$kode1 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar1);

	// 					$data18['value_id'] 				= $kode1;
	// 					$data18['store_id'] 		  		= 0;
	// 					$data18['entity_id'] 		  		= $entity_id;
	// 					$data18['label'] 		  			= '';
	// 					$data18['position'] 		  		= 0;
	// 					$data18['disabled'] 		  		= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data18);

	// 					$data19['value_id'] 				= $kode1;
	// 					$data19['entity_id'] 		  		= $entity_id;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data19);

	// 					//gambar2
	// 					$data20['attribute_id'] 			= 90;
	// 					$data20['value'] 		  			= $gambar2;
	// 					$data20['media_type']  			  	= 'image';
	// 					$data20['disabled'] 	  			= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data20);
	// 					$kode2 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar2);

	// 					$data21['value_id'] 				= $kode2;
	// 					$data21['store_id'] 		  		= 0;
	// 					$data21['entity_id'] 		  		= $entity_id;
	// 					$data21['label'] 		  			= '';
	// 					$data21['position'] 		  		= 1;
	// 					$data21['disabled'] 		  		= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data21);

	// 					$data22['value_id'] 				= $kode2;
	// 					$data22['entity_id'] 		  		= $entity_id;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data22);

	// 					//gambar3
	// 					$data23['attribute_id'] 			= 90;
	// 					$data23['value'] 		  			= $gambar3;
	// 					$data23['media_type']  			  	= 'image';
	// 					$data23['disabled'] 	  			= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data23);
	// 					$kode3 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar3);

	// 					$data24['value_id'] 				= $kode3;
	// 					$data24['store_id'] 		  		= 0;
	// 					$data24['entity_id'] 		  		= $entity_id;
	// 					$data24['label'] 		  			= '';
	// 					$data24['position'] 		  		= 2;
	// 					$data24['disabled'] 		  		= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data24);

	// 					$data25['value_id'] 				= $kode3;
	// 					$data25['entity_id'] 		  		= $entity_id;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data25);

	// 					//gambar4
	// 					$data26['attribute_id'] 			= 90;
	// 					$data26['value'] 		  			= $gambar4;
	// 					$data26['media_type']  			  	= 'image';
	// 					$data26['disabled'] 	  			= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data26);
	// 					$kode4 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar4);

	// 					$data27['value_id'] 				= $kode4;
	// 					$data27['store_id'] 		  		= 0;
	// 					$data27['entity_id'] 		  		= $entity_id;
	// 					$data27['label'] 		  			= '';
	// 					$data27['position'] 		  		= 3;
	// 					$data27['disabled'] 		  		= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data27);

	// 					$data28['value_id'] 				= $kode4;
	// 					$data28['entity_id'] 		  		= $entity_id;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data28);

	// 					//gambar5
	// 					$data29['attribute_id'] 			= 90;
	// 					$data29['value'] 		  			= $gambar5;
	// 					$data29['media_type']  			  	= 'image';
	// 					$data29['disabled'] 	  			= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data29);
	// 					$kode5 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar5);

	// 					$data30['value_id'] 				= $kode5;
	// 					$data30['store_id'] 		  		= 0;
	// 					$data30['entity_id'] 		  		= $entity_id;
	// 					$data30['label'] 		  			= '';
	// 					$data30['position'] 		  		= 4;
	// 					$data30['disabled'] 		  		= 0;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data30);

	// 					$data31['value_id'] 				= $kode5;
	// 					$data31['entity_id'] 		  		= $entity_id;
	// 					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data31);


	// 				// catalog_product_entity_text
	// 				$data32['attribute_id'] 		= 76;
	// 				$data32['store_id'] 		  	= 0;
	// 				$data32['entity_id'] 		  	= $entity_id;
	// 				$data32['value'] 		  		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityText($data32);

	// 				$data33['attribute_id'] 		= 85;
	// 				$data33['store_id'] 		  	= 0;
	// 				$data33['entity_id'] 		  	= $entity_id;
	// 				$data33['value'] 		  		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityText($data33);


	// 				// catalog_product_entity_varchar
	// 				$data34['attribute_id'] 		= 73;
	// 				$data34['store_id'] 		  	= 0;
	// 				$data34['entity_id'] 		  	= $entity_id;
	// 				$data34['value'] 		  		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data34);

	// 				$data35['attribute_id'] 		= 84;
	// 				$data35['store_id'] 		  	= 0;
	// 				$data35['entity_id'] 		  	= $entity_id;
	// 				$data35['value'] 		  		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data35);

	// 				$data36['attribute_id'] 		= 86;
	// 				$data36['store_id'] 		  	= 0;
	// 				$data36['entity_id'] 		  	= $entity_id;
	// 				$data36['value'] 		  		= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data36);

	// 				$data36['attribute_id'] 		= 87;
	// 				$data36['store_id'] 		  	= 0;
	// 				$data36['entity_id'] 		  	= $entity_id;
	// 				$data36['value'] 		  		= $gambar1;
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data36);

	// 				$data37['attribute_id'] 		= 88;
	// 				$data37['store_id'] 		  	= 0;
	// 				$data37['entity_id'] 		  	= $entity_id;
	// 				$data37['value'] 		  		= $gambar1;
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data37);

	// 				$data38['attribute_id'] 		= 89;
	// 				$data38['store_id'] 		  	= 0;
	// 				$data38['entity_id'] 		  	= $entity_id;
	// 				$data38['value'] 		  		= $gambar1;
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data38);

	// 				$data39['attribute_id'] 		= 106;
	// 				$data39['store_id'] 		  	= 0;
	// 				$data39['entity_id'] 		  	= $entity_id;
	// 				$data39['value'] 		  		= 'container2';
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data39);

	// 				$url = $worksheet->getCellByColumnAndRow(3, $row)->getValue().'-'.$entity_id.''.$worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data40['attribute_id'] 		= 119;
	// 				$data40['store_id'] 		  	= 0;
	// 				$data40['entity_id'] 		  	= $entity_id;
	// 				$data40['value'] 		  		= url_title($url, 'dash', true);
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data40);

	// 				$data41['attribute_id'] 		= 122;
	// 				$data41['store_id'] 		  	= 0;
	// 				$data41['entity_id'] 		  	= $entity_id;
	// 				$data41['value'] 		  		= 0;
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data41);

	// 				$data41['attribute_id'] 		= 132;
	// 				$data41['store_id'] 		  	= 0;
	// 				$data41['entity_id'] 		  	= $entity_id;
	// 				$data41['value'] 		  		= 2;
	// 				$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data41);


	// 				// catalog_product_flat_1
	// 				$color 	  = $this->m_catalog_product_entity->GetColorProduct($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 				$material = $this->m_catalog_product_entity->GetMaterialProduct($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 				$type  	  = strtolower($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 				if($type  == 'configurable'){
	// 					$gift = 2;
	// 					$hasoption = 1;
	// 					$requiredoptions = 1;
	// 					$swatchimage = '';
	// 					$visibility = 4;
	// 					$url = url_title($url, 'dash', true);
	// 				}else{
	// 					$gift = 0;
	// 					$hasoption = 0;
	// 					$requiredoptions = 0;
	// 					$swatchimage = $gambar1;
	// 					$visibility = 1;
	// 					$url = url_title($worksheet->getCellByColumnAndRow(3, $row)->getValue(), 'dash', true);
	// 				}

	// 				$data42['entity_id'] 	  		= $entity_id;
	// 				$data42['attribute_set_id'] 	= 4;
	// 				$data42['type_id']  			= strtolower($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 				$data42['color'] 	  			= $color->option_id;
	// 				$data42['color_value'] 			= $color->value;
	// 				$data42['created_at'] 			= date('Y-m-d H:i:s');
	// 				$data42['gift_message_available'] = $gift;
	// 				$data42['has_options'] 			= $hasoption;
	// 				$data42['image'] 				= $gambar1;
	// 				$data42['material'] 			= $material->option_id;
	// 				$data42['name'] 				= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data42['price'] 				= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data42['required_options'] 	= $requiredoptions;
	// 				$data42['short_description'] 	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data42['sku'] 					= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data42['small_image'] 			= $gambar1;
	// 				$data42['swatch_image'] 		= $swatchimage;
	// 				$data42['thumbnail'] 			= $gambar1;
	// 				$data42['updated_at'] 			= $date('Y-m-d H:i:s');
	// 				$data42['url_key'] 				= $url;
	// 				$data42['visibility'] 			= $visibility;
	// 				$data42['warna1'] 				= $color->option_id;
	// 				$data42['warna1_value'] 		= $color->value;
	// 				$data42['weight'] 				= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductFlat1($data42);
	// 				$this->m_catalog_product_entity->InsertcatalogProductFlat2($data42);


	// 				// catalog_product_index_price
	// 				$type  	  = strtolower($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 				if($type  == 'configurable'){
	// 					$price = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				}else{
	// 					$price = 0;
	// 				}

	// 				$data43['entity_id'] 			= $entity_id;
	// 				$data43['customer_group_id'] 	= 0;
	// 				$data43['website_id'] 		  	= 1;
	// 				$data43['tax_class_id'] 		= 0;
	// 				$data43['customer_group_id'] 	= 0;
	// 				$data43['price'] 		  		= $price;
	// 				$data43['final_price'] 		  	= $price;
	// 				$data43['min_price'] 		  	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data43['max_price'] 		  	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductIndexPrice($data43);
	// 				$this->m_catalog_product_entity->InsertcatalogProductIndexPriceReplica($data43);

	// 				$data44['entity_id'] 			= $entity_id;
	// 				$data44['customer_group_id'] 	= 1;
	// 				$data44['website_id'] 		  	= 1;
	// 				$data44['tax_class_id'] 		= 0;
	// 				$data44['customer_group_id'] 	= 0;
	// 				$data44['price'] 		  		= $price;
	// 				$data44['final_price'] 		  	= $price;
	// 				$data44['min_price'] 		  	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data44['max_price'] 		  	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductIndexPrice($data44);
	// 				$this->m_catalog_product_entity->InsertcatalogProductIndexPriceReplica($data44);

	// 				$data45['entity_id'] 			= $entity_id;
	// 				$data45['customer_group_id'] 	= 2;
	// 				$data45['website_id'] 		  	= 1;
	// 				$data45['tax_class_id'] 		= 0;
	// 				$data45['customer_group_id'] 	= 0;
	// 				$data45['price'] 		  		= $price;
	// 				$data45['final_price'] 		  	= $price;
	// 				$data45['min_price'] 		  	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data45['max_price'] 		  	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductIndexPrice($data45);
	// 				$this->m_catalog_product_entity->InsertcatalogProductIndexPriceReplica($data45);

	// 				$data46['entity_id'] 			= $entity_id;
	// 				$data46['customer_group_id'] 	= 3;
	// 				$data46['website_id'] 		  	= 1;
	// 				$data46['tax_class_id'] 		= 0;
	// 				$data46['customer_group_id'] 	= 0;
	// 				$data46['price'] 		  		= $price;
	// 				$data46['final_price'] 		  	= $price;
	// 				$data46['min_price'] 		  	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$data46['max_price'] 		  	= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 				$this->m_catalog_product_entity->InsertcatalogProductIndexPrice($data46);
	// 				$this->m_catalog_product_entity->InsertcatalogProductIndexPriceReplica($data46);


	// 				// catalog_product_relation
	// 				$sku  	  = substr($worksheet->getCellByColumnAndRow(3, $row)->getValue(), 0, -1);
	// 				$type  	  = strtolower($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 				if($type  == 'configurable'){

	// 						// catalog_product_super_attribute
	// 						$data47['product_id'] 			= $entity_id;
	// 						$data47['attribute_id'] 		= 93;
	// 						$data47['position'] 		  	= 1;
	// 						$this->m_catalog_product_entity->InsertcatalogProductSuperAttribute($data47);

	// 						$data48['product_id'] 			= $entity_id;
	// 						$data48['attribute_id'] 		= 136;
	// 						$data48['position'] 		  	= 0;
	// 						$this->m_catalog_product_entity->InsertcatalogProductSuperAttribute($data48);
	// 				}else{
	// 					$parent = $this->m_catalog_product_entity->GetCatalogProductEntity($sku);

	// 						// catalog_product_relation
	// 						$data49['parent_id'] 			= $parent->entity_id;
	// 						$data49['child_id'] 			= $entity_id;
	// 						$this->m_catalog_product_entity->InsertcatalogProductRelation($data49);

	// 						// catalog_product_super_link
	// 						$data50['product_id'] 			= $parent->entity_id;
	// 						$data50['parent_id'] 			= $entity_id;
	// 						$this->m_catalog_product_entity->InsertcatalogProductSuperLink($data50);
	// 				}


	// 				// catalog_product_website
	// 				$data51['product_id'] 			= $entity_id;
	// 				$data51['website_id'] 			= 1;
	// 				$this->m_catalog_product_entity->InsertcatalogProductWebsite($data51);


	// 				// url_rewrite
	// 				$type  	  = strtolower($worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 				if($type  == 'configurable'){
	// 					$url 	= $worksheet->getCellByColumnAndRow(3, $row)->getValue().'-'.$entity_id.''.$worksheet->getCellByColumnAndRow(3, $row)->getValue();
	// 					$pecah2 = explode(", ", $worksheet->getCellByColumnAndRow(3, $row)->getValue());
	// 					foreach($pecah2 as $i =>$key) {
	// 						$i >0;
	// 						$idcategory   = $this->m_catalog_product_entity->GetIDCatalogCategoryEntityVarchar($key);
	// 						$linkcategory = $this->m_catalog_product_entity->GetLinkCatalogCategoryEntityVarchar(strtolower($key));

	// 						$data52['entity_type'] 	  		= 'product';
	// 						$data52['entity_id'] 	  		= $entity_id;
	// 						$data52['request_path'] 	  	= $linkcategory.'/'.$url.'.html';
	// 						$data52['target_path'] 	  		= 'catalog/product/view/id/'.$entity_id.'category/'.$idcategory;
	// 						$data52['redirect_type'] 	  	= 0;
	// 						$data52['store_id'] 	  		= 1;
	// 						$data52['is_autogenerated'] 	= 1;
	// 						$data52['metadata'] 	  		= '{"category_id":"'.$idcategory.'"}';
	// 						$this->m_catalog_product_entity->InsertUrlRewrite($data52);
	// 						$idrewrite = $this->m_catalog_product_entity->GetCatalog('catalog/product/view/id/'.$entity_id.'category/'.$idcategory);

	// 						// catalog_product_website
	// 						$data53['url_rewrite_id'] 		= $idrewrite;
	// 						$data53['category_id'] 			= $idcategory;
	// 						$data53['product_id'] 			= $entity_id;
	// 						$this->m_catalog_product_entity->InsertcatalogUrlRewriteProductCategory($data53);
	// 					}
	// 				}





	// 			}
	// 		}
	//        	redirect(base_url().'backend/uploadproduct');
	// 	}	
 // 	}	








































































 <?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_catalog_product_entity extends CI_Model {
    protected $table = array('1' => 'catalog_product_entity','2' => 'cataloginventory_stock_cl','3' => 'cataloginventory_stock_item',
        '4' => 'cataloginventory_stock_status_replica','5' => 'catalogrule_product_cl','6' => 'catalogsearch_fulltext_cl','7' => 'catalogsearch_fulltext_scope1',
        '8' => 'catalogsearch_fulltext_scope2','9' => 'catalog_category_product','10' => 'catalog_category_product_index','11' => 'catalog_product_attribute_cl',
        '12' => 'catalog_product_category_cl','13' => 'catalog_product_entity_decimal','14' => 'catalog_product_entity_text','15' => 'catalog_product_entity_int',
        '16' => 'catalog_product_entity_media_gallery','17' => 'catalog_product_entity_media_gallery_value',
        '18' => 'catalog_product_entity_media_gallery_value_to_entity','19' => 'catalog_product_entity_varchar','20' => 'catalog_product_flat_1',
        '21' => 'catalog_product_flat_2','22' => 'catalog_product_index_price','23' => 'catalog_product_index_price_replica','24' => 'catalog_product_relation',
        '25' => 'catalog_product_super_attribute','26' => 'catalog_product_super_link','27' => 'catalog_product_website','28' => 'url_rewrite',
        '29' => 'catalog_url_rewrite_product_category','42' => 'catalog_category_flat_store_1','43' => 'eav_attribute_option_value',
        '44' => 'catalog_category_entity_varchar','45' => 'cataloginventory_stock_status','46' => 'catalog_category_product_index_tmp',
        '47' => 'catalog_product_entity_datetime');

    public function __construct(){
      parent::__construct();
    }

    //backend
    public function InsertCatalogProductEntity($data) {
        $data = $this->db->insert_batch($this->table[1], $data);
        return $data;
    }

    public function GetCatalogProductEntity($sku){      
        $this->db->select('entity_id');
        $this->db->from($this->table[1]);
        $this->db->where('sku', $sku);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertCatalogInventoryStock($data) {
        $data = $this->db->insert_batch($this->table[2], $data);
        return $data;
    }

    public function InsertCatalogInventoryStockItem($data) {
        $data = $this->db->insert_batch($this->table[3], $data);
        return $data;
    }

    public function InsertcatalogInventoryStockStatus($data) {
        $data = $this->db->insert_batch($this->table[45], $data);
        return $data;
    }

    public function InsertcatalogCategoryProductTmp($data) {
        $data = $this->db->insert_batch($this->table[46], $data);
        return $data;
    }

    public function InsertcatalogProdukDateTime($data) {
        $data = $this->db->insert_batch($this->table[47], $data);
        return $data;
    }

    public function InsertcatalogInventoryStockStatusReplica($data) {
        $data = $this->db->insert_batch($this->table[4], $data);
        return $data;
    }

    public function InsertcatalogruleProductCl($data) {
        $data = $this->db->insert_batch($this->table[5], $data);
        return $data;
    }

    public function InsertcatalogSearchFulltextCl($data) {
        $data = $this->db->insert_batch($this->table[6], $data);
        return $data;
    }

    public function InsertcatalogSearchFulltextScope1($data) {
        $data = $this->db->insert_batch($this->table[7], $data);
        return $data;
    }

    public function InsertcatalogSearchFulltextScope2($data) {
        $data = $this->db->insert_batch($this->table[8], $data);
        return $data;
    }

    public function InsertcatalogCategoryProduct($data) {
        $data = $this->db->insert_batch($this->table[9], $data);
        return $data;
    }

    public function GetCatalogProduct($id){      
        $this->db->select('entity_id');
        $this->db->from($this->table[42]);
        $this->db->where('name', $id);
        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogCategoryProductIndex($data) {
        $data = $this->db->insert_batch($this->table[10], $data);
        return $data;
    }

    public function InsertcatalogProductAttributeCl($data) {
        $data = $this->db->insert_batch($this->table[11], $data);
        return $data;
    }

    public function InsertcatalogProductCategoryCl($data) {
        $data = $this->db->insert_batch($this->table[12], $data);
        return $data;
    }

    public function InsertcatalogProductEntityDecimal($data) {
        $data = $this->db->insert_batch($this->table[13], $data);
        return $data;
    }

    public function InsertcatalogProductEntityText($data) {
        $data = $this->db->insert_batch($this->table[14], $data);
        return $data;
    }

    public function GetColorProduct($id){      
        $this->db->select('option_id');
        $this->db->from($this->table[43]);
        $this->db->where('value', $id);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogProductEntityInt($data) {
        $data = $this->db->insert_batch($this->table[15], $data);
        return $data;
    }

    public function InsertcatalogProductEntityMediaGallery($data) {
        $data = $this->db->insert_batch($this->table[16], $data);
        return $data;
    }

    public function GetCatalogProductEntityMediaGallery($sku){      
        $this->db->select('value_id');
        $this->db->from($this->table[16]);
        $this->db->where('value', $sku);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogProductEntityMediaGalleryValue($data) {
        $data = $this->db->insert_batch($this->table[17], $data);
        return $data;
    }

    public function InsertcatalogProductEntityMediaGalleryValueToEntity($data) {
        $data = $this->db->insert_batch($this->table[18], $data);
        return $data;
    }

    public function InsertcatalogProductEntityVarchar($data) {
        $data = $this->db->insert_batch($this->table[19], $data);
        return $data;
    }

    public function GetMaterialProduct($id){      
        $this->db->select('option_id');
        $this->db->from($this->table[43]);
        $this->db->where('value', $id);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogProductFlat1($data) {
        $data = $this->db->insert_batch($this->table[20], $data);
        return $data;
    }

    public function InsertcatalogProductFlat2($data) {
        $data = $this->db->insert_batch($this->table[21], $data);
        return $data;
    }

    public function InsertcatalogProductIndexPrice($data) {
        $data = $this->db->insert_batch($this->table[22], $data);
        return $data;
    }

    public function InsertcatalogProductIndexPriceReplica($data) {
        $data = $this->db->insert_batch($this->table[23], $data);
        return $data;
    }

    public function InsertcatalogProductRelation($data) {
        $data = $this->db->insert_batch($this->table[24], $data);
        return $data;
    }

    public function InsertcatalogProductSuperAttribute($data) {
        $data = $this->db->insert_batch($this->table[25], $data);
        return $data;
    }

    public function InsertcatalogProductSuperLink($data) {
        $data = $this->db->insert_batch($this->table[26], $data);
        return $data;
    }

    public function InsertcatalogProductWebsite($data) {
        $data = $this->db->insert_batch($this->table[27], $data);
        return $data;
    }

    public function GetLinkCatalogCategoryEntityVarchar($id){      
        $this->db->select('value');
        $this->db->from($this->table[44]);
        $this->db->where('value', $id);
        $this->db->where('attribute_id', 117);

        $data = $this->db->get()->row();
        return $data;
    }

    public function GetIDCatalogCategoryEntityVarchar($id){      
        $this->db->select('entity_id');
        $this->db->from($this->table[44]);
        $this->db->where('value', $id);
        $this->db->where('attribute_id', 45);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertUrlRewrite($data) {
        $data = $this->db->insert_batch($this->table[28], $data);
        return $data;
    }

    public function GetCatalog($id){      
        $this->db->select('url_rewrite_id');
        $this->db->from($this->table[28]);
        $this->db->where('request_path', $id);

        $data = $this->db->get()->row();
        return $data;
    }

    public function InsertcatalogUrlRewriteProductCategory($data) {
        $data = $this->db->insert_batch($this->table[29], $data);
        return $data;
    }

}