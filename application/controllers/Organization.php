<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Organization_model', 'org_md', TRUE);
    }
}