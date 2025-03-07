<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Space extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $lang = $this->session->userdata('lang');
        $this->lang->load('controller', $lang);
        
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        $this->load->model('Space_model', 'space_md', TRUE);
        
    }
    
    public function index(){
        
        $data = array();
        $search = array();
        
        

        $search['country'] = $this->input->get_post("country");
        
        if(empty($search['country'])){
            $search['country'] = 1;
        }
        $search['city'] = $this->input->get_post("city");

        
        $data['country_list'] = $this->cont_md->get_country();
        
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
            
            if(empty($search['city'])){
                $search['city'] = $data['city_list'][0]['idx'];
            }
        }else{
            $data['city_list'] = "";
            
        }
        
        
        
        $data['list'] = $this->space_md->get_space($search);
        
        $data['search'] = $search;
       
        
        $this->load->view('header');
        $this->load->view('sidebar');

        $this->load->view('space/space_list',$data);
        
        $this->load->view('footer');
        
    }
    
    function detail($idx){
        
        $data = array();
        
         $detail = $this->space_md->get_space_idx($idx);

        $data['country_list'] = $this->cont_md->get_country();
       
        $get_country = $this->input->get('country_idx');
        if(!empty($get_country)){
            $detail['country_idx'] = $get_country;
            
        }
        
        $data['detail_info'] = $detail;
        $data['city_list'] = $this->city_md->get_city($detail['country_idx']);
        $data['space_idx'] = $idx;
  
        $this->load->view('space/space_detail',$data);
    }
    
    public function modify_ajax(){
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        
        $params['country_idx'] = $this->input->post("country_idx");
        $params['city_idx'] = $this->input->post("city_idx");
        $params['space_name'] = $this->input->post("space_name");
        $params['space_location'] = $this->input->post("space_location");
        $params['space_x'] = $this->input->post("space_x");
        $params['space_y'] = $this->input->post("space_y");
        $idx = $this->input->post("space_idx");
        
        $result = $this->space_md->modify_space($params, $idx);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    

    
    public function delete_ajax(){
        
        $data = array();
        $image_data = array();
        
        $idx= $this->input->post("idx");

       
        
        if(!empty($idx)){
            
            $params = array(
                        "state" => "N"
                      );
            
            $this->space_md->modify_space($params,$idx);
            
            $data['result'] = 200;

            
        }else{
            $data['message'] = $this->lang->line('idxerror');

            $data['result'] = 201;
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    
    public function insert(){
        
        $data = array();
        $search = array();
        
        

        $search['country'] = $this->input->get_post("country_idx");

        $search['city'] = $this->input->get_post("city_idx");
        
        if(empty($search['country'])){
            $search['country'] = 1;
        }
        
        $data['country_list'] = $this->cont_md->get_country();
        
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
        }else{
            $data['city_list'] = "";
        }
        
        
        
        $data['list'] = $this->space_md->get_space($search);
        
        $data['search'] = $search;
       
        
        $this->load->view('header');
        $this->load->view('sidebar');

        $this->load->view('space/space_insert',$data);
        
        $this->load->view('footer');
    }
    
    public function insert_ajax(){
                $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        
        $params['country_idx'] = $this->input->post("country_idx");
        $params['city_idx'] = $this->input->post("city_idx");
        $params['space_name'] = $this->input->post("space_name");
        $params['space_location'] = $this->input->post("space_location");
        $params['space_x'] = $this->input->post("space_x");
        $params['space_y'] = $this->input->post("space_y");

        
        $result = $this->space_md->insert_space($params);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    
    function get_ajax(){
                
        $data = array();
        
        $data['code'] = 200;
        $data['message'] = "";
        
        $search = array();
        $search['country'] = $this->input->post("country_idx");
        $search['city'] = $this->input->post("city_idx");
        
        $result = $this->space_md->get_space($search);
        
        if(!$result){
            $data['code'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }else{
            $data['result'] = $result;
        }
        
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    function get_addr_ajax(){
                
        $data = array();
        
        $data['code'] = 200;
        $data['message'] = "";
        
        $idx = $this->input->post("space_idx");

        
        $result = $this->space_md->get_space_idx($idx);
        
        if(!$result){
            $data['code'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }else{
            $data['result'] = $result;
        }
        
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    
    
}

?>