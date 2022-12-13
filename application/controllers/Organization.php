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
  
        $this->load->view('country_detail',$data);
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
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $organization = $this->input->post("input_organization");
        $result = $this->org_md->insert_organization($organization);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = "data process error";
        }

        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
}