<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template404 extends CI_Controller {
   public $VIEW_DIR = 'web/';
   public function __construct()
   {
		parent::__construct(); 
     
   }

   public function page404()
   {
      //untuk 404 page
      $this->output->set_status_header('404'); 
      $data=array();
    	$this->load->view($this->VIEW_DIR.'404',$data);
   }

}
