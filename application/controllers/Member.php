<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Member_model', 'mem_md', TRUE);
    }
    function login(){
        
        $this->load->view('login');
        $this->load->view('footer');
    }
    
    function login_process(){
        
        
    }
    
    function join(){
        
    }
    
    function join_process(){
        
    }
    
    function mail_process(){
        
        
    }
    
    function set_member_google(){
        
        $id = $this->input->post("id");
        $name = $this->input->post("name");
        $image_url = $this->input->post("image_url");
        $email = $this->input->post("email");
        $nick = $this->input->post("nick");
        
        if(empty($id)){
            
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
                
                
            );
            $join_result = $this->mem_md->set_member($data);
        }
        
        if(empty($join_history) && !$join_result){
            
            $data['result'] = 201;
            
            
        }else{
            
            $result = $this->mem_md->get_member($email);
            
            $session_data = array(    //로그인 성공시 session 생성
                    'id'      => $result['id'],
                    'name'       => $result['name'],
                    'image_url'     => $result['image_url'],
                    'email'      => $result['email'],
                    'nick'      => $result['nick'],
            );

            $this->session->set_userdata($session_data);	//session 등록
            session_commit();

            $message = "";

            
            $data['result'] = 200;
            
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
}