<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

function __construct(){
        parent::__construct();
        $this->load->model('model_app');
    }
 public function send_notif_ticket_to_email()
 {
    //check semua ticket yang belum dinotif,dan sudah lewat batas 5 hari.
    error_reporting(0);
    $cur_date = date('Y-m-d H:i:s');
    $list_ticket = $this->model_app->check_ticket_for_notif_email();  
    $email_admin =  $this->model_app->get_list_email_admin();
    //print_r($list_ticket);
    foreach($list_ticket as $l)
    {
        $list_emails=array();
        $d['emails'] = array();
        $d['id_ticket']  = $l->id_ticket;
        array_push($d['emails'], $l->email);
        foreach($email_admin as $a)
        {
            array_push($d['emails'], $a->email);
        }
        $d['emails']=array_unique($d['emails']);
        //print_r($d['emails']);exit;
        foreach($d['emails'] as $d_email)
        {
            $data_level = $this->model_app->get_user_level_by_email($d_email);
            //print_r($data_level);
            $level =  $data_level->level;
            $username = $data_level->username;
            if($level=='TEKNISI')
            {
                //ambil notifikasi email belum dibaca buat si admin
                $notif_ticket=$this->model_app->get_ticket_belum_dibaca($username , $level);
                $data['list_email_unread'] =  $notif_ticket;
                $data['level']='TEKNISI';
                $data['email']=$d_email;
                //print_r($notif_ticket);exit;

            }
            else if($level=='ADMIN')
            {
                 $notif_ticket=$this->model_app->get_ticket_belum_dibaca($username , $level);
                 $data['list_email_unread'] =  $notif_ticket;
                 $data['level']='ADMIN';
                 $data['email']=$d_email;
            }
            $msg = "Kamu memiliki notifikasi tiket dengan id ". $d['id_ticket'].' . Silahkan dilakukan monitoring';
            //set status email attempt jadi 1,
            $this->model_app->update_notif_email_attempt($d['id_ticket']);
            $data['id_ticket'] = $d['id_ticket'];
            $this->lib->sendEmail(null,null,$d_email , null, $data , 'notifikasi_ticket_unread');
        }
    }
 }

}
