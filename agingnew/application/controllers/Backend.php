<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	  	$this->load->model(array('m_user', 'm_catalog_category_product', 'm_cataloginventory_stock_item', 'm_catalog_product_index_price', 'm_catalog_product_entity_decimal','m_catalog_product_entity','m_sales_order_item', 'm_sales_order_grid'));
		$this->load->library('upload');
		$this->load->library('excel');
		$this->load->helper('string');
	}

	//login
	public function login(){
		$data['title'] = 'CMS Login - '.BRAND;

		$this->load->view('login', $data);
	}

	public function login_act() {
	    if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('user', 'User', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('pass', 'Password', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			if($this->form_validation->run() == false){
	            $this->session->set_flashdata('warning', 'Maaf, validasi anda salah!');
	          	redirect(base_url().'login');
		  	} else { 		

		  		$user 	= $this->input->post('user');
		  		$pass 	= md5($this->input->post('pass'));
		  		$where 	= array(
				    'ausername' => $user,
				    'apassword' => $pass
			    );
		  		$this->load->model('m_user');
				$cek = $this->m_user->cek_login($where)->num_rows();

				if($cek > 0){
					$data = $this->m_user->data_login($user,$pass);
					$data_session = array(
						'id' 		=> $data->aid,
						'name' 		=> $data->aname,
						'role' 		=> $data->arole,
						'status' 	=> "backend"
			    	);
				    $this->session->set_userdata($data_session);
					redirect(base_url('backend'));
				}else{
		            $this->session->set_flashdata('warning', 'Maaf, anda gagal login!');
					redirect(base_url('login'));
				}
			}
		}
	}

	public function changepass() {
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		$data['title'] = 'Halaman Administrator - '.BRAND;
		$data['page']  = 'backend/general/cpass';
		$this->load->view('backend/thamplate', $data);
	}

	public function changepass_act(){
 	 	if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('pass', 'Password', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('kpass', 'Confirmation Password', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			if($this->form_validation->run() == false){
	            $this->session->set_flashdata('warning', 'Sorry, your validation failed!');
				redirect($_SERVER['HTTP_REFERER']);
		  	} else { 		
		  	if($this->input->post('pass') != $this->input->post('kpass')){
	            $this->session->set_flashdata('warning', 'Sorry, The password must be the same as the password confirmation!');
				redirect($_SERVER['HTTP_REFERER']);
		  	}
				$id	  				= $this->input->post('id');
				$data['upass'] 		= md5($this->input->post('pass'));

	  	 		$this->m_user->EditUser($id, $data);	
	       		redirect(base_url().'backend');
		  	}
	    }
	}

 	public function adduser(){
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		
		$data['title'] = 'Tambah User Access - '.BRAND;
		$data['page']  = 'backend/user/add';
		$this->load->view('backend/thamplate', $data);		
 	}

 	public function adduser_act(){
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('name', 'Nama', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('username', 'Username', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('pass', 'Password', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('deskripsi', 'Alamat', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('role', 'Role', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			if($this->form_validation->run() == false){
	            $this->session->set_flashdata('warning', 'Maaf, validasi anda gagal!');
				redirect(base_url().'backend/adduser');
		  	} else { 		
				$data['aname']  	= $this->input->post('name');
				$data['ausername'] 	= $this->input->post('username');
				$data['apassword'] 	= md5($this->input->post('pass'));
				$data['aemail'] 	= $this->input->post('email');
				$data['adesc'] 		= $this->input->post('deskripsi');
				$data['arole'] 		= $this->input->post('role');
				$data['astatus'] 	= 1;
				$data['adate'] 		= date('Y-m-d H:i:s');

	  	 		$this->m_user->SaveUser($data);	
	       		redirect(base_url().'backend/edituser/'.$this->session->userdata('id'));
		  	}
	    }
 	}

	public function edituser($id){
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
 		$data['detail'] = $this->m_user->DetailUser($id);

 		$data['title'] = 'Edit User Access - '.BRAND;
 		$data['page']  = 'backend/user/edit';
 		$this->load->view('backend/thamplate', $data);

 	}

 	public function edituser_act(){
 	 	if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		if (isset($_POST['submit'])) {
			$this->form_validation->set_rules('name', 'Nama', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('username', 'Username', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('pass', 'Password', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('deskripsi', 'Alamat', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			$this->form_validation->set_rules('role', 'Role', 'required|htmlspecialchars|strip_image_tags|encode_php_tags');
			if($this->form_validation->run() == false){
	            $this->session->set_flashdata('warning', 'Maaf, validasi anda gagal!');
				redirect($_SERVER['HTTP_REFERER']);
		  	} else { 		
				$id	  				= $this->input->post('id');
				$data['aname']		= $this->input->post('name');
				$data['ausername']	= $this->input->post('username');
				$data['apassword'] 	= md5($this->input->post('pass'));
				$data['aemail'] 	= $this->input->post('email');
				$data['adesc'] 		= $this->input->post('deskripsi');
				$data['arole'] 		= $this->input->post('role');
				$data['astatus'] 	= 1;
				$data['adate'] 		= date('Y-m-d H:i:s');

		        if(!empty($_FILES['foto']['name'])) {
		  			$data['aimage'] 	= $this->upload('foto');
		        }
	  	 		$this->m_user->EditUser($id, $data);	
	       		redirect(base_url().'backend/edituser/'.$this->session->userdata('id'));
		  	}
	    }
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect(base_url('login'));
	}


	//backend
	public function index(){
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		//count
		$data['countcomplete'] 	    = $this->m_sales_order_grid->CountComplete();
		$data['countrevenue'] 	    = $this->m_sales_order_grid->CountRevenue();
		$data['countsubscriber'] 	= $this->m_sales_order_grid->CountSubscriber();
		$data['countshipping'] 	    = $this->m_sales_order_grid->CountShipping();
        
        //tasks
		$data['taskscomplete'] 	    = $this->m_sales_order_item->Taskscomplete();
		$data['taskspcr'] 	    	= $this->m_sales_order_item->Taskspcr();
		$data['taskspreparation'] 	= $this->m_sales_order_item->Taskspreparation();
		$data['tasksdelivery'] 	    = $this->m_sales_order_item->Tasksondelivery();
		$data['taskspending'] 	    = $this->m_sales_order_item->Taskspending();
        
		$data['title'] = 'Dashboard - '.BRAND;
		$data['page']  = 'backend/page/home';
		$this->load->view('backend/thamplate', $data);
	}

	//mass upload category
	public function uploadcategory(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		$data['title'] = 'Mass Upload Category - '.BRAND;
		$data['page']  = 'backend/massupload/uploadcategory';
		$this->load->view('backend/thamplate', $data); 
 	}

	public function uploadcategory_act(){
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		if(isset($_FILES["file"]["name"])) {
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet) {

				$highestRow 	= $worksheet->getHighestRow();
				$highestColumn 	= $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++) {


				$data2['category_id'] 	= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				$data2['product_id'] 	= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				$data2['position'] 		= 0;
				$this->m_catalog_category_product->InsertCatalog($data2);
				}
			}
	       	redirect(base_url().'backend/uploadcategory');
		}	
 	}

	//mass upload stock
	public function uploadstock(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		$data['title'] = 'Mass Upload Stock - '.BRAND;
		$data['page']  = 'backend/massupload/uploadstock';
		$this->load->view('backend/thamplate', $data); 
 	}

	public function uploadstock_act(){
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		if(isset($_FILES["file"]["name"])) {
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet) {

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++) {
					if($worksheet->getCellByColumnAndRow(1, $row)->getValue() == 0){ 
						$status = 0;
					}else{ 
						$status = 1;
					}

					$id 			= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$data['qty']  		= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$data['is_in_stock'] 	= $status;
					$this->m_cataloginventory_stock_item->InsertStock($id, $data);

					// $id2 			= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					// $data2['price']  		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					// $data2['final_price'] 	= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					// $data2['min_price'] 		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					// $data2['max_price'] 		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					// $data2['tier_price'] 	= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					// $this->m_catalog_product_index_price->InsertStock($id2, $data2);

					// $id3 			= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					// $data3['value']  		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					// $this->m_catalog_product_entity_decimal->InsertStock($id3, $data3);
				}
			}
	       	redirect(base_url().'backend/uploadstock');
		}	
 	}	


 	//mass upload category
	public function deletecategory(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		$data['title'] = 'Mass Update Delete Product In Category - '.BRAND;
		$data['page']  = 'backend/massupload/deletecategory';
		$this->load->view('backend/thamplate', $data); 
 	}

	public function deletecategory_act(){
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		if(isset($_FILES["file"]["name"])) {
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet) {

				$highestRow 	= $worksheet->getHighestRow();
				$highestColumn 	= $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++) {
					$idproduct 	= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$idcategory = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

					$this->m_catalog_category_product->DeleteCatalog($idproduct, $idcategory);
				}
			}
	       	redirect(base_url().'backend/deletecategory');
		}	
 	}





	//mass upload product
	public function uploadproduct(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		$data['title'] = 'Mass Upload Product - '.BRAND;
		$data['page']  = 'backend/massupload/uploadproduct';
		$this->load->view('backend/thamplate', $data); 
 	}


	public function uploadproduct_act(){
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		if(isset($_FILES["file"]["name"])) {
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet) {

				$highestRow 	= $worksheet->getHighestRow();
				$highestColumn 	= $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++) {

					if($worksheet->getCellByColumnAndRow(4, $row)->getValue() == 'CONFIGURABLE'){ 
						$qtystock    = 0;
						$statconfig  = 1;
						$statusstock = 0;
					}else{ 
						$qtystock    = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
						$statconfig  = 0;
						$statusstock = 1;
					}

					// catalog_product_entity
					$data1['attribute_set_id'] 			= 4;
					$data1['type_id'] 		  		= strtolower($worksheet->getCellByColumnAndRow(4, $row)->getValue());
					$data1['sku']  			  		= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$data1['has_options'] 	  			= $statconfig;
					$data1['required_options'] 			= $statconfig;
					$data1['created_at'] 	  			= date('Y-m-d H:i:s');
					$data1['updated_at'] 	  			= date('Y-m-d H:i:s');
					$this->m_catalog_product_entity->InsertCatalogProductEntity($data1);
					$entity_id = $this->m_catalog_product_entity->GetCatalogProductEntity($worksheet->getCellByColumnAndRow(0, $row)->getValue())->entity_id;
					
					// cataloginventory_stock_cl
					if($worksheet->getCellByColumnAndRow(4, $row)->getValue() == 'CONFIGURABLE'){ 

						$data2['entity_id'] 	  			= $entity_id;							
						$this->m_catalog_product_entity->InsertCatalogInventoryStock($data2);
					}

					// cataloginventory_stock_item
					$data3['product_id'] 	  			= $entity_id;
					$data3['stock_id'] 		  		= 1;
					$data3['qty']  			  		= $qtystock;
					$data3['min_qty'] 	  			= 0;
					$data3['use_config_min_qty'] 			= 1;
					$data3['is_qty_decimal'] 	  		= 0;
					$data3['backorders'] 	  			= 0;
					$data3['use_config_backorders'] 		= 1;
					$data3['min_sale_qty'] 	  			= 1;
					$data3['use_config_min_sale_qty'] 		= 1;
					$data3['max_sale_qty'] 	  			= 10000;
					$data3['use_config_max_sale_qty'] 		= 1;
					$data3['is_in_stock'] 	  			= 1;
					$data3['notify_stock_qty'] 	  		= 1;
					$data3['use_config_notify_stock_qty'] 		= 1;
					$data3['manage_stock'] 	  			= 1;
					$data3['use_config_manage_stock'] 		= 1;
					$data3['stock_status_changed_auto'] 		= 0;
					$data3['use_config_qty_increments'] 		= 1;
					$data3['qty_increments'] 	  		= 1;
					$data3['use_config_enable_qty_inc'] 		= 1;
					$data3['enable_qty_increments'] 		= 0;
					$data3['is_decimal_divided'] 	  		= 0;
					$data3['website_id'] 	  			= 0;
					$this->m_catalog_product_entity->InsertCatalogInventoryStockItem($data3);

					// cataloginventory_stock_status
					$data4['product_id'] 	  			= $entity_id;
					$data4['website_id'] 		  		= 0;
					$data4['stock_id']  			  	= 1;
					$data4['qty'] 	  				= strtolower($worksheet->getCellByColumnAndRow(11, $row)->getValue());
					$data4['stock_status'] 				= 1;
					$this->m_catalog_product_entity->InsertcatalogInventoryStockStatus($data4);


					// cataloginventory_stock_status_replica
					$data5['product_id'] 	  			= $entity_id;
					$data5['website_id'] 		  		= 0;
					$data5['stock_id']  			  	= 1;
					$data5['qty'] 	  				= strtolower($worksheet->getCellByColumnAndRow(11, $row)->getValue());
					$data5['stock_status'] 				= 1;
					$this->m_catalog_product_entity->InsertcatalogInventoryStockStatusReplica($data5);

					// catalogsearch_fulltext_scope1
					$data6['entity_id'] 	  			= $entity_id;
					$data6['attribute_id'] 		  		= 73;
					$data6['data_index']  			  	= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogSearchFulltextScope1($data6);

					$data61['entity_id'] 	  			= $entity_id;
					$data61['attribute_id'] 		  	= 74;
					$data61['data_index']  			  	= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogSearchFulltextScope1($data61);

					$data62['entity_id'] 	  			= $entity_id;
					$data62['attribute_id'] 		  	= 76;
					$data62['data_index']  			  	= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogSearchFulltextScope1($data62);

					// catalogsearch_fulltext_scope2
					$data7['entity_id'] 	  			= $entity_id;
					$data7['attribute_id'] 		  		= 73;
					$data7['data_index']  			  	= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogSearchFulltextScope2($data7);

					$data71['entity_id'] 	  			= $entity_id;
					$data71['attribute_id'] 		  	= 74;
					$data71['data_index']  			  	= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogSearchFulltextScope2($data71);

					$data72['entity_id'] 	  			= $entity_id;
					$data72['attribute_id'] 		  	= 76;
					$data72['data_index']  			  	= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogSearchFulltextScope2($data72);

					// catalog_category_product
				    $pecah = explode(",", $worksheet->getCellByColumnAndRow(3, $row)->getValue());
				    foreach($pecah as $i =>$key) {
						$i > 0;
						$category = $this->m_catalog_product_entity->GetCatalogProduct($key);

						$data8['category_id'] 	  		= $key;
						$data8['product_id'] 	  		= $entity_id;
						$data8['position'] 	  			= 0;
						$this->m_catalog_product_entity->InsertcatalogCategoryProduct($data8);

						//catalog_category_product_index_tmp
						$data9['category_id'] 	  		= $key;
						$data9['product_id'] 	  		= $entity_id;
						$data9['position'] 	  		= 0;
						$data9['is_parent'] 	  		= 1;
						$data9['store_id'] 	  		= 2;
						$data9['visibility'] 	  		= 4;
						$this->m_catalog_product_entity->InsertcatalogCategoryProductTmp($data9);

						if($worksheet->getCellByColumnAndRow(4, $row)->getValue() == 'CONFIGURABLE'){ 
							// catalog_category_product_index
							$data10['category_id'] 	  		= $key;
							$data10['product_id'] 		  	= $entity_id;
							$data10['position']  			= 0;
							$data10['is_parent'] 	  		= 1;
							$data10['store_id'] 			= 1;
							$data10['visibility'] 			= 4;
							$this->m_catalog_product_entity->InsertcatalogCategoryProductIndex($data10);
						}
						if($worksheet->getCellByColumnAndRow(4, $row)->getValue() == 'CONFIGURABLE'){ 
							// catalog_category_product_index
							$data11['category_id'] 	  		= $key;
							$data11['product_id'] 		  	= $entity_id;
							$data11['position']  			= 0;
							$data11['is_parent'] 	  		= 1;
							$data11['store_id']			= 2;
							$data11['visibility'] 			= 4;
							$this->m_catalog_product_entity->InsertcatalogCategoryProductIndex($data11);
						}
					}					

					// catalog_category_product_index
					$data12['category_id'] 	  		= 3;
					$data12['product_id'] 		  	= $entity_id;
					$data12['position']  			= 10000;
					$data12['is_parent'] 	  		= 0;
					$data12['store_id']			= 1;
					$data12['visibility'] 			= 4;
					$this->m_catalog_product_entity->InsertcatalogCategoryProductIndex($data12);

					// catalog_category_product_index
					$data13['category_id'] 	  		= 3;
					$data13['product_id'] 		  	= $entity_id;
					$data13['position']  			= 10000;
					$data13['is_parent'] 	  		= 0;
					$data13['store_id']			= 2;
					$data13['visibility'] 			= 4;
					$this->m_catalog_product_entity->InsertcatalogCategoryProductIndex($data13);

					// catalog_product_entity_datetime
					$data14['attribute_id'] 		= 164;
					$data14['store_id']  			= 0;
					$data14['entity_id'] 	  		= $entity_id;
					$data14['value']			= date('Y-m-d H:i:s');
					$this->m_catalog_product_entity->InsertcatalogProdukDateTime($data14);

					if($worksheet->getCellByColumnAndRow(4, $row)->getValue() == 'CONFIGURABLE'){ 
						// catalog_product_entity_decimal
						$dataa15['attribute_id'] 		= 78;
						$dataa15['store_id'] 		  	= 0;
						$dataa15['entity_id'] 		  	= $entity_id;
						$this->m_catalog_product_entity->InsertcatalogProductEntityDecimal($dataa15);		
					}else{
						// catalog_product_entity_decimal
						$dataa15['attribute_id'] 		= 77;
						$dataa15['store_id'] 		  	= 0;
						$dataa15['entity_id'] 		  	= $entity_id;
						$dataa15['value'] 		  	= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						$this->m_catalog_product_entity->InsertcatalogProductEntityDecimal($dataa15);				
					}

					$data155['attribute_id'] 		= 82;
					$data155['store_id'] 		  	= 0;
					$data155['entity_id'] 		  	= $entity_id;
					$data155['value'] 		  	= $worksheet->getCellByColumnAndRow(10, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductEntityDecimal($data155);

					if($worksheet->getCellByColumnAndRow(4, $row)->getValue() == 'CONFIGURABLE'){ 
						// // catalog_product_entity_int
						$data17['attribute_id']			= 97;
						$data17['store_id'] 		  	= 0;
						$data17['entity_id'] 		  	= $entity_id;
						$data17['value'] 		  	= 1;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data17);

						$data18['attribute_id'] 		= 99;
						$data18['store_id'] 		  	= 0;
						$data18['entity_id'] 		  	= $entity_id;
						$data18['value'] 		  	= 4;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data18);

						$data19['attribute_id'] 		= 115;
						$data19['store_id'] 		  	= 0;
						$data19['entity_id'] 		  	= $entity_id;
						$data19['value'] 		  	= 1;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data19);

						$data20['attribute_id'] 		= 134;
						$data20['store_id'] 		  	= 0;
						$data20['entity_id'] 		  	= $entity_id;
						$data20['value'] 		  	= 0;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data20);
					}else{					
						// // catalog_product_entity_int
						$data16['attribute_id'] 		= 93;
						$data16['store_id'] 		  	= 0;
						$data16['entity_id'] 		  	= $entity_id;
						$data16['value'] = $this->m_catalog_product_entity->GetColorProduct($worksheet->getCellByColumnAndRow(12, $row)->getValue())->option_id;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data16);

						$data17['attribute_id']			= 97;
						$data17['store_id'] 		  	= 0;
						$data17['entity_id'] 		  	= $entity_id;
						$data17['value'] 		  	= 1;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data17);

						$data18['attribute_id'] 		= 99;
						$data18['store_id'] 		  	= 0;
						$data18['entity_id'] 		  	= $entity_id;
						$data18['value'] 		  	= 1;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data18);

						$data19['attribute_id'] 		= 115;
						$data19['store_id'] 		  	= 0;
						$data19['entity_id'] 		  	= $entity_id;
						$data19['value'] 		  	= 1;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data19);

						$data20['attribute_id'] 		= 134;
						$data20['store_id'] 		  	= 0;
						$data20['entity_id'] 		  	= $entity_id;
						$data20['value'] 		  	= 0;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data20);

						$data200['attribute_id'] 		= 136;
						$data200['store_id'] 		  	= 0;
						$data200['entity_id'] 		  	= $entity_id;
						$data200['value'] = $this->m_catalog_product_entity->GetColorProduct($worksheet->getCellByColumnAndRow(13, $row)->getValue())->option_id;
						$this->m_catalog_product_entity->InsertcatalogProductEntityInt($data200);
					}

					// //catalog_product_entity_media_gallery_value
					$gambar1						= '/w/t/'.$worksheet->getCellByColumnAndRow(15, $row)->getValue();
					$gambar2						= '/w/t/'.$worksheet->getCellByColumnAndRow(16, $row)->getValue();
					$gambar3						= '/w/t/'.$worksheet->getCellByColumnAndRow(17, $row)->getValue();
					$gambar4						= '/w/t/'.$worksheet->getCellByColumnAndRow(18, $row)->getValue();
					$gambar5						= '/w/t/'.$worksheet->getCellByColumnAndRow(19, $row)->getValue();

					//gambar1
					$data21['attribute_id'] 			= 90;
					$data21['value'] 		  			= $gambar1;
					$data21['media_type']  			  	= 'image';
					$data21['disabled'] 	  			= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data21);
					$kode1 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar1);

					$data22['value_id'] 				= $kode1->value_id;
					$data22['store_id'] 		  		= 0;
					$data22['entity_id'] 		  		= $entity_id;
					$data22['label'] 		  			= NULL;
					$data22['position'] 		  		= 5;
					$data22['disabled'] 		  		= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data22);

					$data23['value_id'] 				= $kode1->value_id;
					$data23['entity_id'] 		  		= $entity_id;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data23);

					//gambar2
					$data24['attribute_id'] 			= 90;
					$data24['value'] 		  			= $gambar2;
					$data24['media_type']  			  	= 'image';
					$data24['disabled'] 	  			= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data24);
					$kode2 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar2);

					$data25['value_id'] 				= $kode2->value_id;
					$data25['store_id'] 		  		= 0;
					$data25['entity_id'] 		  		= $entity_id;
					$data25['label'] 		  			= NULL;
					$data25['position'] 		  		= 6;
					$data25['disabled'] 		  		= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data25);

					$data26['value_id'] 				= $kode2->value_id;
					$data26['entity_id'] 		  		= $entity_id;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data26);

					//gambar3
					$data27['attribute_id'] 			= 90;
					$data27['value'] 		  			= $gambar3;
					$data27['media_type']  			  	= 'image';
					$data27['disabled'] 	  			= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data27);
					$kode3 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar3);

					$data28['value_id'] 				= $kode3->value_id;
					$data28['store_id'] 		  		= 0;
					$data28['entity_id'] 		  		= $entity_id;
					$data28['label'] 		  			= NULL;
					$data28['position'] 		  		= 7;
					$data28['disabled'] 		  		= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data28);

					$data29['value_id'] 				= $kode3->value_id;
					$data29['entity_id'] 		  		= $entity_id;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data29);

					//gambar4
					$data30['attribute_id'] 			= 90;
					$data30['value'] 		  			= $gambar4;
					$data30['media_type']  			  	= 'image';
					$data30['disabled'] 	  			= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data30);
					$kode4 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar4);

					$data31['value_id'] 				= $kode4->value_id;
					$data31['store_id'] 		  		= 0;
					$data31['entity_id'] 		  		= $entity_id;
					$data31['label'] 		  			= NULL;
					$data31['position'] 		  		= 8;
					$data31['disabled'] 		  		= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data31);

					$data32['value_id'] 				= $kode4->value_id;
					$data32['entity_id'] 		  		= $entity_id;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data32);

					//gambar5
					$data33['attribute_id'] 			= 90;
					$data33['value'] 		  			= $gambar5;
					$data33['media_type']  			  	= 'image';
					$data33['disabled'] 	  			= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGallery($data33);
					$kode5 = $this->m_catalog_product_entity->GetCatalogProductEntityMediaGallery($gambar5);

					$data34['value_id'] 				= $kode5->value_id;
					$data34['store_id'] 		  		= 0;
					$data34['entity_id'] 		  		= $entity_id;
					$data34['label'] 		  			= NULL;
					$data34['position'] 		  		= 9;
					$data34['disabled'] 		  		= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValue($data34);

					$data35['value_id'] 				= $kode5->value_id;
					$data35['entity_id'] 		  		= $entity_id;
					$this->m_catalog_product_entity->InsertcatalogProductEntityMediaGalleryValueToEntity($data35);

					// catalog_product_entity_text
					$data36['attribute_id'] 		= 76;
					$data36['store_id'] 		  	= 0;
					$data36['entity_id'] 		  	= $entity_id;
					$data36['value'] 		  		= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductEntityText($data36);

					$data37['attribute_id'] 		= 85;
					$data37['store_id'] 		  	= 0;
					$data37['entity_id'] 		  	= $entity_id;
					$data37['value'] 		  		= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductEntityText($data37);


					// catalog_product_entity_varchar
					$data38['attribute_id'] 		= 73;
					$data38['store_id'] 		  	= 0;
					$data38['entity_id'] 		  	= $entity_id;
					$data38['value'] 		  		= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data38);

					$data39['attribute_id'] 		= 84;
					$data39['store_id'] 		  	= 0;
					$data39['entity_id'] 		  	= $entity_id;
					$data39['value'] 		  		= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data39);

					$data40['attribute_id'] 		= 86;
					$data40['store_id'] 		  	= 0;
					$data40['entity_id'] 		  	= $entity_id;
					$data40['value'] 		  		= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data40);

					$data41['attribute_id'] 		= 87;
					$data41['store_id'] 		  	= 0;
					$data41['entity_id'] 		  	= $entity_id;
					$data41['value'] 		  		= $gambar1;
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data41);

					$data42['attribute_id'] 		= 88;
					$data42['store_id'] 		  	= 0;
					$data42['entity_id'] 		  	= $entity_id;
					$data42['value'] 		  		= $gambar1;
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data42);

					$data43['attribute_id'] 		= 89;
					$data43['store_id'] 		  	= 0;
					$data43['entity_id'] 		  	= $entity_id;
					$data43['value'] 		  		= $gambar1;
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data43);

					$data44['attribute_id'] 		= 106;
					$data44['store_id'] 		  	= 0;
					$data44['entity_id'] 		  	= $entity_id;
					$data44['value'] 		  		= 'container2';
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data44);

					$url = $worksheet->getCellByColumnAndRow(1, $row)->getValue().'-'.$worksheet->getCellByColumnAndRow(2, $row)->getValue().''.$worksheet->getCellByColumnAndRow(12, $row)->getValue();
					$data45['attribute_id'] 		= 119;
					$data45['store_id'] 		  	= 0;
					$data45['entity_id'] 		  	= $entity_id;
					$data45['value'] 		  		= url_title(strtolower($url), 'dash', true);
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data45);

					$data46['attribute_id'] 		= 122;
					$data46['store_id'] 		  	= 0;
					$data46['entity_id'] 		  	= $entity_id;
					$data46['value'] 		  		= 0;
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data46);

					$data47['attribute_id'] 		= 132;
					$data47['store_id'] 		  	= 0;
					$data47['entity_id'] 		  	= $entity_id;
					$data47['value'] 		  		= 2;
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data47);

					$data48['attribute_id'] 		= 133;
					$data48['store_id'] 		  	= 0;
					$data48['entity_id'] 		  	= $entity_id;
					$data48['value'] 		  		= $gambar1;
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data48);

					$data49['attribute_id'] 	= 135;
					$data49['store_id'] 		= 0;
					$data49['entity_id'] 		= $entity_id;
					$data49['value'] = $this->m_catalog_product_entity->GetColorProduct($worksheet->getCellByColumnAndRow(14, $row)->getValue())->option_id;
					$this->m_catalog_product_entity->InsertcatalogProductEntityVarchar($data49);

					// catalog_product_flat_1
					$color 	  = $this->m_catalog_product_entity->GetColorProduct($worksheet->getCellByColumnAndRow(12, $row)->getValue());
					$material = $this->m_catalog_product_entity->GetMaterialProduct($worksheet->getCellByColumnAndRow(14, $row)->getValue());
					$type  	  = strtolower($worksheet->getCellByColumnAndRow(4, $row)->getValue());
					if($type  == 'configurable'){
					$url = $worksheet->getCellByColumnAndRow(1, $row)->getValue().'-'.$worksheet->getCellByColumnAndRow(2, $row)->getValue().''.$worksheet->getCellByColumnAndRow(12, $row)->getValue();
						$data50['entity_id'] 	  		= $entity_id;
						$data50['attribute_set_id'] 	= 4;
						$data50['type_id']  			= strtolower($worksheet->getCellByColumnAndRow(4, $row)->getValue());
						$data50['color'] 	  			= NULL;
						$data50['color_value'] 			= NULL;
						$data50['created_at'] 			= date('Y-m-d H:i:s');
						$data50['gift_message_available'] = 2;
						$data50['has_options'] 			= 1;
						$data50['image'] 				= $gambar1;
						$data50['material'] 			= $material->option_id;
						$data50['name'] 				= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$data50['price'] 				= NULL;
						$data50['publish_article'] 		= date('Y-m-d H:i:s');
						$data50['required_options'] 	= 1;
						$data50['short_description'] 	= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
						$data50['sku'] 					= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$data50['small_image'] 			= $gambar1;
						$data50['swatch_image'] 		= $gambar1;
						$data50['thumbnail'] 			= $gambar1;
						$data50['updated_at'] 			= date('Y-m-d H:i:s');
						$data50['url_key'] 				= url_title(strtolower($url), 'dash', true);
						$data50['visibility'] 			= 4;
						$data50['weight'] 				= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						$this->m_catalog_product_entity->InsertcatalogProductFlat1($data50);
						$this->m_catalog_product_entity->InsertcatalogProductFlat2($data50);
					}else{
					$url = $worksheet->getCellByColumnAndRow(1, $row)->getValue().'-'.$worksheet->getCellByColumnAndRow(12, $row)->getValue().''.$worksheet->getCellByColumnAndRow(13, $row)->getValue();
						$data50['entity_id'] 	  		= $entity_id;
						$data50['attribute_set_id'] 	= 4;
						$data50['type_id']  			= strtolower($worksheet->getCellByColumnAndRow(4, $row)->getValue());
						$data50['color'] 	  			= $color->option_id;
						$data50['color_value'] 			= $color->value;
						$data50['created_at'] 			= date('Y-m-d H:i:s');
						$data50['gift_message_available'] = 0;
						$data50['has_options'] 			= 0;
						$data50['image'] 				= $gambar1;
						$data50['material'] 			= $material->option_id;
						$data50['msrp_display_actual_price_type'] = 0;
						$data50['name'] 				= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
						$data50['price'] 				= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
						$data50['required_options'] 	= 0;
						$data50['short_description'] 	= $worksheet->getCellByColumnAndRow(7, $row)->getValue();
						$data50['sku'] 					= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
						$data50['small_image'] 			= $gambar1;
						$data50['swatch_image'] 		= $gambar1;
						$data50['thumbnail'] 			= $gambar1;
						$data50['updated_at'] 			= date('Y-m-d H:i:s');
						$data50['url_key'] 				= url_title(strtolower($url), 'dash', true);
						$data50['visibility'] 			= 1;
						$data50['weight'] 				= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
						$this->m_catalog_product_entity->InsertcatalogProductFlat1($data50);
						$this->m_catalog_product_entity->InsertcatalogProductFlat2($data50);
					}

					// catalog_product_index_price
					$type  	  = strtolower($worksheet->getCellByColumnAndRow(4, $row)->getValue());
					if($type  == 'configurable'){
						$price = 0;
					}else{
						$price = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					}

					$data51['entity_id'] 			= $entity_id;
					$data51['customer_group_id'] 	= 0;
					$data51['website_id'] 		  	= 1;
					$data51['tax_class_id'] 		= 0;
					$data51['price'] 		  		= $price;
					$data51['final_price'] 		  	= $price;
					$data51['min_price'] 		  	= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$data51['max_price'] 		  	= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductIndexPrice($data51);
					$this->m_catalog_product_entity->InsertcatalogProductIndexPriceReplica($data51);

					$data52['entity_id'] 			= $entity_id;
					$data52['customer_group_id'] 	= 1;
					$data52['website_id'] 		  	= 1;
					$data52['tax_class_id'] 		= 0;
					$data52['price'] 		  		= $price;
					$data52['final_price'] 		  	= $price;
					$data52['min_price'] 		  	= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$data52['max_price'] 		  	= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductIndexPrice($data52);
					$this->m_catalog_product_entity->InsertcatalogProductIndexPriceReplica($data52);

					$data53['entity_id'] 			= $entity_id;
					$data53['customer_group_id'] 	= 2;
					$data53['website_id'] 		  	= 1;
					$data53['tax_class_id'] 		= 0;
					$data53['price'] 		  		= $price;
					$data53['final_price'] 		  	= $price;
					$data53['min_price'] 		  	= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$data53['max_price'] 		  	= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductIndexPrice($data53);
					$this->m_catalog_product_entity->InsertcatalogProductIndexPriceReplica($data53);

					$data54['entity_id'] 			= $entity_id;
					$data54['customer_group_id'] 	= 3;
					$data54['website_id'] 		  	= 1;
					$data54['tax_class_id'] 		= 0;
					$data54['price'] 		  		= $price;
					$data54['final_price'] 		  	= $price;
					$data54['min_price'] 		  	= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$data54['max_price'] 		  	= $worksheet->getCellByColumnAndRow(5, $row)->getValue();
					$this->m_catalog_product_entity->InsertcatalogProductIndexPrice($data54);
					$this->m_catalog_product_entity->InsertcatalogProductIndexPriceReplica($data54);

					// catalog_product_relation
					$type  	  = strtolower($worksheet->getCellByColumnAndRow(4, $row)->getValue());
					if($type  == 'configurable'){

							// catalog_product_super_attribute
							$data55['product_id'] 			= $entity_id;
							$data55['attribute_id'] 		= 93;
							$data55['position'] 		  	= 0;
							$this->m_catalog_product_entity->InsertcatalogProductSuperAttribute($data55);

							$data56['product_id'] 			= $entity_id;
							$data56['attribute_id'] 		= 136;
							$data56['position'] 		  	= 1;
							$this->m_catalog_product_entity->InsertcatalogProductSuperAttribute($data56);
					}else{
						$sku  	= substr($worksheet->getCellByColumnAndRow(0, $row)->getValue(), 0, -1);
						$parent = $this->m_catalog_product_entity->GetCatalogProductEntity($worksheet->getCellByColumnAndRow(0, $row)->getValue())->entity_id;

							// catalog_product_relation
							$data57['parent_id'] 			= $parent;
							$data57['child_id'] 			= $entity_id;
							$this->m_catalog_product_entity->InsertcatalogProductRelation($data57);

							// catalog_product_super_link
							$data58['product_id'] 			= $entity_id;
							$data58['parent_id'] 			= $parent;
							$this->m_catalog_product_entity->InsertcatalogProductSuperLink($data58);
					}
					// catalog_product_website
					$data59['product_id'] 			= $entity_id;
					$data59['website_id'] 			= 1;
					$this->m_catalog_product_entity->InsertcatalogProductWebsite($data59);

					// url_rewrite
					$type  	  = strtolower($worksheet->getCellByColumnAndRow(4, $row)->getValue());
					if($type  == 'configurable'){
						$path = $worksheet->getCellByColumnAndRow(1, $row)->getValue().'-'.$worksheet->getCellByColumnAndRow(2, $row)->getValue().''.$worksheet->getCellByColumnAndRow(12, $row)->getValue();
						$url  = url_title(strtolower($path), 'dash', true);

							$data613['entity_type'] 	  	= 'product';
							$data613['entity_id'] 	  		= $entity_id;
							$data613['request_path'] 	  	= $url.'.html';
							$data613['target_path'] 	  	= 'catalog/product/view/id/'.$entity_id;
							$data613['redirect_type'] 	  	= 0;
							$data613['store_id'] 	  		= 1;
							$data613['is_autogenerated'] 	= 1;
							$this->m_catalog_product_entity->InsertUrlRewrite($data613);
							
							$data614['entity_type'] 	  	= 'product';
							$data614['entity_id'] 	  		= $entity_id;
							$data614['request_path'] 	  	= $url.'.html';
							$data614['target_path'] 	  	= 'catalog/product/view/id/'.$entity_id;
							$data614['redirect_type'] 	  	= 0;
							$data614['store_id'] 	  		= 2;
							$data614['is_autogenerated'] 	= 1;
							$this->m_catalog_product_entity->InsertUrlRewrite($data614);

							$data615['entity_type'] 	  	= 'product';
							$data615['entity_id'] 	  		= $entity_id;
							$data615['request_path'] 	  	= '/'.$url.'.html';
							$data615['target_path'] 	  	= 'catalog/product/view/id/'.$entity_id.'category/3';
							$data615['redirect_type'] 	  	= 0;
							$data615['store_id'] 	  		= 1;
							$data615['is_autogenerated'] 	= 1;
							$data615['metadata'] 	  		= '{"category_id":"3"}';
							$this->m_catalog_product_entity->InsertUrlRewrite($data615);
							$idrewrite3 = $this->m_catalog_product_entity->GetCatalog('/'.$url.'.html');

							// catalog_product_website
							$data616['url_rewrite_id'] 		= $idrewrite3->url_rewrite_id;
							$data616['category_id'] 		= 3;
							$data616['product_id'] 			= $entity_id;
							$this->m_catalog_product_entity->InsertcatalogUrlRewriteProductCategory($data616);

							$data617['entity_type'] 	  	= 'product';
							$data617['entity_id'] 	  		= $entity_id;
							$data617['request_path'] 	  	= '/'.$url.'.html';
							$data617['target_path'] 	  	= 'catalog/product/view/id/'.$entity_id.'category/3';
							$data617['redirect_type'] 	  	= 0;
							$data617['store_id'] 	  		= 2;
							$data617['is_autogenerated'] 	= 1;
							$data617['metadata'] 	  		= '{"category_id":"3"}';
							$this->m_catalog_product_entity->InsertUrlRewrite($data617);
							$idrewrite4 = $this->m_catalog_product_entity->GetCatalog('/'.$url.'.html');

							// catalog_product_website
							$data616['url_rewrite_id'] 		= $idrewrite4->url_rewrite_id;
							$data616['category_id'] 		= 3;
							$data616['product_id'] 			= $entity_id;
							$this->m_catalog_product_entity->InsertcatalogUrlRewriteProductCategory($data616);


						$pecah2 = explode(",", $worksheet->getCellByColumnAndRow(3, $row)->getValue());
						foreach($pecah2 as $i =>$key) {
							$i >0;
							$linkcategory = $this->m_catalog_product_entity->GetLinkCatalogCategoryEntityVarchar($key)->value;

							$data60['entity_type'] 	  		= 'product';
							$data60['entity_id'] 	  		= $entity_id;
							$data60['request_path'] 	  	= $linkcategory.'/'.$url.'.html';
							$data60['target_path'] 	  		= 'catalog/product/view/id/'.$entity_id.'category/'.$key;
							$data60['redirect_type'] 	  	= 0;
							$data60['store_id'] 	  		= 1;
							$data60['is_autogenerated'] 	= 1;
							$data60['metadata'] 	  		= '{"category_id":"'.$key.'"}';
							$this->m_catalog_product_entity->InsertUrlRewrite($data60);
							$idrewrite = $this->m_catalog_product_entity->GetCatalog($linkcategory.'/'.$url.'.html');

							$data601['entity_type'] 	  	= 'product';
							$data601['entity_id'] 	  		= $entity_id;
							$data601['request_path'] 	  	= $linkcategory.'/'.$url.'.html';
							$data601['target_path'] 	  	= 'catalog/product/view/id/'.$entity_id.'category/'.$key;
							$data601['redirect_type'] 	  	= 0;
							$data601['store_id'] 	  		= 2;
							$data601['is_autogenerated'] 	= 1;
							$data601['metadata'] 	  		= '{"category_id":"'.$key.'"}';
							$this->m_catalog_product_entity->InsertUrlRewrite($data601);
							$idrewrite2 = $this->m_catalog_product_entity->GetCatalog($linkcategory.'/'.$url.'.html');

							// catalog_product_website
							$data611['url_rewrite_id'] 		= $idrewrite->url_rewrite_id;
							$data611['category_id'] 		= $key;
							$data611['product_id'] 			= $entity_id;
							$this->m_catalog_product_entity->InsertcatalogUrlRewriteProductCategory($data611);

							// catalog_product_website
							$data612['url_rewrite_id'] 		= $idrewrite2->url_rewrite_id;
							$data612['category_id'] 		= $key;
							$data612['product_id'] 			= $entity_id;
							$this->m_catalog_product_entity->InsertcatalogUrlRewriteProductCategory($data612);

						}
					}


				} // end for

			}
	    	redirect(base_url().'backend/uploadproduct');
		}	
 	}	
	
	
	//mass upload parent
	public function uploadparent(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		$data['title'] = 'Mass Upload Parent - '.BRAND;
		$data['page']  = 'backend/massupload/uploadparent';
		$this->load->view('backend/thamplate', $data); 
 	}

	public function uploadproductparent_act(){
 		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}

		if(isset($_FILES["file"]["name"])) {
			$path = $_FILES["file"]["tmp_name"];
			$object = PHPExcel_IOFactory::load($path);
			foreach($object->getWorksheetIterator() as $worksheet) {

				$highestRow 	= $worksheet->getHighestRow();
				$highestColumn 	= $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++) {

					$parent  	= $this->m_catalog_product_entity->GetCatalogProductEntity($worksheet->getCellByColumnAndRow(0, $row)->getValue())->entity_id;
					$child 		= $this->m_catalog_product_entity->GetCatalogProductEntity($worksheet->getCellByColumnAndRow(1, $row)->getValue())->entity_id;

					// catalog_product_relation
					$data57['parent_id'] 			= $parent;
					$data57['child_id'] 			= $child;
					$this->m_catalog_product_entity->InsertcatalogProductRelation($data57);

					// catalog_product_super_link
					$data58['product_id'] 			= $child;
					$data58['parent_id'] 			= $parent;
					$this->m_catalog_product_entity->InsertcatalogProductSuperLink($data58);

				}
			}
	       	redirect(base_url().'backend/uploadcategory');
		}	
 	}
		
		
 	//waiting bank transfer
	public function waitingbanktransfer(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		$data['lists'] 		= $this->m_sales_order_item->WaitingBankTransfer();

		$data['title'] = 'Waiting Bank Transfer - '.BRAND;
		$data['page']  = 'backend/transaksi/waitingbanktransfer';
		$this->load->view('backend/thamplate', $data); 
 	}


	public function excelwaitingbanktransfer(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("Tanggal", "ID Order", "Status", "Product Name", "SKU", "QTY", "Amount", "Metode Pembayaran", "Customer Name", "Customer Email", "Receiver Name", 
      	"Address", "City", "Province", "Country", "Postal Code", "Phone Number");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_item->WaitingBankTransferExcel();
      $excel_row = 2;
      foreach($employee_data as $row){

        if($row->payment_method == 'ipay88_cc'){
            $keterangan = 'Credit Card';
        }else if($row->payment_method == 'banktransfer'){
            $keterangan = 'Transfer Bank';
        }else if($row->payment_method == 'prismalink_vabca'){
            $keterangan = 'Virtual Account';
        }else if($row->payment_method == 'cashondelivery'){
            $keterangan = 'COD';
        }  
	$prov = explode(",", $row->city);

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->created_at);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->increment_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->status);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, number_format($row->qty_ordered,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, number_format($row->grand_total,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $keterangan);
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->firstname." ".$row->lastname);
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->customer_email);
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->shipping_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->street." ".$row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $prov[1]);
        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->region);
        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, 'Indonesia');
        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->postcode);
        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $row->telephone);        
	$excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Waiting-Bank-Transfer-TheExecutive.xls"');
      $object_writer->save('php://output');
    }

 	//virtual account
	public function virtualaccount(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		$data['lists'] 		= $this->m_sales_order_item->VirtualAccount();

		$data['title'] = 'Virtual Account - '.BRAND;
		$data['page']  = 'backend/transaksi/virtualaccount';
		$this->load->view('backend/thamplate', $data); 
 	}

 	public function excelvirtualaccount(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("ID Order", "Brand", "SKU", "Product", "Qty", "Pembayaran", "Harga Product", "Potongan Pembayaran", "Voucher", "Net Pembayaran", "Biaya Pengiriman", "Kurir", "Bank", "Penerima", "Alamat", "Kota", "Provinsi", "Negara", "Kode Pos", "Telepon");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_item->VirtualAccount();
      $excel_row = 2;
      foreach($employee_data as $row){
      	$kode     = $row->entity_id; 
      	$diskon1  = $row->base_original_price;
      	$diskon2  = $row->price; 
      	$discount = $diskon1-$diskon2;

      	$net1   = $row->price;
      	$net2   = $row->discount_amount; 
      	$nett   = $net1-$net2;
      	$count  = $this->m_sales_order_item->VirtualAccountKode($kode);

        if($row->base_discount_amount <= 0){
            $diskon = str_replace("-","",$row->base_discount_amount)/$count;
        }else{
            $diskon = str_replace("-","",$row->discount_amount)/$count;
        }

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->increment_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, 700000);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, number_format($row->qty_ordered,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, number_format($row->grand_total,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, number_format($row->base_original_price,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, number_format($discount,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, number_format($diskon,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, number_format($nett,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, number_format($row->shipping_and_handling,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->shipping_information);
        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, "VA BCA");
        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->shipping_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->street.', '.$row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $row->region);
        $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, "Indonesia");
        $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $row->postcode);
        $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $row->telephone);
        $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Virtual-Account-TheExecutive.xls"');
      $object_writer->save('php://output');
    }


 	//cash on delivery
	public function cashondelivery(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		$data['lists'] = $this->m_sales_order_item->CashOnDelivery();

		$data['title'] = 'Cash On Delivery - '.BRAND;
		$data['page']  = 'backend/transaksi/cashondelivery';
		$this->load->view('backend/thamplate', $data); 
 	}

 	public function excelcashondelivery(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("ID Order", "Brand", "SKU", "Product", "Qty", "Pembayaran", "Harga Product", "Potongan Pembayaran", "Voucher", "Net Pembayaran", "Biaya Pengiriman", "Kurir", "Bank", "Penerima", "Alamat", "Kota", "Provinsi", "Negara", "Kode Pos", "Telepon");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_item->CashOnDeliveryExcel();
      $excel_row = 2;
      foreach($employee_data as $row){
      	$kode     = $row->entity_id; 
      	$diskon1  = $row->base_original_price;
      	$diskon2  = $row->price; 
      	$discount = $diskon1-$diskon2;

      	$net1   = $row->price;
      	$net2   = $row->discount_amount; 
      	$nett   = $net1-$net2;
      	$count  = $this->m_sales_order_item->CashOnDeliveryKode($kode);

        if($row->base_discount_amount <= 0){
            $diskon = str_replace("-","",$row->base_discount_amount)/$count;
        }else{
            $diskon = str_replace("-","",$row->discount_amount)/$count;
        }

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->increment_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, 700000);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, number_format($row->qty_ordered,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, number_format($row->grand_total,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, number_format($row->base_original_price,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, number_format($discount,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, number_format($diskon,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, number_format($nett,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, number_format($row->shipping_and_handling,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->shipping_information);
        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, "COD");
        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->shipping_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->street.', '.$row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $row->region);
        $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, "Indonesia");
        $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $row->postcode);
        $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $row->telephone);
        $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Cash-On-Delivery-TheExecutive.xls"');
      $object_writer->save('php://output');
    }


 	//payment confirmation receive
	public function confirmationreceive(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		$data['lists'] = $this->m_sales_order_item->ConfirmationRecive();

		$data['title'] = 'Payment Confirmation Receive - '.BRAND;
		$data['page']  = 'backend/transaksi/paymentconfirmationreceive';
		$this->load->view('backend/thamplate', $data); 
 	}

 	public function excelconfirmationreceive(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("ID Order", "Brand", "SKU", "Product", "Qty", "Pembayaran", "Harga Product", "Potongan Pembayaran", "Voucher", "Net Pembayaran", "Biaya Pengiriman", "Kurir", "Bank", "Penerima", "Alamat", "Kota", "Provinsi", "Negara", "Kode Pos", "Telepon");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_item->ConfirmationRecive();
      $excel_row = 2;
      foreach($employee_data as $row){
      	$kode     = $row->entity_id; 
      	$diskon1  = $row->base_original_price;
      	$diskon2  = $row->price; 
      	$discount = $diskon1-$diskon2;

      	$net1   = $row->price;
      	$net2   = $row->discount_amount; 
      	$nett   = $net1-$net2;
      	$count  = $this->m_sales_order_item->ConfirmationReciveKode($kode);

        if($row->base_discount_amount <= 0){
            $diskon = str_replace("-","",$row->base_discount_amount)/$count;
        }else{
            $diskon = str_replace("-","",$row->discount_amount)/$count;
        }

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->increment_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, 700000);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, number_format($row->qty_ordered,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, number_format($row->grand_total,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, number_format($row->base_original_price,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, number_format($discount,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, number_format($diskon,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, number_format($nett,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, number_format($row->shipping_and_handling,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->shipping_information);
        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, "BCA");
        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->shipping_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->street.', '.$row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $row->region);
        $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, "Indonesia");
        $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $row->postcode);
        $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $row->telephone);
        $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Payment-Confirmation-Receive-TheExecutive.xls"');
      $object_writer->save('php://output');
    } 	
    
    
    //credit card
	public function creditcard(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		$data['lists'] = $this->m_sales_order_item->CreditCard();

		$data['title'] = 'Credit Card - '.BRAND;
		$data['page']  = 'backend/transaksi/creditcard';
		$this->load->view('backend/thamplate', $data); 
 	}

 	public function excelcreditcard(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("ID Order", "Brand", "SKU", "Product", "Qty", "Pembayaran", "Harga Product", "Potongan Pembayaran", "Voucher", "Net Pembayaran", "Biaya Pengiriman", "Status", "Kurir", "Bank", "Penerima", "Alamat", "Kota", "Provinsi", "Negara", "Kode Pos", "Telepon");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_item->CreditCard();
      $excel_row = 2;
      foreach($employee_data as $row){
      	$kode     = $row->entity_id; 
      	$diskon1  = $row->base_original_price;
      	$diskon2  = $row->price; 
      	$discount = $diskon1-$diskon2;

      	$net1   = $row->price;
      	$net2   = $row->discount_amount; 
      	$nett   = $net1-$net2;
      	$count  = $this->m_sales_order_item->CreditCardKode($kode);

        if($row->base_discount_amount <= 0){
            $diskon = str_replace("-","",$row->base_discount_amount)/$count;
        }else{
            $diskon = str_replace("-","",$row->discount_amount)/$count;
        }

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->increment_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, 700000);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, number_format($row->qty_ordered,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, number_format($row->grand_total,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, number_format($row->base_original_price,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, number_format($discount,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, number_format($diskon,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, number_format($nett,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, number_format($row->shipping_and_handling,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->status);
        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->shipping_information);
        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, "BCA");
        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->shipping_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->street.', '.$row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $row->region);
        $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, "Indonesia");
        $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $row->postcode);
        $object->getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $row->telephone);
        $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Credit-Card-TheExecutive.xls"');
      $object_writer->save('php://output');
    }


    //tarik stock
	public function tarikstock(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		$data['lists'] = $this->m_catalog_product_index_price->TarikStock();

		$data['title'] = 'Tarik Stock - '.BRAND;
		$data['page']  = 'backend/tarikstock/tarikstock';
		$this->load->view('backend/thamplate', $data); 
 	}

 public function exceltarikstock(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("ID", "SKU", "Product", "Stock", "Status");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_catalog_product_index_price->TarikStockExcel();
      $excel_row = 2;
      foreach($employee_data as $row){
        if($row->type_id == 'configurable'){
            $stat = 'Parent';
        }else{
            $stat = 'Child';
        }

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->product_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->value);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, str_replace('.0000', '', $row->qty));
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $stat);
        $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Tarik-Stock-TheExecutive.xls"');
      $object_writer->save('php://output');
    }

    //kurir
	public function kurir(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		$data['lists'] = $this->m_sales_order_grid->Kurir();

		$data['title'] = 'Kurir - '.BRAND;
		$data['page']  = 'backend/kurir/kurir';
		$this->load->view('backend/thamplate', $data); 
 	}

 	public function excelkurir(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("ID", "Increment", "Qty", "Berat", "Kurir", "Biaya Pengiriman", "Total Biaya");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_grid->Kurir();
      $excel_row = 2;
      foreach($employee_data as $row){

	    if($row->total_item_count <= 3){
	        $berat = 1;
	    }else if($row->total_item_count <= 6){
	       $berat = 2;
	    }else if($row->total_item_count <= 9){
	       $berat = 3;
	    }else if($row->total_item_count > 11){
	       $berat = 4;
	    }else if($row->total_item_count > 14){
	       $berat = 5;
	    }else if($row->total_item_count > 17){
	       $berat = 6;
	    }else if($row->total_item_count > 20){
	       $berat = 7;
	    }

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->entity_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->increment_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->total_item_count);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $berat);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->shipping_description);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, number_format($row->shipping_and_handling,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, number_format($row->base_grand_total,0,",",""));
        $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Kurir-TheExecutive.xls"');
      $object_writer->save('php://output');
    }

	public function jne(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		$data['lists'] = $this->m_sales_order_item->Jne();

		$data['title'] = 'JNE - '.BRAND;
		$data['page']  = 'backend/kurir/jne';
		$this->load->view('backend/thamplate', $data); 
 	}

 	public function exceljne(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("RECEIVER NAME", "RECEIVER ADDRESS", "RECEIVER CITY", "RECEIVER ZIP", "RECEIVER REGION", "RECEIVER CONTACT", "RECEIVER PHONE", 
      	"QTY", "WEIGHT", "GOODS DESC", "GOODS VALUE", "SPECIAL INSTRUCTION", "SERVICE", "ORDER ID/REFERENCE NUMBER", "INSURANCE");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_item->Jne();
      $excel_row = 2;
      foreach($employee_data as $row){

      	$count  = $this->m_sales_order_item->CountJne($row->order_id);
        if($row->shipping_information == 'Lion Parcel - Bayar Di Tempat'){
            $kurir = 'COD';
        }else{
            $kurir = 'JNE';
        }

	    if($count <= 3){
	      $berat = 1;
	    }else if($count <= 6){
	      $berat = 2;
	    }else if($count <= 9){
	      $berat = 3;
	    }else if($count > 11){
	      $berat = 4;
	    }else if($count > 14){
	      $berat = 5;
	    }else if($count > 17){
	      $berat = 6;
	    }else if($count > 20){
	      $berat = 7;
	    }
      
        $pecah  = explode(", ", $row->city);
        if(!isset($pecah[1])){
          $hasil = $pecah[0];
        }else{
          $hasil = $pecah[1];
        }

      	$calcu = $row->shipping_and_handling * 10;
        if($calcu > $row->base_grand_total){
          $asuransi = 'Y';
        }else{
          $asuransi = 'N';
        }
      
        $arr = array(
        "Kota Administrasi Jakarta Utara" => "DKI Jakarta",
        "Kota Administrasi Jakarta Barat" => "DKI Jakarta",
        "Kota Administrasi Jakarta Timur" => "DKI Jakarta",
        "Kota Administrasi Jakarta Selatan" => "DKI Jakarta",
        "Kota Administrasi Jakarta Pusat" => "DKI Jakarta",
        "Kota Administrasi Kepulauan Seribu" => "DKI Jakarta");

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->shipping_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->street);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, strtr($hasil,$arr));
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->postcode);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->region);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->billing_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->telephone);
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $count);
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $berat);
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, 'PAKAIAN');
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->base_grand_total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 'Handed');
        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, 'REG');
        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->order_id.'/');
        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $asuransi);
        $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Airwaybill-JNE-TheExecutive.xls"');
      $object_writer->save('php://output');
    }

	public function lion(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
		$data['lists'] = $this->m_sales_order_item->LionParcel();

		$data['title'] = 'Lion Parcel - '.BRAND;
		$data['page']  = 'backend/kurir/lion';
		$this->load->view('backend/thamplate', $data); 
 	}


 	public function excellion(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("STT NO/AWB", "BRAND", "NO ORDER", "NO SO", "CUSTOMER NAME", "TOTAL PAYMENT", "SKU ARTICLE", "ARTICLE-COLOR-SIZE", "QTY", 
      	"AMOUNT (per item)", "TOTAL SHIPPING", "LOGISTIK", "RECEIVERS NAME", "ADDRESS", "CITY", "PROVINCE", "COUNTRY", "POSTAL CODE", "PHONE NUMBER");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_item->Jne();
      $excel_row = 2;
      foreach($employee_data as $row){

        $pecah  = explode(", ", $row->city);
        if(!isset($pecah[1])){
          $hasil = $pecah[0];
        }else{
          $hasil = $pecah[1];
        }
      
        $arr = array(
        "Kota Administrasi Jakarta Utara" => "DKI Jakarta",
        "Kota Administrasi Jakarta Barat" => "DKI Jakarta",
        "Kota Administrasi Jakarta Timur" => "DKI Jakarta",
        "Kota Administrasi Jakarta Selatan" => "DKI Jakarta",
        "Kota Administrasi Jakarta Pusat" => "DKI Jakarta",
        "Kota Administrasi Kepulauan Seribu" => "DKI Jakarta");

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, '');
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, 'The Executive');
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->order_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, '');
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->billing_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->base_grand_total);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, $row->name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->qty_ordered);
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->price);
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->shipping_and_handling);
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, 'COD');
        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, $row->shipping_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, $row->street);
        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->region);
        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, 'Indonesia');
        $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, $row->postcode);
        $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $row->telephone);
        $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="Airwaybill-Lion-Parcel-TheExecutive.xls"');
      $object_writer->save('php://output');
    }

 	

    //so
	public function so(){
		if($this->session->userdata('status') != "backend"){
			redirect(base_url('login'));
		}
      	$data['lists'] = $this->m_sales_order_item->StockOpnameAll();

		$data['title'] = 'SO - '.BRAND;
		$data['page']  = 'backend/so/so';
		$this->load->view('backend/thamplate', $data); 
 	}


 	public function excelso(){
            $delimiter = ',';
	    $f = fopen('php://memory', 'w');
	    $fields = array('Brand / Sold to Party, No Order, Order Date, Customer Name, Brand, SKU, Product Name, Qty, Amount, Tag Price / Full Price, Reduction / Discount Amount, Additional Voucher Disc, Customer Paid, Shipping Cost, Logistik, Payment, Card Type, Auth Code, CC No, Bank, Receivers Name, Address 1, Address 2, Address 3, Address 4, Address 5, Province, Country, Postal Code, Phone Number, Margin');
	    fputcsv($f, $fields, $delimiter);

	$data 		= $this->m_sales_order_item->StockOpnameItem();
      	$countso  	= $this->m_sales_order_item->CountSOKode($data->entity_id);   

      	if($countso == 0){
			$rows 	  = $this->m_sales_order_item->StockOpname($data->entity_id);			

			foreach($rows as $row){
			$kode     = $row->entity_id; 
			$diskon1  = $row->base_original_price;
			$diskon2  = $row->price; 
			$discount = $diskon1-$diskon2; 

			$net1     = $row->price;
			$net2     = $row->discount_amount; 
			$nett     = $net1-$net2;
			$count    = $this->m_sales_order_item->CreditCardKode($kode);
			$product  = $this->m_sales_order_item->StockOpnameKode($row->sku);
		    	$filename = $row->increment_id.".csv";

		   	$updateso    = $this->m_sales_order_item->UpdateStockOpname($row->order_id);
		   	$updateorder = $this->m_sales_order_item->UpdateProductStockOpname($row->order_id);

			    if($row->base_discount_amount <= 0){
			        $diskon	= str_replace("-","",$row->base_discount_amount)/$count;
			    }else{
			        $diskon	= str_replace("-","",$row->discount_amount)/$count;
			    }
			   
			    if($row->shipping_information != 'JNE Reguler - JNE Reguler Service'){
			        $kurir = 'COD';
			    }else{
			        $kurir = 'JNE';
			    }

		        if($row->payment_method == 'ipay88_cc'){
		            $paymentstat = 'B';
		            $paymentbank = '';
		        }else if($row->payment_method == 'prismalink_vabca'){
		            $paymentstat = 'T';
		            $paymentbank = 'VA BCA';
		        }else if($row->payment_method == 'cashondelivery'){
		            $paymentstat = 'T';
		            $paymentbank = '';
		        }else{
		            $paymentstat = 'T';
		            $paymentbank = 'BCA';
		        }
		    
		        $karakter = 60;
		        $stringkarakter = strlen($row->street);
		        $alamat = $row->street;
		        $informasi = substr($alamat, 0, $karakter);
		        if($stringkarakter > 60){
		            if ($alamat{$karakter - 1} != ' ') { 
		              $start = $alamat{$karakter - 1} != ' ';
		              $new_pos    = strrpos($informasi, ' '); 
		              $informasi  = substr($alamat, 0, $new_pos);
		              $informasi2 = substr($alamat, $new_pos, 100);
		            }
		        }else{
		            $informasi  = $row->street;
		            $informasi2 = '';
		        }
		 
		        $nett2     = $nett;
		        $countnet  = strpos($nett2,'.');
		        if ($countnet){
		          $totnet = $nett2;
		        }
		        else {
		          $totnet = $nett2;
		        }
		        
		        $potongan   = $row->base_original_price-$row->price;
		        $cpotongan  = strpos($potongan,'.');
		        if ($cpotongan){
		          $potongannet = "'".str_replace('.', ',', $potongan)."'";
		        }
		        else {
		          $potongannet = $potongan;
		        }
		        
			$kota    = explode(",", $row->city);
		        $arr = array(
		        "Kota Administrasi Jakarta Utara" => "Jakarta Utara",
		        "Kota Administrasi Jakarta Barat" => "Jakarta Barat",
		        "Kota Administrasi Jakarta Timur" => "Jakarta Timur",
		        "Kota Administrasi Jakarta Selatan" => "Jakarta Selatan",
		        "Kota Administrasi Jakarta Pusat" => "Jakarta Pusat",
		        "Kota Administrasi Kepulauan Seribu" => "Kepulauan Seribu");

		        $lineData = array(
		            '700000', 
		            $row->increment_id, 
		            date('d.m.Y', strtotime($row->created_at)), 
		            $row->shipping_name, 
		            'The Executive', 
		            $row->sku, 
		        	str_replace(',',' ', $product->name), 
		        	str_replace('.0000', '', $row->qty_ordered),
		        	'', 
		        	str_replace('.0000', '', $row->base_original_price), 
		        	$potongannet, 
		        	round($net2), 
		        	round($totnet),
		        	str_replace('.0000', '', $row->shipping_and_handling),
		        	$kurir,
		        	$paymentstat,
		        	'',
		        	'',
		        	'',
		        	$paymentbank,
		        	$row->billing_name,
		        	str_replace(array('.', ', ', ' ', "\n", "\t", "\r"), ' ', $informasi),
		        	str_replace(array('.', ', ', ' ', "\n", "\t", "\r"), ' ', $informasi2),
		        	strtr($kota[0],$arr), 
		        	'', 
		        	strtr($kota[1],$arr), 
		        	$row->region, 
		        	'Indonesia', 
		        	$row->postcode, 
		        	str_replace("+62-","0",$row->telephone), 
		        	''
		        );
		        fputcsv($f, $lineData, $delimiter);
		    }
		    fseek($f, 0);
		    
		    header('Content-Type: text/csv; charset=utf-8'); 
		    header('Content-Disposition: attachment; filename="'.$filename.'";');
		    
		    // file_put_contents("/var/www/html/agingnew/assets/csv/" . $filename, "w");
		    file_put_contents("ftp://delamisap:D3l4m1!@levelup.delamibrands.com:21/data/ECOMMERCE/IN/".$filename, $f);
      	}
}


    //image upload
    public function upload($name) {
		$new_name = time();
		switch ($_FILES[$name]['type']) {
			case "image/jpeg" :
				$type = $new_name.'.jpeg';
				break;
			case "image/png" :
				$type = $new_name.'.png';
				break;
			case "image/gif" :
				$type = $new_name.'.gif';
				break;
			default:
				$type = 'not allowed_types';
				break;
		}

		$config['upload_path'] 		= './assets/user/';
		$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
		$config['max_size'] 		= '262144';
		$config['file_name'] 		= $type;
		$cover_name					= $config['file_name'];
		$this->upload->initialize($config);

		if ($this->upload->do_upload($name)) {
			$data['message'] 		= $this->upload->data();
		} else {
            $this->session->set_flashdata('warning', 'Upload image failed!');
			redirect($_SERVER['HTTP_REFERER']);
		}
		return $config['file_name'];
	}
}