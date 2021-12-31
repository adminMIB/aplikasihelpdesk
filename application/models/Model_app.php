<?php

class Model_app extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    //  ================= AUTOMATIC CODE ==================
    public function getkodeticket()
    {
        $query = $this->db->query("select max(id_ticket) as max_code FROM ticket");

        $row = $query->row_array();

        $max_id = $row['max_code'];
        $max_fix = (int) substr($max_id, 9, 4);

        $max_nik = $max_fix + 1;

        $tanggal = $time = date("d");
        $bulan = $time = date("m");
        $tahun = $time = date("y");

        $nik = "T".date("ymdHis");
        return $nik;
    }

    public function getkodekaryawan()
    {
        $query = $this->db->query("select max(nik) as max_code FROM karyawan");

        $row = $query->row_array();

        $max_id = $row['max_code'];
        $max_fix = (int) substr($max_id, 1, 4);

        $max_nik = $max_fix + 1;

        $nik = "K".sprintf("%04s", $max_nik);
        return $nik;
    }

     public function getkodeteknisi()
    {
        $query = $this->db->query("select max(id_teknisi) as max_code FROM teknisi");

        $row = $query->row_array();

        $max_id = $row['max_code'];
        $max_fix = (int) substr($max_id, 1, 4);

        $max_id_teknisi = $max_fix + 1;

        $id_teknisi = "T".sprintf("%04s", $max_id_teknisi);
        return $id_teknisi;
    }

     public function getkodeuser()
    {
        $query = $this->db->query("select max(id_user) as max_code FROM user");

        $row = $query->row_array();

        $max_id = $row['max_code'];
        $max_fix = (int) substr($max_id, 1, 4);

        $max_id_user = $max_fix + 1;

        $id_user = "U".sprintf("%04s", $max_id_user);
        return $id_user;
    }
    
    public function datajabatan()
    {
    $query = $this->db->query('SELECT * FROM jabatan');
    return $query->result();
    }

    public function datakaryawan()
    {
    $query = $this->db->query('SELECT A.nama, A.nik, A.alamat, A.jk, C.nama_bagian_dept, B.nama_jabatan, D.nama_dept
                               FROM karyawan A LEFT JOIN jabatan B ON B.id_jabatan = A.id_jabatan
                                               LEFT JOIN bagian_departemen C ON C.id_bagian_dept = A.id_bagian_dept
                                               LEFT JOIN departemen D ON D.id_dept = C.id_dept');
    return $query->result();
    }

    public function datalist_ticket($login_type=null , $arg1=null)
    {
        if($login_type==null)
        {
           $query = $this->db->query("SELECT D.nama, F.nama_dept, A.jenis_urgensi,A.status,A.problem_summary,A.user_file, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori,A.is_read_by_admin
                                   FROM ticket A 
                                   LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                                   LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
                                   LEFT JOIN karyawan D ON D.nik = A.reported
                                   LEFT JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept
                                   LEFT JOIN departemen F ON F.id_dept = E.id_dept
                                   WHERE A.status IN (2,3,4,5,6) 
                                   ORDER BY A.tanggal DESC"); 
        }
        else if($login_type=='customer'){
            $query = $this->db->query("SELECT D.nama, F.nama_dept, A.jenis_urgensi,A.status,A.problem_summary,A.user_file, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori,A.is_read_by_admin ,history_feedback.feedback , teknisi.id_teknisi
                                   FROM ticket A 
                                   LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                                   LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
                                   LEFT JOIN karyawan D ON D.nik = A.reported
                                   LEFT JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept
                                   LEFT JOIN departemen F ON F.id_dept = E.id_dept
                                   LEFT JOIN history_feedback ON history_feedback.id_ticket = A.id_ticket
                                   LEFT JOIN teknisi ON teknisi.id_teknisi = A.id_teknisi
                                   WHERE A.status IN (2,3,4,5,6)  AND A.reported ='".$arg1."' ORDER BY A.tanggal DESC"); 
        }
        return $query->result();

    }

    public function data_trackingticket($id)
    {

        $query = $this->db->query("SELECT A.tanggal, A.status, A.deskripsi, B.nama
                                   FROM tracking A 
                                   LEFT JOIN karyawan B ON B.nik = A.id_user
                                   WHERE A.id_ticket ='$id'");
        return $query->result();

    }


    public function datainformasi()
    {

        $query = $this->db->query("SELECT A.tanggal, A.subject, A.pesan, C.nama, A.id_informasi
                                   FROM informasi A 
                                   LEFT JOIN karyawan C ON C.nik =  A.id_user
                                   WHERE A.status = 1");
        return $query->result();

    }

    public function datamyticket($id)
    {
        $query = $this->db->query("SELECT A.progress, A.tanggal_proses, A.tanggal_solved, A.id_teknisi, D.feedback, A.status, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori
                                   FROM ticket A 
                                   LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                                   LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                                   LEFT JOIN history_feedback D ON D.id_ticket = A.id_ticket
                                   WHERE A.reported = '$id' ");
    return $query->result();
    }


    public function datamyassignment($id)
    {
        $query = $this->db->query("SELECT A.progress,A.jenis_urgensi,A.user_file,A.problem_summary, A.is_read_by_admin , A.is_read_by_teknisi, A.status, A.id_ticket, A.reported, A.tanggal, B.nama_sub_kategori, C.nama_kategori
                                   FROM ticket A 
                                   LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                                   LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
                                   LEFT JOIN karyawan D ON D.nik = A.reported
                                   LEFT JOIN teknisi E ON E.id_teknisi = A.id_teknisi
                                   LEFT JOIN karyawan F ON F.nik = E.nik
                                   WHERE F.nik = '$id'
                                   AND A.status IN (3,4,5,6) ORDER BY A.tanggal DESC
                                   ");
        return $query->result();
    }

     public function dataapproval($id)
    {
    $query = $this->db->query("SELECT A.status, D.nama ,A.status, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori 
        FROM ticket A 
        LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori 
        LEFT JOIN kategori C ON C.id_kategori = B.id_kategori
        LEFT JOIN karyawan D ON D.nik = A.reported 
        LEFT JOIN bagian_departemen E ON E.id_bagian_dept = D.id_bagian_dept WHERE E.id_dept = $id AND A.status = 1 OR  A.status= 0");
    return $query->result();
    }

     public function datadepartemen()
    {
    $query = $this->db->query('SELECT * FROM departemen');
    return $query->result();
    }

     public function databagiandepartemen()
    {
    $query = $this->db->query('SELECT * FROM bagian_departemen A LEFT JOIN departemen B ON B.id_dept = A.id_dept ');
    return $query->result();
    }

    public function datakondisi()
    {
    $query = $this->db->query('SELECT * FROM kondisi');
    return $query->result();
    }

    public function datateknisi()
    {
    $query = $this->db->query('SELECT A.point, A.id_teknisi, B.nama, B.jk, C.nama_kategori, A.status, A.point FROM teknisi A 
                                LEFT JOIN karyawan B ON B.nik = A.nik
                                LEFT JOIN kategori C ON C.id_kategori = A.id_kategori
                                
                                 ');
    return $query->result();
    }


    public function datareportteknisi($id)
    {
     $query = $this->db->query("SELECT A.progress, A.tanggal_proses, A.status, A.problem_summary, B.nama, D.nama_kategori, F.nama_dept  FROM ticket A 
                                LEFT JOIN karyawan B ON B.nik = A.reported
                                LEFT JOIN sub_kategori C ON C.id_sub_kategori = A.id_sub_kategori
                                LEFT JOIN kategori D ON D.id_kategori = C.id_kategori
                                LEFT JOIN bagian_departemen E ON E.id_bagian_dept = B.id_bagian_dept
                                LEFT JOIN departemen F ON F.id_dept = E.id_dept
                                WHERE id_teknisi = '$id'"                        
                                 );
    return $query->result();
    }


    public function datauser()
    {
         $query = $this->db->query('SELECT A.username, A.level,A.email, A.id_user, B.nik, B.nama, A.password, C.id_dept, D.nama_dept 
            FROM user A LEFT JOIN karyawan B ON B.nik = A.username 
            LEFT JOIN bagian_departemen C ON C.id_bagian_dept = B.id_bagian_dept 
            LEFT JOIN departemen D ON D.id_dept = C.id_dept
                                 ');

         return $query->result();

    }

    public function datakategori()
    {
    $query = $this->db->query('SELECT * FROM kategori');
    return $query->result();
    }

    public function dataassigment($id)
    {
    $query = $this->db->query('SELECT A.status, D.nama, C.id_kategori, A.id_ticket, A.tanggal, B.nama_sub_kategori, C.nama_kategori
                FROM ticket A 
                LEFT JOIN sub_kategori B ON B.id_sub_kategori = A.id_sub_kategori
                LEFT JOIN kategori C ON C.id_kategori = B.id_kategori 
                LEFT JOIN karyawan D ON D.nik = A.reported 
                WHERE A.id_teknisi = "$id"');
    return $query->result();
    }

    public function datasubkategori()
    {
    $query = $this->db->query('SELECT * FROM sub_kategori A LEFT JOIN kategori B ON B.id_kategori = A.id_kategori ');
    return $query->result();
    }


    public function dropdown_departemen()
    {
        $sql = "SELECT * FROM departemen ORDER BY nama_dept";
            $query = $this->db->query($sql);
            
            $value[''] = '-- PILIH --';
            foreach ($query->result() as $row){
                $value[$row->id_dept] = $row->nama_dept;
            }
            return $value;
    }

    public function dropdown_kategori()
    {
        $sql = "SELECT * FROM kategori ORDER BY nama_kategori";
        $query = $this->db->query($sql);
            
            $value[''] = '-- PILIH --';
            foreach ($query->result() as $row){
                $value[$row->id_kategori] = $row->nama_kategori;
            }
            return $value;
    }

    public function dropdown_karyawan()
    {
        $sql = "SELECT A.nama, A.nik FROM karyawan A 
                LEFT JOIN bagian_departemen B ON B.id_bagian_dept = A.id_bagian_dept
                LEFT JOIN departemen C ON C.id_dept = B.id_dept 
                ORDER BY nama";
        $query = $this->db->query($sql);
            
            $value[''] = '-- PILIH --';
            foreach ($query->result() as $row){
                $value[$row->nik] = $row->nama;
            }
            return $value;
    }

    public function dropdown_jabatan()
    {
        $sql = "SELECT * FROM jabatan ORDER BY nama_jabatan";
        $query = $this->db->query($sql);
            
        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row){
            $value[$row->id_jabatan] = $row->nama_jabatan;
        }
        return $value;
    }

    public function dropdown_kondisi()
    {
        $sql = "SELECT * FROM kondisi ORDER BY nama_kondisi";
        $query = $this->db->query($sql);
            
        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row){
            $value[$row->id_kondisi] = $row->nama_kondisi."  -  (TARGET PROSES ".$row->waktu_respon." "."HARI)";
        }
        return $value;
    }

    public function dropdown_bagian_departemen($id_departemen)
    {
        $sql = "SELECT * FROM bagian_departemen where id_dept ='$id_departemen' ORDER BY nama_bagian_dept";
        $query = $this->db->query($sql);
            
        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row){
            $value[$row->id_bagian_dept] = $row->nama_bagian_dept;
        }
        return $value;
    }

    public function dropdown_sub_kategori($id_kategori)
    {
        $sql = "SELECT * FROM sub_kategori where id_kategori ='$id_kategori' ORDER BY nama_sub_kategori";
        $query = $this->db->query($sql);
            
        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row){
            $value[$row->id_sub_kategori] = $row->nama_sub_kategori;
        }
        return $value;
    }

    function dropdown_teknisi($id_kategori)
    {

        $sql = "SELECT A.id_teknisi, B.nama, B.jk, C.nama_kategori, A.status, A.point FROM teknisi A 
                                LEFT JOIN karyawan B ON B.nik = A.nik
                                LEFT JOIN kategori C ON C.id_kategori = A.id_kategori
                                WHERE A.id_kategori ='$id_kategori'";
        $query = $this->db->query($sql);
            
        $value[''] = '-- PILIH --';
        foreach ($query->result() as $row){
            $value[$row->id_teknisi] = $row->nama;
        }
        return $value;

    }


    public function dropdown_jk()
    {
        $value[''] = '--PILIH--';            
        $value['LAKI-LAKI'] = 'LAKI-LAKI';
        $value['PEREMPUAN'] = 'PEREMPUAN';           
            
            return $value;
    }

    public function dropdown_level()
    {
        $value[''] = '--PILIH--';            
        $value['ADMIN'] = 'ADMIN';
        $value['TEKNISI'] = 'TEKNISI';
        $value['USER'] = 'USER';           
            
            return $value;
    }

    public function get_list_kategori()
    {
        return $this->db->select('*')->from('kategori')->get()->result();
    }

    public function get_list_teknisi()
    {
        return $this->db->select('teknisi.*,karyawan.nama,kategori.nama_kategori')->from('teknisi')
        ->join('karyawan','karyawan.nik =  teknisi.nik','left')
        ->join('kategori','kategori.id_kategori =  teknisi.id_kategori','left')
        ->get()->result();
    }
   
    public function get_list_sub_kategori()
    {
        return $this->db->select('sub_kategori.*,kategori.nama_kategori')->from('sub_kategori')->join('kategori','kategori.id_kategori =  sub_kategori.id_kategori','left')->get()->result();
    }

    public function save_customer($data_tbl_cust)
    {
        $c = $this->db->select('*')->from('customer')->where('customer_code',$data_tbl_cust['customer_code'])->get()->result();
        if(empty($c))
        {
           $this->db->insert('customer',$data_tbl_cust);
           return true; 
        }
        else{
            return false;
        }
        
    }
   
    public function save_user($data_tbl_user)
    {
        $this->db->insert('user',$data_tbl_user);
    }

    public function get_list_customer()
    {
        return $this->db->select('customer.*,sub_kategori.nama_sub_kategori,teknisi.id_teknisi,user.email as customer_email ,kategori.nama_kategori')
        ->from('customer')
        ->join('kategori','kategori.id_kategori =  customer.customer_reff','left')
        ->join('sub_kategori','customer.project_id =  sub_kategori.id_sub_kategori','left')
        ->join('teknisi','teknisi.id_teknisi =  customer.teknisi_id','left')
        ->join('user','user.username =  customer.customer_code','left')
        ->order_by('id_customer','DESC')
        ->get()->result();
    }

    public function get_detail_customer($id_customer)
    {
        return $this->db->select('customer.*,sub_kategori.nama_sub_kategori,teknisi.id_teknisi,user.email as customer_email')
        ->from('customer')
        ->join('sub_kategori','customer.project_id =  sub_kategori.id_sub_kategori','left')
        ->join('teknisi','teknisi.id_teknisi =  customer.teknisi_id','left')
        ->join('user','user.username =  customer.customer_code','left')
        ->where('id_customer',$id_customer)
        ->get()->row();
    }

    public function get_detail_cust_by_cust_code($customer_code)
    {
        return $this->db->select('customer.*,sub_kategori.nama_sub_kategori,teknisi.id_teknisi , kategori.nama_kategori')
        ->from('customer')
        ->join('sub_kategori','customer.project_id =  sub_kategori.id_sub_kategori','left')
        ->join('kategori','customer.customer_reff =  kategori.id_kategori','left')
        ->join('teknisi','teknisi.id_teknisi =  customer.teknisi_id','left')
        ->where('customer_code',$customer_code)
        ->get()->row();
    }

    public function update_customer($data_tbl_cust , $id_customer)
    {
        $c = $this->db->select('*')->from('customer')->where('customer_code',$data_tbl_cust['customer_code'])->where('id_customer <>',$id_customer)->get()->result();
        if(empty($c))
        {
             $q= $this->db->set($data_tbl_cust)->where('id_customer',$id_customer)->update('customer');
            if($q)
            {
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
    }

    public function update_user($data, $username)
    {
        $q= $this->db->set($data)->where('username',$username)->update('user');
        if($q)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function update_user_pwd($data_tbl_user)
    {
        $q= $this->db->set('password',$data_tbl_user['password'])->where('username',$data_tbl_user['username'])->where('level','CUSTOMER')->update('user');
        if($q)
        {
            return true;
        }
        else{
            return false;
        }
    }
    public function update_token_customer($token , $id_customer)
    {
        $q= $this->db->set('token',$token)->where('id_customer',$id_customer)->update('customer');
        if($q)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function get_detail_cust($id_user)
    {
        $d= $this->db->select('customer.* ,kategori.nama_kategori , sub_kategori.nama_sub_kategori,user.email as customer_email')
        ->from('customer')
        ->join('kategori','kategori.id_kategori = customer.customer_reff','left')
        ->join('sub_kategori','sub_kategori.id_sub_kategori = customer.project_id','left')
        ->join('user','user.username =  customer.customer_code','left')
        ->where('customer.customer_code',$id_user)
        ->get()->row();
        return $d;
    }

    public function set_token_customer($customer_code,$type,$value)
    {
        if($type='minus')
        {
            $this->db->set('token','`token`-'.$value , FALSE)->where('customer_code',$customer_code)->update('customer');
        }
    }

    public function check_ticket_for_notif_email()
    {
        $q = $this->db->select('ticket.id_ticket,user.email, ticket.id_ticket')->from('ticket')
        ->join('teknisi','teknisi.id_teknisi = ticket.id_teknisi','left')
        ->join('user','user.username = teknisi.nik','left')
        //->where('batas_tanggal_notif < ',date('Y-m-d H:i:s'))
        ->where('email_notif_attempt',0)->where('is_act_by_teknisi',false)->get()->result();
        return $q;
    }

    public function get_list_email_admin()
    {
        $q = $this->db->select('user.email')->from('user')->where('level','ADMIN')->get()->result();
        
        return $q;
    }

    public function update_notif_email_attempt($id_ticket)
    {
        $this->db->set('email_notif_attempt',1)->where('id_ticket',$id_ticket)->update('ticket');
    }

    public function set_act_ticket_teknisi($id_ticket)
    {
        $this->db->set('is_act_by_teknisi',1)->where('id_ticket',$id_ticket)->update('ticket');
    }

    public function get_count_notif_unread($level)
    {
        if($level=='ADMIN')
        {
            $q= $this->db->select('*')->from('ticket')->where('is_read_by_admin',false)->get()->result();
            return $q;
        }
        else if($level=='TEKNISI')
        {
            $p = $this->db->select('id_teknisi')->from('teknisi')->where('nik',$this->session->userdata('id_user'))->get()->result();
            $arr=array();
            foreach($p as $new_p)
            {
                array_push($arr, $new_p->id_teknisi);
            }
            //print_r($arr);exit;
            $q= $this->db->select('*')->from('ticket')->where('is_read_by_teknisi',false)->where_in('id_teknisi',$arr)->get()->result();
            return $q;
        }
    }

    public function set_status_read_by_teknisi($id_ticket)
    {
        $this->db->set('is_read_by_teknisi',true)->where('id_ticket',$id_ticket)->update('ticket');
    }
    public function set_status_read_by_admin($id_ticket)
    {
        $this->db->set('is_read_by_admin',true)->where('id_ticket',$id_ticket)->update('ticket');
    }
    public function set_direspon_teknisi($id_ticket)
    {
         $this->db->set('is_act_by_teknisi',true)->where('id_ticket',$id_ticket)->update('ticket');
    }

    public function get_user_level_by_email($d_email)
    {
        $q= $this->db->select('level , username')->from('user')->where('email',$d_email)->get()->row();
        return $q;
    }

    public function get_ticket_belum_dibaca($username , $level)
    {
        if($level=='TEKNISI')
        {
            $q= $this->db->select('ticket.id_ticket,ticket.reported,ticket.problem_summary,ticket.tanggal,ticket.user_file,ticket.jenis_urgensi,kategori.nama_kategori,sub_kategori.nama_sub_kategori')->from('ticket')
            ->join('teknisi','teknisi.id_teknisi = ticket.id_teknisi','left')
            ->join('user','user.username = teknisi.nik','left')
            ->join('customer','customer.customer_code = ticket.reported','left')
            ->join('kategori','customer.customer_reff = kategori.id_kategori','left')
            ->join('sub_kategori','sub_kategori.id_sub_kategori = customer.project_id','left')
            ->where('user.username',$username)->where('level','TEKNISI')->where('is_read_by_teknisi',false)->get()->result();
            return $q;
        }
        else if($level=='ADMIN')
        {
            $q= $this->db->select('ticket.id_ticket,ticket.reported,ticket.problem_summary,ticket.tanggal,ticket.user_file,ticket.jenis_urgensi,kategori.nama_kategori,sub_kategori.nama_sub_kategori')->from('ticket')
            ->join('customer','customer.customer_code = ticket.reported','left')
            ->join('kategori','customer.customer_reff = kategori.id_kategori','left')
            ->join('sub_kategori','sub_kategori.id_sub_kategori = customer.project_id','left')
            ->where('is_read_by_admin',false)->get()->result();
            return $q;
        }
    }

    public function get_last_cust_id()
    {
        $q= $this->db->select('MAX(id_customer) as s')->from('customer')->get()->row();
        return $q;
    }

    public function get_nama_teknisi_by_id($id_teknisi)
    {
        $q =  $this->db->select('teknisi.* , karyawan.nama')->from('teknisi')
        ->join('karyawan','teknisi.nik = karyawan.nik','left')
        ->where('teknisi.id_teknisi',$id_teknisi)->get()->row();
        if(empty($q))
        {
            return null;
        }
        else{
           return $q->nama; 
        }
        
    }

    public function get_email_teknisi_by_ticket_id($getkodeticket)
    {
         $q = $this->db->select('ticket.id_ticket,user.email, ticket.id_ticket')->from('ticket')
        ->join('teknisi','teknisi.id_teknisi = ticket.id_teknisi','left')
        ->join('user','user.username = teknisi.nik','left')
        ->where('ticket.id_ticket',$getkodeticket)->get()->row();
        return $q;
    }
}