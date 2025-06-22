<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Member_model', 'mem_md', TRUE);
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        $this->load->model('Bookmark_model', 'mark_md', TRUE);
        
        $lang = $this->session->userdata('lang');
        
        if(empty($lang)){
            $lang = "en"; 
        }
        $this->lang->load('controller', $lang);

    }
    function login(){
        
        $this->load->view('login');
        
    }
    
    function login_process(){
        
        $email= $this->input->post("login_email");
        $pass = md5($this->input->post("login_pass"));

        
        
        $result = $this->mem_md->login_check_member($email, $pass);
        
        if($result){
            
            if($result['state'] == "1"){
            
                $this->session->set_userdata($result);	//session 등록
                session_commit();
                session_write_close();

                $data['message'] = $this->lang->line('hi').", ".$result['nick'];

                $data['result'] = 200;
            }else{
                $data['message'] = $this->lang->line('mailerror2');

                $data['result'] = 202;
            }
            
        }else{
            $data['message'] = $this->lang->line('checkid');

            $data['result'] = 201;
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    function logout(){
        
        $this->session->sess_destroy();
        sleep(1);
        header('Location: /main');
    }
    
    function join(){
        
        $this->load->view('join');
        

    }
    
    function mail_check(){
        
        $email = $this->input->post("check_email");

        
        $join_history = $this->mem_md->get_member($email);
        
        
        if(empty($join_history)){
            $data['result'] = 200;
        }else{
            $data['result'] = 201;
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    function join_process(){
        
                
        $email = $this->input->post("user_email");
        $password = md5($this->input->post("user_pass1"));
        $name = $this->input->post("user_name1").".".$this->input->post("user_name2");
        $nick = $this->input->post("user_name1");
        $id = md5(date('Y-m-d h:i:s'));
        
        if(empty($id) || empty($name)){
            
            return;
            
        }
        
        
        $join_history = $this->mem_md->get_member($email);
        $join_result = false;
                
        if(empty($join_history)){
            
            $data = array(
                "id" => $id,
                "name" => $name,
                "password" => $password,
                "email" => $email,
                "nick" => $nick,
                "type"  => 2 ,
                
            );
            $join_result = $this->mem_md->set_member($data);
            
            if(!$join_result){

                $data['message'] = $this->lang->line('dataerror2');

                $data['result'] = 201;


            }else{


                $data['message'] = "";

                $data['result'] = 200;

            }
            
        }else{
            

            $data['message'] = $this->lang->line('mailerror');

            $data['result'] = 202;
            
        }

        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    
    function mail_process(){
        
        $mail = $this->input->get("email");
        
        $result = $this->mem_md->get_member($mail);
        
        $config = array(
	'protocol' => "smtp",
	'smtp_host' => "smtp.daum.net",
	'smtp_port' => "465",//"587", // 465 나 587 중 하나를 사용
	'smtp_user' => "nocy12",
	'smtp_pass' => "dhxacdtntjgjflxc",
	'charset' => "utf-8",
	'mailtype' => "html",
	'smtp_timeout' => 10,
        'send_multipart' => true, 
        'smtp_crypto' => 'ssl'
);

        // gmail smtp 메일 발송
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->clear();
        $this->email->from("admin@kpopineu.com", "kpopineu");
        $this->email->to($mail);
        $this->email->subject($this->lang->line('confirm'));
        $this->email->message($this->lang->line('visit').'<a href=https://www.kpopineu.com/member/confirm_email?id='.$result['id'].'>'.$this->lang->line('url').'</a>');
        
        if($this->email->send()) {
                 $this->load->view('mail_process');
        } else {
                echo $this->email->print_debugger();
        }

    }
    
    function confirm_email(){
        
        $id = $this->input->get("id");
        
        if(empty($id)){
            echo $this->lang->line('idcheck');
            return;
        }else{
            $result = $this->mem_md->set_id_member($id); 
            

            $this->load->view('confirm_email');

        }
        
        
    }
    
    function set_member_google(){
        
        $id = $this->input->post("id");
        $name = $this->input->post("name");
        $image_url = $this->input->post("image_url");
        $email = $this->input->post("email");
        $nick = $this->input->post("nick");
        
        if(empty($id) || empty($name)){
            
            return;
            
        }
        
        
        $join_history = $this->mem_md->get_member($email);
        $join_result = false;
                
        if(empty($join_history)){
            
            $data = array(
                "id" => $id,
                "name" => $name,
                "image_url" => $image_url,
                "email" => $email,
                "nick" => $nick,
                "type" => 1,
                'state' => 1,
                'level' => $join_history['level'],
            );
            $join_result = $this->mem_md->set_member($data);
        }
        
        if(empty($join_history) && !$join_result){
            
            $data['result'] = 201;
            
            
        }else{
            
            $result = $this->mem_md->get_member($email);

            $this->session->set_userdata($result);	//session 등록
            session_commit();
            session_write_close();
            
            $message = "";

            $data['result'] = 200;
            
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    function my_info(){
        
        $data = array();
        
        $this->load->helper('alert');
        
        if(empty($this->session->userdata('email'))){
            alert_move($this->lang->line('loginerror'), '/member/login');
        }
        
        $user_mail = $this->session->userdata('email');
        
        $data['mode'] = $mode =  $this->input->get_post("mode");
        
        $data['user_info'] = $this->mem_md->get_member($user_mail);
        
        $data['country_list'] = $this->cont_md->get_country();
        
        
        
        if(empty($mode)){
            $data['mode'] = $mode = "after";
        }
        
        if($mode == "before"){
            
            $year = $data['year'] =  $this->input->get_post("year");
            if(empty($year)){
                $year = $data['year'] = date('Y');
            }
            
            
            $data['bookmark_list'] = $this->mark_md->get_history($user_id , $year);
        }else{
            $data['bookmark_list'] = $this->mark_md->list($user_id );
        }
        
        if(!empty($data['user_info']['country'])){
            $data['city_list'] = $this->city_md->get_city($data['user_info']['country']);
        }else{
            $data['city_list'] = "";
        }
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('my_info',$data);
        $this->load->view('footer');
        
        
        
    }
    
    public function my_info_set(){
        
        $this->load->helper('alert');
        
        if(empty($this->session->userdata('id'))){
            alert_move($this->lang->line('loginerror'), '/member/login');
        }
        
        $params = array();
        
        $id = $this->session->userdata('id');
        
        $params['country_idx'] = $this->input->post("country");
        $params['city_idx'] = $this->input->post("city");
        $params['language'] = $this->input->post("language");
        
        
        $result = $this->mem_md->modify_member($params, $id);
        
        
        $params['lang'] = $this->input->post("language");
        
        $this->session->set_userdata($params);
        
        
        $lang = $params['lang'];
        
        $this->lang->load('controller', $lang);
        
        if(empty($this->session->userdata('id'))){
            alert_move($this->lang->line('dataerror2'), '/member/my_info');
        }else{
        
            alert_move($this->lang->line('procok'), '/member/my_info');
        }
    }
    
    function my_bookmark(){
        
        $data = array();
        
        $this->load->helper('alert');
        
        if(empty($this->session->userdata('id'))){
            alert_move($this->lang->line('loginerror'), '/member/login');
        }
        
        
        $user_id = $this->session->userdata('id');

        $search = array();
        
        
        $data['mode'] = $mode =  $this->input->get_post("mode");
        
        if(empty($mode)){
            $data['mode'] = $mode = "after";
        }
        
        if($mode == "before"){
            
            $year = $data['year'] =  $this->input->get_post("year");
            if(empty($year)){
                $year = $data['year'] = date('Y');
            }
            
            
            $data['bookmark_list'] = $this->mark_md->get_history($user_id , $year);
        }else{
            $data['bookmark_list'] = $this->mark_md->list($user_id );
        }
        


        
        $this->load->view('header');
        $this->load->view('sidebar');
        if($mode == "before"){
            $this->load->view('my_bookmark_history',$data);
        }else{
            $this->load->view('my_bookmark',$data);
        }
        
        $this->load->view('footer');
        
        
    }
    
    function bookmark_frame_list(){
        
        $search = array();
        
        $search['date'] = $this->input->get_post("date");
        $user_id = $this->session->userdata('id');
        
        $data = array();
        $data['list'] = $this->mark_md->list($user_id,$search['date']);
        
        if(confirm_mobile()){ //MOBILE
            $this->load->view('/mobile/frame_list',$data);
        }else{
            $this->load->view('frame_list',$data);
        }
    }
    
    function delete_bookmark(){
        
        $data = array();
        $params = array();
        
        $idx= $this->input->post("idx");
        $params['state'] = 2;
        
        if(!empty($idx)){
            
            $this->mark_md->modify($params, $idx);

            $data['result'] = 200;
            
        }else{

            $data['message'] = $this->lang->line('idxerror');

            $data['result'] = 201;
            
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
        
}