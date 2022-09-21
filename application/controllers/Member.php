<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mem extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Member_model', 'sch_md', TRUE);
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
    
    
}