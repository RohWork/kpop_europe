<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {

    function __construct() {
        parent ::__construct();
        

        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
    }
    
    function main(){
        
        
        
    }
    
    function insert(){
        
        $data = array();
        
        $data['country'] = $this->cont_md->get_country();
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('city_insert',$data);
        $this->load->view('footer');
    }
    
    function insert_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        $params['country_idx'] = $this->input->post("check_country");
        $params['name'] = $this->input->post("input_city");
       
        
        $result = $this->city_md->insert_city($params);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = "data process error";
        }
        

        
        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    
    function get_ajax(){
                
        $data = array();
        
        $data['code'] = 200;
        $data['message'] = "";
        
        
        $country_idx = $this->input->post("country_idx");
        
        $result = $this->city_md->get_city($country_idx);
        
        if(!$result){
            $data['code'] = 400;
            $data['message'] = "data process error";
        }else{
            $data['result'] = $result;
        }
        
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
}