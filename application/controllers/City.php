<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {

    function __construct() {
        parent ::__construct();
        

        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
    }
    
    function index(){
        
        
        $data = array();
        $data['country_idx'] = $this->input->post_get("country");
        
        
        
        $data['list'] = $this->city_md->get_city($data['country_idx']);
        $data['country'] = $this->cont_md->get_country();
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('city_list', $data);
        $this->load->view('footer');
        
    }
    
    function detail($idx){
        
        $data = array();
        
        $data['detail_info'] = $this->city_md->get_city_idx($idx);
        $data['country'] = $this->cont_md->get_country();
        
        $this->load->view('city_detail',$data);
    }
    function modify_ajax(){
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        $params['city'] = $this->input->post("city");
        $params['city_idx'] = $this->input->post("city_idx");
        $params['country_idx'] = $this->input->post("country_idx");
        
        $result = $this->city_md->modify_city($params);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = "data process error";
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    
    function insert(){
        
        $data = array();
        
        
        $data['select_country'] = $this->input->get("country_idx");
        
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
        
        $city_order = count($this->city_md->get_city($params['country_idx']));
        $params['ord'] = $city_order++;
        
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
    
    function delete_ajax(){
        
        $data = array();
        $image_data = array();
        
        $idx= $this->input->post("idx");

       
        
        if(!empty($idx)){
            
            $this->city_md->delete_city($idx);
            
            $data['result'] = 200;

            
        }else{
            $data['message'] = "Check To you're idx";

            $data['result'] = 201;
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
}