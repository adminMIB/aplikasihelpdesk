<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {

function __construct(){
        parent::__construct();
        $this->load->model('model_app');

        if(!$this->session->userdata('id_user'))
       {
        $this->session->set_flashdata("msg", "<div class='alert alert-info'>
       <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
       <strong><span class='glyphicon glyphicon-remove-sign'></span></strong> Silahkan login terlebih dahulu.
       </div>");
        redirect('login');
        }
        
    }


 function hapus()
 {
 	$id = $_POST['id'];

 	$this->db->trans_start();

 	$this->db->where('nik', $id);
 	$this->db->delete('karyawan');

 	$this->db->trans_complete();
	
 }

 function add()
 {

 	    $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/form_ticket";

        $id_dept = trim($this->session->userdata('id_dept'));
        $id_user = trim($this->session->userdata('id_user'));

        //notification 

        $sql_listticket = "SELECT COUNT(id_ticket) AS jml_list_ticket FROM ticket WHERE status = 2";
        $row_listticket = $this->db->query($sql_listticket)->row();

        $data['notif_list_ticket'] = $row_listticket->jml_list_ticket;

        $sql_approvalticket = "SELECT COUNT(A.id_ticket) AS jml_approval_ticket FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN karyawan D ON D.nik = A.reported 
        LEFT JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept WHERE E.id_dept = $id_dept AND status = 1";
        $row_approvalticket = $this->db->query($sql_approvalticket)->row();

        $data['notif_approval'] = $row_approvalticket->jml_approval_ticket;

        $sql_assignmentticket = "SELECT COUNT(id_ticket) AS jml_assignment_ticket FROM ticket WHERE status = 3 AND id_teknisi='$id_user'";
        $row_assignmentticket = $this->db->query($sql_assignmentticket)->row();

        $data['notif_assignment'] = $row_assignmentticket->jml_assignment_ticket;

        //end notification
        
        $id_user = trim($this->session->userdata('id_user'));

        $cari_data = "select A.nik, A.nama, C.nama_dept, B.nama_bagian_dept FROM karyawan A
        							   LEFT JOIN bagian_departemen B ON B.id_bagian_dept = A.id_bagian_dept
        							   LEFT JOIN departemen C ON C.id_dept = B.id_dept
        							   WHERE A.nik = '$id_user'";

        $row = $this->db->query($cari_data)->row();

        $data['id_ticket'] = "";

        $data['id_user'] = $id_user;
        $data['nama'] = $row->nama;
        $data['departemen'] = $row->nama_dept;
        $data['bagian_departemen'] = $row->nama_bagian_dept;		
		
		$data['dd_kategori'] = $this->model_app->dropdown_kategori();
		$data['id_kategori'] = "";

		$data['dd_kondisi'] = $this->model_app->dropdown_kondisi();
		$data['id_kondisi'] = "";

		$data['problem_summary'] = "";
		$data['problem_detail'] = "";

		$data['status'] = "";
		$data['progress'] = "";

		$data['url'] = "ticket/save";

		$data['flag'] = "add";
    
        $this->load->view('template', $data);

 }

 function add_2()
 {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/form_ticket_2";
        $id_dept = trim($this->session->userdata('id_dept'));
        $id_user = trim($this->session->userdata('id_user'));        
        $data['flag'] = "add";
        $data['list_kategori'] =  $this->model_app->get_list_kategori();
        $data['list_teknisi'] =  $this->model_app->get_list_teknisi();
        $data['list_sub_kategori'] =  $this->model_app->get_list_sub_kategori();
        $this->load->view('template', $data);

 }

 function add_ticket_customer()
 {
        if(!$this->session->userdata('is_customer')===true)
        {
            redirect(base_url('/dashboard'));
        }
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/add_ticket_customer";
        $id_user = trim($this->session->userdata('id_user'));        
        $data['flag'] = "add";
        $data['data_cust']= $this->model_app->get_detail_cust($id_user);
        $this->load->view('template', $data);
 }

 function submit_add_ticket_customer($customer_code)
 {
    if(!$this->session->userdata('is_customer')===true)
    {
        redirect(base_url('/dashboard'));
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //check token
        
        $id_user = strtoupper(trim($this->session->userdata('id_user')));
        $q= $this->model_app->get_detail_cust_by_cust_code($id_user);
        //print_r($q);exit;
        if($q->token<1)
        {
             $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg>Maaf, Anda Tidak Bisa Create Ticket , Karena Jumlah Token Kurang, Segera Hubungi Operator.
            </div>");
            redirect($_SERVER['HTTP_REFERER']);
        }
        $tanggal = $time = date("Y-m-d  H:i:s");
        $config['upload_path']          = './assets/images/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 1000;
        $config['max_width']            = 1224;
        $config['max_height']           = 1204;
        $image['file_name']='';
        $this->load->library('upload', $config);
 
        if ( ! $this->upload->do_upload('foto')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $image = $this->upload->data();
            //echo $image['file_name'];exit;
        }

        $getkodeticket = $this->model_app->getkodeticket();
        $getkodeticket = $getkodeticket."-0".$q->id_customer."0".$q->customer_reff."0".$q->project_id;
        $data=array(
            'id_ticket'         => $getkodeticket,
            'id_sub_kategori'   => $this->input->post('id_sub_kategori'),
            'problem_summary'   => $this->input->post('subject_problem'),
            'problem_detail'   => $this->input->post('deskripsi'),
            'id_teknisi'   => $this->input->post('id_teknisi'),
            'progress'   => 0,
            'reported'      => $id_user,
            'status'        => 4,
            'tanggal'       => $tanggal,
            'batas_tanggal_notif'              => date ("Y-m-d H:i:s", strtotime ($tanggal ."+5 hours")),
            'email_notif_attempt'   =>0,
            'user_file'     =>  $image['file_name']
        );
        $tracking['id_ticket'] = $getkodeticket;
        $tracking['tanggal'] = $tanggal;
        $tracking['status'] = "Created Ticket";
        $tracking['deskripsi'] = "";
        $tracking['id_user'] = $id_user;
        //print_r($trans_start);exit;
        $this->db->trans_start();
        $this->db->insert('ticket', $data);
        $this->db->insert('tracking', $tracking);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data gagal tersimpan.
            </div>");
            redirect($_SERVER['HTTP_REFERER']);
        } 
        else 
        {
            //kurangi jumlah token
            $array_email=array();
            $this->model_app->set_token_customer($id_user,'minus',1);

            $email_admin =  $this->model_app->get_list_email_admin();
            $email_teknisi =  $this->model_app->get_email_teknisi_by_ticket_id($getkodeticket);
            foreach($email_admin as $a)
            {
                array_push($array_email, $a->email);                
            }
            array_push($array_email, $email_teknisi->email);
            $array_email = array_unique($array_email);
            foreach($array_email as $emails)
            {
                $data['customer_name'] = $q->nama_kategori;
                $this->lib->sendEmail(null,null,$emails ,null , $data , 'send_after_create_ticket');
            }
            
            $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data tersimpan.
            </div>");
            redirect($_SERVER['HTTP_REFERER']);     
        }
    }
    else{

    }
 }

 function submit_new_user2()
 {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //get max customer_id
        $last_cust_id =  $this->model_app->get_last_cust_id();
        //print_r($last_cust_id);exit;
         $data_tbl_cust=array(
            'customer_code'         =>'customer_0'.($last_cust_id->s+1).'0'.$this->input->post('nama_cust').'0'.$this->input->post('nama_project'),
            'customer_reff'       =>$this->input->post('nama_cust'),
            'telepon'       =>$this->input->post('telepon'),
            'project_id'    =>$this->input->post('nama_project'),
            'sla'           =>$this->input->post('sla'),
            'teknisi_id'    =>$this->input->post('nama_teknisi'),
            'token'         =>$this->input->post('token'),
            
         );
         //print_r($data_tbl_cust);exit;
         $data_tbl_user=array(
            'username'          => $data_tbl_cust['customer_code'],
            'password'          =>md5($this->input->post('password')),
            'level'             => 'CUSTOMER' ,
            'email'             =>  $this->input->post('email')       
         );
         if($data_tbl_cust['token']<0)
         {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Nilai token minimal 0.
                </div>");
                redirect($_SERVER['HTTP_REFERER']); 
         }
         else{
            if($this->model_app->save_customer($data_tbl_cust))
            {
                $this->model_app->save_user($data_tbl_user);
                $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg>Berhasil update data.
                </div>");
                redirect($_SERVER['HTTP_REFERER']); 
            }
            else{
                $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Customer sudah ada.
                </div>");
                redirect($_SERVER['HTTP_REFERER']); 
            }
            
         }
    }
 }

 function save()
 {

 	$getkodeticket = $this->model_app->getkodeticket();
	
	$ticket = $getkodeticket;

 	$id_user = strtoupper(trim($this->input->post('id_user')));
    $tanggal = $time = date("Y-m-d  H:i:s");

 	$id_sub_kategori = strtoupper(trim($this->input->post('id_sub_kategori')));
 	$problem_summary = strtoupper(trim($this->input->post('problem_summary')));
 	$problem_detail = strtoupper(trim($this->input->post('problem_detail')));
 	$id_teknisi = strtoupper(trim($this->input->post('id_teknisi')));
 	
 	$data['id_ticket'] = $ticket;
 	$data['reported'] = $id_user;
 	$data['tanggal'] = $tanggal;
 	$data['id_sub_kategori'] = $id_sub_kategori;
 	$data['problem_summary'] = $problem_summary;
 	$data['problem_detail'] = $problem_detail;
 	$data['id_teknisi'] = $id_teknisi;
 	$data['status'] = 1;
 	$data['progress'] = 0;

 	$tracking['id_ticket'] = $ticket;
 	$tracking['tanggal'] = $tanggal;
 	$tracking['status'] = "Created Ticket";
 	$tracking['deskripsi'] = "";
 	$tracking['id_user'] = $id_user;

 	$this->db->trans_start();

 	$this->db->insert('ticket', $data);
 	$this->db->insert('tracking', $tracking);

 	$this->db->trans_complete();

 	if ($this->db->trans_status() === FALSE)
			{
				$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data gagal tersimpan.
			    </div>");
				redirect('myticket/myticket_list');	
			} else 
			{
				$this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Data tersimpan.
			    </div>");
				redirect('myticket/myticket_list');		
			}
		
 }

 


    
}
