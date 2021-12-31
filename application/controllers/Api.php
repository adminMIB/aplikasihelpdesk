<?php defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller{

	public function __construct(){
        // Call the Model constructor
		parent::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('Authentication');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->model('pos_model', "pos");
		$this->load->model('Constant_model');

		//$this->lang->load("message", "english");
		$settingResult = $this->db->get_where('site_setting');
		$settingData = $settingResult->row();

		$setting_timezone = $settingData->timezone;

		date_default_timezone_set("$setting_timezone");
		$data['data'] 	 = [];
		$data['success'] = false;
		$data['message'] = '';
		$this->res = $data;
		
	}
	
	function actionLogin(){
		$data = $this->authentication->prosesLogin(['email' => $_POST['email'], 'password' => md5($_POST['password'])], 'users');
		if($data['success']){
			if($data['data']->status != 1){
				$this->res['message'] = 'User belum aktif, kontak Admin untuk aktivasi';
			}else{
				if($data['data']->role_id == 3){
					$this->res = $data;
				}else{
					$this->res['message'] = 'Anda bukan kasir';
				}
			}
		}else{
			$this->res = $data;
		}
		echo json_encode($this->res);
	}

	function getProducts(){
		if(isset($_POST['category'])){
			$where = ["category" => $_POST['category']];
		}else{
			$where = "category > 0 ";
		}
		$url = base_url("assets/upload/products/xsmall/");
		$data = $this->db
			->select('*, Concat("'."$url".'", code, "/" ,thumbnail) urlImage, Concat("Rp.", round(retail_price,0),",-") price')
			->where($where)->get("products")->result();
		if($data){
			$this->res['success'] = true;
			$this->res['data']		= $data;
			$this->res['message'] = 'data berhasil di load';
		}
		echo json_encode($this->res);
	}

	function getQty(){
		if(!isset($_POST['produk_id'])){ $this->res['message'] = 'id produk tidak di ketahui'; }
		if(!isset($_POST['outlet_id'])){ $this->res['message'] = 'id outlet tidak di ketahui'; }

		if(isset($_POST['produk_id']) && isset($_POST['outlet_id'])){
			$produk_id = $_POST['produk_id'];
			$outlet_id = $_POST['outlet_id'];
			$query = "SELECT p.`name`, rm.`rm_name`, COALESCE((rmo.`total_stock`-rmo.`used_stock`), 0) total, rmp.`qty` qty_bahan, 
									ROUND(COALESCE((rmo.`total_stock`-rmo.`used_stock`)/rmp.qty, 0), 0) qty
									FROM products p
									JOIN raw_material_product rmp ON rmp.`product_id` = p.`id`
									LEFT JOIN raw_material rm ON rm.`rm_id` = rmp.`rm_id`
									LEFT JOIN raw_material_outlet rmo ON rmo.`rm_id` = rm.`rm_id` AND rmo.`outlet_id` = $outlet_id
									WHERE p.id = $produk_id ORDER BY 5 ASC LIMIT 1";
			$data = $this->db->query($query);
			if($data->num_rows() > 0){
				$this->res['success'] = true;
				$this->res['data']		= $data->row();
				$this->res['message'] = 'data berhasil di load';
			}else{
				$this->res['data']		= ['produk' => $produk_id, 'outlet' => $outlet_id];
				$this->res['message'] = "Stok Habis!";
			}
		}
		echo json_encode($this->res);
	}

	function bayarProduk(){
		if(!isset($_POST['dataProduk'])){ $this->res['message'] = 'tidak ada produk yang di beli'; }
		if(!isset($_POST['isProduk'])){ $this->res['message']   = 'tidak ada produk yang di beli'; }

		if(isset($_POST['isProduk']) && $_POST['isProduk'] == "true"){
			$dataOutlet 	= $this->db->where(['id' => $_POST['outlet_id']])->get('outlets')->row();
			$dataCustomer = $this->db->where(['id' => $_POST['customer_id']])->get('customers')->row();
			$dataPayment	= $this->db->where(['id' => $_POST['payment_method']])->get('payment_method')->row();
			$dataProduk 	= array();
			$updateStock 	= array();

			$insertOrders = [
				'customer_id' 					=>	$dataCustomer->id,
				'customer_name'					=>	$dataCustomer->fullname,
				'customer_email'				=>	$dataCustomer->email,
				'customer_mobile'				=>	$dataCustomer->mobile,
				'ordered_datetime'			=>	$_POST['ordered_datetime'],
				'outlet_id'							=>	$dataOutlet->id,
				'outlet_name'						=>	$dataOutlet->name,
				'outlet_address'				=>	$dataOutlet->address,
				'outlet_contact'				=>	$dataOutlet->contact_number,
				'outlet_receipt_footer'	=>	$dataOutlet->receipt_footer,
				'subtotal'							=>	$_POST['subtotal'],
				'discount_total'				=>	$_POST['discount_total'],
				'discount_percentage'		=>	$_POST['discount_percentage'],
				'tax'										=>	$_POST['tax'],
				'grandtotal'						=>	$_POST['grandtotal'],
				'total_items'						=>	$_POST['total_items'],
				'payment_method'				=>	$dataPayment->id,
				'payment_method_name'		=>	$dataPayment->name,
				'paid_amt'							=>	$_POST['paid_amt'],
				'return_change'					=>	$_POST['return_change'],
				'created_user_id'				=>	$_POST['created_user_id'],
				'created_datetime'			=>	date('Y-m-d H:i:s'),
				'vt_status'							=>	'1',
				'status'								=>	'1',
				'refund_status'					=>	'0'
			];

			if($this->db->insert('orders', $insertOrders)){
				$order_id = $this->db->insert_id();
				
				foreach($_POST['dataProduk'] as $result){
					$produk = $this->db->where(['id' => $result['id']])->get('products')->row();
					array_push($dataProduk, [
						'order_id'					=> $order_id,
						'product_code'			=> $produk->code,
						'product_name'			=> $produk->name,
						'product_category'	=> $produk->category,
						'cost'							=> $produk->purchase_price,
						'price'							=> $produk->retail_price,
						'qty'								=> $result['qty'],
					]);
				}
				if($this->db->insert_batch('order_items', $dataProduk)){
					foreach($this->pos->updateStockItems($order_id, $dataOutlet->id) as $row){
						array_push($updateStock, [
								'rmo_id'					=> $row->rmo_id,
								'used_stock'		  => $row->up_use_stock,
								'update_date'			=> date('Y-m-d H:i:s'),
								'update_by'				=> $_POST['created_user_id'],
						]);
					}
					$this->db->update_batch('raw_material_outlet', $updateStock, 'rmo_id');
				}
				$this->res['success'] = true;
				$this->res['data'] 	  = [
					'order_items' 	=> $dataProduk,
					'url'				=> base_url().'api/view_invoice?id='.$order_id,
					'urlPdf'			=>	base_url().'api/printinvoicePdf?id='.$order_id,
				];
				$this->res['message'] = 'pembayaran berhasil dilakukan';
			}
		}
		echo json_encode($this->res);
	}

	function getRetur(){
		if(isset($_POST['outlet_id'])){
			$where = "";
			if(isset($_POST['no_trx'])){ $where .= ' and rh.trx_no like "%'.$_POST['no_trx'].'%"';}
			if(isset($_POST['rm_id'])){ $where .= ' and rd.rm_id = '.$_POST['rm_id'].'';}
			if(isset($_POST['tglAwal'])){ $where .= ' and rh.trx_date >= "'.$_POST['tglAwal'].'"';}
			if(isset($_POST['tglAkhir'])){ $where .= ' and rh.trx_date <= "'.$_POST['tglAkhir'].'"';}

			$query = $this->db->order_by('rh.trx_date', 'DESC')->select('rh.trx_date create_date, rh.trx_no, o.name outlet_name, s.name sup_name, rm.rm_name pro_name, rd.qty, rd.price_per_qty, 
						(rd.qty*rd.price_per_qty) total_price, rd.reason')
				->where('rh.outlet_id = '.$_POST['outlet_id'].' and rh.payment_method_id = 1'.$where)
				->join('return_raw_detail rd', 'rd.trx_no = rh.trx_no')
				->join('outlets o', 'o.id = rh.outlet_id')
				->join('suppliers s', 's.id = rd.supplier_id')
				->join('raw_material rm', 'rm.rm_id = rd.rm_id')
				->get('return_raw_header rh')->result();
			$this->res['success'] = true;
			$this->res['data'] = $query;
		}
		echo json_encode($this->res);
	}

	function getBahanMentah(){
		$this->res['message']	= 'gagal load data';
		if(isset($_POST['outlet_id'])){
			$data = $this->db->select('rmo.rm_id, rm.rm_name, rm.rm_code')
							->where(['rmo.outlet_id' => $_POST['outlet_id'], 'rmo.is_active' => 1])
							->join('raw_material rm', 'rm.rm_id = rmo.rm_id')
							->get('raw_material_outlet rmo')->result();
			$this->res['success'] = true;
			$this->res['data']		= $data;
			$this->res['message']	= 'success load data';
		}
		echo json_encode($this->res);
	}

	function getSupplier(){
		$data = $this->db->get('suppliers')->result();
		$this->res['success'] = true;
		$this->res['data']		= $data;
		$this->res['message']	= 'success load data';
		echo json_encode($this->res);
	}

	function addRetur(){
		$trxHeader = [
			'trx_no'          => date('ymdhis').rand(0,10000),
			'total_amount'   	=> $this->input->post('qty') * $this->input->post('price'),
			'trx_date'   			=> $this->input->post('trx_date'),
			'outlet_id'   		=> $this->input->post('outlet_id'),
			'create_date' 		=> date('Y-m-d H:i:s'),
			'create_by' 			=> $this->input->post('user_id'),
			'payment_method_id' => 1
		];
		$trxDetail = [
			'trx_no'  		=> $trxHeader['trx_no'],
			'rm_id'  			=> $this->input->post('rm_id'),
			'create_date' => date('Y-m-d H:i:s'),
			'create_by' 	=> $this->input->post('user_id'),
			'qty' 				=> $this->input->post('qty'),
			'price_per_qty' => $this->input->post('price'),
			'reason'		  => $this->input->post('reason'),
			'supplier_id' => $this->input->post('supplier_id')
		];

		if($this->db->insert('return_raw_header', $trxHeader)){
			if($this->db->insert('return_raw_detail', $trxDetail)){
				$totalStok = $this->db->where([
					'rm_id' 		=> $trxDetail['rm_id'],
					'outlet_id'	=> $trxHeader['outlet_id'],
					'is_active' => 1
				])->get('raw_material_outlet')->row()->total_stock - $trxDetail['qty'];
				if($this->db->where([
					'rm_id' 		=> $trxDetail['rm_id'],
					'outlet_id'	=> $trxHeader['outlet_id'],
					'is_active' => 1
					])->update('raw_material_outlet', [
						'total_stock' => $totalStok,
						'update_date' => date('Y-m-d H:i:s'),
						'update_by'		=> $trxHeader['create_by']
						])){
							$this->res['success'] = true;
							$this->res['data']		= $_POST;
							$this->res['message']	= 'Input data retur success';
						};
			}
		}

		echo json_encode($this->res);
	}

	public function view_invoice(){
		$id = $this->input->get('id');

		$data['order_id'] = $id;

		$data['lang_address'] = $this->lang->line('address');
		$data['lang_telephone'] = $this->lang->line('telephone');
		$data['lang_sale_id'] = $this->lang->line('sale_id');
		$data['lang_date'] = $this->lang->line('date');
		$data['lang_customer_name'] = $this->lang->line('customer_name');
		$data['lang_mobile'] = $this->lang->line('mobile');
		$data['lang_products'] = $this->lang->line('products');
		$data['lang_qty'] = $this->lang->line('qty');
		$data['lang_per_item'] = $this->lang->line('per_item');
		$data['lang_total'] = $this->lang->line('total');
		$data['lang_total_items'] = $this->lang->line('total_items');
		$data['lang_sub_total'] = $this->lang->line('sub_total');
		$data['lang_tax'] = $this->lang->line('tax');
		$data['lang_grand_total'] = $this->lang->line('grand_total');
		$data['lang_paid_amt'] = $this->lang->line('paid_amt');
		$data['lang_paid_by'] = $this->lang->line('paid_by');
		$data['lang_card_number'] = $this->lang->line('card_number');
		$data['lang_cheque_number'] = $this->lang->line('cheque_number');
		$data['lang_discount'] = $this->lang->line('discount');
		$data['lang_return_change'] = $this->lang->line('return_change');
		$data['lang_unpaid_amount'] = $this->lang->line('unpaid_amount');
		$data['lang_paid_by'] = $this->lang->line('paid_by');

		$this->load->view('api_print_invoice', $data);
	}

	public function printinvoicePdf(){
		$this->load->library('PdfGenerator');
		$id = $this->input->get('id');

		$data['order_id'] = $id;

		$data['lang_address'] = $this->lang->line('address');
		$data['lang_telephone'] = $this->lang->line('telephone');
		$data['lang_sale_id'] = $this->lang->line('sale_id');
		$data['lang_date'] = $this->lang->line('date');
		$data['lang_customer_name'] = $this->lang->line('customer_name');
		$data['lang_mobile'] = $this->lang->line('mobile');
		$data['lang_products'] = $this->lang->line('products');
		$data['lang_qty'] = $this->lang->line('qty');
		$data['lang_per_item'] = $this->lang->line('per_item');
		$data['lang_total'] = $this->lang->line('total');
		$data['lang_total_items'] = $this->lang->line('total_items');
		$data['lang_sub_total'] = $this->lang->line('sub_total');
		$data['lang_tax'] = $this->lang->line('tax');
		$data['lang_grand_total'] = $this->lang->line('grand_total');
		$data['lang_paid_amt'] = $this->lang->line('paid_amt');
		$data['lang_paid_by'] = $this->lang->line('paid_by');
		$data['lang_card_number'] = $this->lang->line('card_number');
		$data['lang_cheque_number'] = $this->lang->line('cheque_number');
		$data['lang_discount'] = $this->lang->line('discount');
		$data['lang_return_change'] = $this->lang->line('return_change');
		$data['lang_unpaid_amount'] = $this->lang->line('unpaid_amount');
		$data['lang_paid_by'] = $this->lang->line('paid_by');

		$html = $this->load->view('api_print_invoice_pdf', $data, true);
		$filename = 'Invoice_'+$id;
		$paper = 'letter';
		$orientation = 'portrait';
		$this->pdfgenerator->generate($html, $filename, $paper, $orientation);
	}
}
