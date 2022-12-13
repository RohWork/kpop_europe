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
}