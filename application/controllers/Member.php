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
                
                
            );
            $join_result = $this->mem_md->set_member($data);
        }
        
        if(empty($join_history) && !$join_result){
            
            $data['result'] = 201;
            
            
        }else{
            
            $result = $this->mem_md->get_member($email);
            

            $this->session->set_userdata($result);	//session 등록
            session_commit();

            $message = "";

            
            $data['result'] = 200;
            
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
}