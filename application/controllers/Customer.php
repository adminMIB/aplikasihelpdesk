<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {

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
 function list_customer()
 {

        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/list_customer";
        $id_dept = trim($this->session->userdata('id_dept'));
        $id_user = trim($this->session->userdata('id_user'));  
        $data['data_customer']= $this->model_app->get_list_customer();      
        $data['flag'] = "view";
       
        $this->load->view('template', $data);

 }



 public function edit($id_customer){
        $data['header'] = "header/header";
        $data['navbar'] = "navbar/navbar";
        $data['sidebar'] = "sidebar/sidebar";
        $data['body'] = "body/edit_customer";
        $data['list_kategori'] =  $this->model_app->get_list_kategori();
        $data['list_teknisi'] =  $this->model_app->get_list_teknisi();
        $data['list_sub_kategori'] =  $this->model_app->get_list_sub_kategori();
        $id_dept = trim($this->session->userdata('id_dept'));
        $id_user = trim($this->session->userdata('id_user'));  
        $data['data_customer']= $this->model_app->get_detail_customer($id_customer);      
        $data['flag'] = "view";
       
        $this->load->view('template', $data);
 }

 public function submit_edit($id_customer)
 {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $customer = $this->model_app-> get_detail_customer($id_customer);
         $last_cust_id =  $this->model_app->get_last_cust_id();
         $old_customer_code = $customer->customer_code;
         $data_tbl_cust=array(
            'customer_code'         =>'customer_0'.($last_cust_id->s+1).'0'.$this->input->post('nama_cust').'0'.$this->input->post('nama_project'),
            'customer_reff'         =>$this->input->post('nama_cust'),
            'telepon'               =>$this->input->post('telepon'),
            'project_id'            =>$this->input->post('nama_project'),
            'sla'                   =>$this->input->post('sla'),
            'teknisi_id'            =>$this->input->post('nama_teknisi'),
            'token'                 =>$this->input->post('token'),
            
         );
         $data_tbl_user=array(
            'email'             =>  $this->input->post('email'),
            'username'     =>  $data_tbl_cust['customer_code']       
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
            if($this->model_app->update_customer($data_tbl_cust , $id_customer))
            {
                $this->model_app->update_user($data_tbl_user, $old_customer_code);
                $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg>Berhasil simpan data.
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

 public function save_token($id_customer)
 {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $this->input->post('token');
        if($token<0)
        {
            $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
            <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
            <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> Nilai token minimal 0.
            </div>");
            redirect($_SERVER['HTTP_REFERER']);
        }
        else{
            $this->model_app->update_token_customer($token , $id_customer);
             $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg>Berhasil simpan data.
                </div>");
                redirect($_SERVER['HTTP_REFERER']); 
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
 }

 public function delete($id_customer)
 {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $customer = $this->model_app-> get_detail_customer($id_customer);
       // print_r($customer);exit;
        $this->db->where('username',$customer->customer_code)->delete('user');
        $this->db->where('id_customer',$id_customer)->delete('customer');
         $this->session->set_flashdata("msg", "<div class='alert bg-success' role='alert'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg>Berhasil hapus data.
                </div>");
                redirect($_SERVER['HTTP_REFERER']); 
    }
 }
}
