<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib {
   
   public function __construct()
   {
   	$this->CI =& get_instance();
      $this->CI->load->helper('url');
      $this->CI->load->model('model_app');
      //Lib::get_notif_tiket_unread();
   }

   public function get_notif_tiket_unread()
   {
      if($this->CI->session->userdata('level')=='ADMIN')
      {
         $total_notif = count($this->CI->model_app->get_count_notif_unread('ADMIN'));
         if($total_notif>0)
         {
            $_SESSION['is_show_popup_unread_notif']=true;
            return $total_notif;
         }
         else{
            return 0;
         }
      }
      else if($this->CI->session->userdata('level')=='TEKNISI')
      {
         $total_notif = count($this->CI->model_app->get_count_notif_unread('TEKNISI'));
         if($total_notif>0)
         {
            $_SESSION['is_show_popup_unread_notif']=true;
            return $total_notif;
         }
         else{
            return 0;
         }
      }
   }

   public function sendEmail($userIdRecipient=null,$from=null,$to=null , $cc=null , $data=null , $type)
   {     
      $from ='admin1@test.com';
     // echo $to;
      $to   = $to;
      $cc   = $cc;
      $userIdRecipient = $userIdRecipient;
      $config['protocol'] = 'sendmail';
      $config['mailpath'] = '/usr/sbin/sendmail';
      $config['charset']  = 'iso-8859-1';
      $config['wordwrap'] = TRUE;
      $config['mailtype'] = 'html';
      $this->CI->email->initialize($config);
      $this->CI->email->from($from, 'TEST 123');
      $this->CI->email->to($to); 
      if($type=='notifikasi_ticket_unread')
      {
         $data_to_send=$data;
         $subject='Notifikasi Tiket';
         $message=$this->CI->load->view('email_template/notifikasi_ticket_unread',$data_to_send,true); 
         //print_r($message);
      }
      else if($type=='send_after_create_ticket')
      {
         $data_to_send = $data;
         $subject='Notifikasi Tiket';
         $message=$this->CI->load->view('email_template/new_ticket',$data_to_send,true); 
         //print_r($message);
      }
      $this->CI->email->subject($subject);
      $this->CI->email->message(stripslashes($message));
      if($this->CI->email->send())
      {
              
      }        
  }
}