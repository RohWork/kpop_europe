<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Country extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Country_model', 'cont_md', TRUE);

    }
    
    function index(){
        $data = array();
        
        $data['list'] = $this->cont_md->get_country();
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('country_list',$data);
        $this->load->view('footer');
    }
    
    function detail($idx){
        
        $data = array();
        
        $data['detail_info'] = $this->cont_md->get_country_idx($idx);
  
        
        $this->load->view('country_detail',$data);
    }
    
    function insert(){
        
        $data = array();
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('country_insert',$data);
        $this->load->view('footer');
        
    }
    
    function insert_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $country = $this->input->post("input_country");
        $result = $this->cont_md->insert_country($country);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = "data process error";
        }
        

        
        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    
    function modify_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $country = $this->input->post("country");
        $country_idx = $this->input->post("country_idx");
        $result = $this->cont_md->modify_country($country,$country_idx);
        
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
            
            $this->cont_md->delete_country($idx);
            
            $data['result'] = 200;

            
        }else{
            $data['message'] = "Check To you're idx";

            $data['result'] = 201;
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
}