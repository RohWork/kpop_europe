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
}