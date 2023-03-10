<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Organization_model', 'org_md', TRUE);
    }
    
    function index(){
        $data = array();
        
        $data['list'] = $this->org_md->get_organization();
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('organization_list',$data);
        $this->load->view('footer');
    }
    function detail($idx){
        
        $data = array();
        
        $data['detail_info'] = $this->org_md->get_organization_idx($idx);
  
        $this->load->view('organization_detail',$data);
    }
    function insert(){
        $data = array();
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('organization_insert',$data);
        $this->load->view('footer');
    }
    
    function insert_ajax(){
        
        $data = array();
        $params = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params['organization'] = $this->input->post("input_organization");
        
        $org_order = count($this->org_md->get_organization());
        $params['ord'] = $org_order+1;
        
        $result = $this->org_md->insert_organization($params);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = "data process error";
        }

        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    
    function modify_ajax(){
        
        $data = array();
        $params = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params['organization'] = $this->input->post("organization");
        $params['ord'] = $this->input->post("order");
        
        $organization_idx = $this->input->post("organization_idx");
        $result = $this->org_md->modify_organization($params,$organization_idx);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = "data process error";
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    
    function delete_ajax(){
        
        $data = array();
        $image_data = array();
        
        $idx= $this->input->post("idx");

       
        
        if(!empty($idx)){
            
            $this->org_md->delete_organization($idx);
            
            $data['result'] = 200;

            
        }else{
            $data['message'] = "Check To you're idx";

            $data['result'] = 201;
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
}