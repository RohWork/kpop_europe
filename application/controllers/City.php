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
}