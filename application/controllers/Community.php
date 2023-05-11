<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Community extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Community_model', 'com_md', TRUE);

    }

    function list($page =0){
        
        $search = array();
        $search['country'] = $this->input->get("country");
        $search['city'] = $this->input->get("city");
        $search['language'] = $this->input->get("language");
        
        if(empty($search['language'])){
            $search['language'] = $this->session->userdata('lang');
        }
        
        $data = $this->com_md->get_list($search);
        
        $this->load->library('pagination');
    
        $config['base_url'] = '/schedule/list';
        $config['reuse_query_string'] = true;
        $config['total_rows'] = count($data);
        $config['per_page'] = 10;
        $config['attributes'] = array('class' => 'page-link');
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
        
        $paging = array(
            "start" => $page,
            "end"   => $config['per_page']
        );
        
        $data['list'] = $this->com_md->get_list($search, $paging);
        
        
        $data['search'] = $search;
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('community_list',$data);
        $this->load->view('footer');
        
    }
    
    function write(){
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('community_write');
        $this->load->view('footer');
    }
}
?>
