<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct(){
        parent::__construct();
        $this->load->model('model_app');
        
    }

    
function index()
    {
        $data = "";

        $this->load->view('login', $data);
    }

   function login_customer()
   {
   	  $data = "";

        $this->load->view('login_cust', $data);
   }

   function submit_login_customer()
   {
   	 $username = trim($this->input->post('username'));
	  	$password = md5(trim($this->input->post('password')));
	  	
		$akses = $this->db->query("select A.customer_code, B.username, B.level FROM customer A 
			LEFT JOIN user B ON B.username = A.customer_code
		 WHERE B.username = '$username' AND B.password = '$password'");

	    if($akses->num_rows() == 1)
		{
			$d= $akses->result_array();
			foreach($d as $data)
			{

				$session['id_user'] = $data['username'];
				$session['nama'] = $data['username'];
				$session['level'] = $data['level'];
				$session['is_customer'] = true;
				$this->session->set_userdata($session);
			    redirect('home');
			}
		
		}
		else
		{
		$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
				    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
				    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> username / Password salah.
				    </div>");
		redirect('login/login_customer');
		}
   }


  function login_akses()
  {

  	$username = trim($this->input->post('username'));
  	$password = md5(trim($this->input->post('password')));
  	
	$akses = $this->db->query("select A.username, B.nama, A.level, B.id_jabatan, A.level, C.id_dept FROM user A 
		LEFT JOIN karyawan B ON B.nik = A.username
        LEFT JOIN bagian_departemen C ON C.id_bagian_dept = B.id_bagian_dept
	 WHERE A.username = '$username' AND A.password = '$password'");
    
    if($akses->num_rows() == 1)
	{
	
		foreach($akses->result_array() as $data)
		{
            //print_r($data);exit;
            if($data['level']=='CUSTOMER')
            {
                
                $this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> login customer tidak diizinkan.
			    </div>");
	            redirect('login');
            }
			$session['id_user'] = $data['username'];
			$session['nama'] = $data['nama'];
			$session['level'] = $data['level'];
			$session['id_jabatan'] = $data['id_jabatan'];
			$session['id_dept'] = $data['id_dept'];
			
			$this->session->set_userdata($session);
		    redirect('home');
		}
	
	}
	else
	{
	$this->session->set_flashdata("msg", "<div class='alert bg-danger' role='alert'>
			    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
			    <svg class='glyph stroked empty-message'><use xlink:href='#stroked-empty-message'></use></svg> username / Password salah.
			    </div>");
	redirect('login');
	}

	
  }


  public function logout() {

  $this->session->sess_destroy();

  redirect('login');
    


}


    
}
