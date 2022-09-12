<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent ::__construct();
    }
    function index(){
        
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('main');
        $this->load->view('footer');
    }
    
    function calendar(){
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('calendar');
        $this->load->view('footer');
    }

}