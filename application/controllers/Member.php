<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Member_model', 'mem_md', TRUE);
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

                $data['message'] = "hello ".$result['nick'];

                $data['result'] = 200;
            }else{
                $data['message'] = "this E-mail is not confirmed. Take to E-mail confirm";

                $data['result'] = 202;
            }
            
        }else{
            $data['message'] = "Check To you're ID or PASSWORD";

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

                $data['message'] = "Data processing failure";

                $data['result'] = 201;


            }else{


                $data['message'] = "";

                $data['result'] = 200;

            }
            
        }else{
            

            $data['message'] = "Duplicate email. Check to your email adress.";

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
	'smtp_host' => "ssl://smtp.daum.net",
	'smtp_port' => "465",//"587", // 465 나 587 중 하나를 사용
	'smtp_user' => "roh",
	'smtp_pass' => "s3628742",
	'charset' => "utf-8",
	'mailtype' => "html",
	'smtp_timeout' => 10,
);

        // gmail smtp 메일 발송
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->clear();
        $this->email->from("admin@kpopineu.com", "kpopineu");
        $this->email->to($mail);
        $this->email->subject('Confirm to your address');
        $this->email->message('visit to : <a href=https://www.kpopineu.com/member/confirm_email?id='.$result['id'].'>this url</a>');
        
        if($this->email->send()) {
                 $this->load->view('mail_process');
        } else {
                echo $this->email->print_debugger();
        }

    }
    
    function confirm_email(){
        
        $id = $this->input->get("id");
        
        if(empty($id)){
            echo "id is null";
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
}