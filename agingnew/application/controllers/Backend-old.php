<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {
	
	function __construct(){
		parent::__construct();
	  	$this->load->model(array('m_user', 'm_catalog_category_product', 'm_cataloginventory_stock_item', 'm_catalog_product_index_price', 'm_catalog_product_entity_decimal',
	  		'm_sales_order_item', 'm_sales_order_grid'));
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

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++) {
					$idproduct 	= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$idcategory = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$data[]  	= array(
						'product_id'	=>	$idproduct,
						'category_id'	=>	$idcategory,
						'position'		=>	0
					);
				}
			}
			$this->m_catalog_category_product->InsertCatalog($data);
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

					$id 					= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$data['qty']  			= $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$data['is_in_stock'] 	= $status;
					$this->m_cataloginventory_stock_item->InsertStock($id, $data);

					$id2 					= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$data2['price']  		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$data2['final_price'] 	= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$data2['min_price'] 	= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$data2['max_price'] 	= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$data2['tier_price'] 	= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$this->m_catalog_product_index_price->InsertStock($id2, $data2);

					$id3 					= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$data3['value']  		= $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$this->m_catalog_product_entity_decimal->InsertStock($id3, $data3);
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

				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				for($row=2; $row<=$highestRow; $row++) {
					$idproduct 	= $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$idcategory = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

					$this->m_catalog_category_product->DeleteCatalog($idproduct, $idcategory);
				}
			}
	       	redirect(base_url().'backend/deletecategory');
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
      $table_columns = array("ID Order", "SKU", "Product", "Qty", "Pembayaran", "Metode Pembayaran", "Tanggal");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_item->WaitingBankTransfer();
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

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->increment_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, number_format($row->qty_ordered,0,",",""));
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, number_format($row->grand_total));
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $keterangan);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->created_at);
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

      $employee_data = $this->m_sales_order_item->CashOnDelivery();
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
      $table_columns = array("ID", "SKU", "Title", "Discount Price", "Price", "Stock", "Status", "Link Image", "Date");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_catalog_product_index_price->TarikStockExcel();
      $excel_row = 2;
      foreach($employee_data as $row){
    
        $diskon = str_replace('.0000', '', $row->discount_amount);
        $price  = str_replace('.0000', '', $row->price);
        $entity = $row->entity_id;
        if($row->simple_action == 'to_fixed'){
            $calcu  = $price * $diskon / 100;
            $subcalcu = $price - $diskon;
            $result = $price - $subcalcu;
        }else{
            $calcu  = $price * $diskon / 100;
            $result = $price - $calcu;
        }

        if($row->is_in_stock == 0){
            $available = 'Tidak Aktif';
        }else{
            $available = 'Aktif';
        }
      	$name  = $this->m_catalog_product_index_price->TarikStockExcelKode($entity);

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->product_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $name->value);
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $result);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $price);
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, str_replace('.0000', '', $row->qty));
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $available);
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, 'http://theexecutive.co.id/pub/media/catalog/product'.$row->value);
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->created_at);
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
        if($row->shipping_information == 'Lion Parcel - Cash on Delivery'){
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

      $employee_data = $this->m_sales_order_item->LionParcel();
      $excel_row = 2;
      foreach($employee_data as $row){
      
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
      	$data['lists'] = $this->m_sales_order_item->StockOpname();

		$data['title'] = 'SO - '.BRAND;
		$data['page']  = 'backend/so/so';
		$this->load->view('backend/thamplate', $data); 
 	}

 	public function excelso(){
      $this->load->library("excel");
      $object = new PHPExcel();
      $object->setActiveSheetIndex(0);
      $table_columns = array("Brand","No Order","Order Date","Customer Name","Brand","SKU","Article-Color-Size","Qty","Amount","Tag Price Ecomm","Reduction Ecomm","Voucher Ecomm",
      	"Net Amount","Shipping Cost","Logistik","Payment","Card Type","CC No","Bank","Receiver's Name","Address 1","Address 2","Province","Country","Postal Code","Phone Number");
      $column = 0;
      
      foreach($table_columns as $field){
        $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
        $column++;
      }

      $employee_data = $this->m_sales_order_item->StockOpname();
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

	    $potongan = $row->base_original_price-$row->price;

	    if($row->base_discount_amount <= 0){
	        $diskon	= str_replace("-","",$row->base_discount_amount)/$count;
	    }else{
	        $diskon	= str_replace("-","",$row->discount_amount)/$count;
	    }

	    if($row->shipping_information == 'Lion Parcel - Cash on Delivery'){
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
	    
	    $product = $this->m_sales_order_item->StockOpnameKode($row->sku);

        $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, 700000);
        $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->order_id);
        $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, date('d.m.y', strtotime($row->created_at)));
        $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->shipping_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, 'The Executive');
        $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->sku);
        $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $product->name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row, str_replace('.0000', '', $row->qty_ordered));
        $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, '');
        $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, number_format($row->base_original_price));
        $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, number_format($potongan));
        $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, number_format($diskon));
        $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, number_format($nett));
        $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, number_format($row->shipping_and_handling));
        $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $kurir);
        $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $paymentstat);
        $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, '');
        $object->getActiveSheet()->setCellValueByColumnAndRow(17, $excel_row, '');
        $object->getActiveSheet()->setCellValueByColumnAndRow(18, $excel_row, $paymentbank);
        $object->getActiveSheet()->setCellValueByColumnAndRow(19, $excel_row, $row->billing_name);
        $object->getActiveSheet()->setCellValueByColumnAndRow(20, $excel_row, $row->street);
        $object->getActiveSheet()->setCellValueByColumnAndRow(21, $excel_row, $row->city);
        $object->getActiveSheet()->setCellValueByColumnAndRow(22, $excel_row, $row->region);
        $object->getActiveSheet()->setCellValueByColumnAndRow(23, $excel_row, 'Indonesia');
        $object->getActiveSheet()->setCellValueByColumnAndRow(24, $excel_row, $row->postcode);
        $object->getActiveSheet()->setCellValueByColumnAndRow(25, $excel_row, $row->telephone);
        $excel_row++;
      }

      $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="SO-TheExecutive.xls"');
      $object_writer->save('php://output');
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