<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Schedule_model', 'sch_md', TRUE);
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        $this->load->model('Organization_model', 'org_md', TRUE);
    }
    function index(){
        
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('main');
        $this->load->view('footer');
    }
    
}