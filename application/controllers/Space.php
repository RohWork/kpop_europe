<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Space extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        $this->load->model('space_model', 'sp_md', TRUE);
        
        $lang = $this->session->userdata('lang');
        $this->lang->load('controller', $lang);

        $lang_array = get_langueage_list();
    }
    
    public function index($page =0){
        $search['country'] = $this->session->userdata('country_idx');
        $search['city'] = $this->session->userdata('city_idx');
        
        if(!empty($this->input->get_post("country"))){
            $search['country'] = $this->input->get_post("country");
        }
        if(!empty($this->input->get_post("city"))){
            $search['city'] = $this->input->get_post("city");
        }
        
        $data['country_list'] = $this->cont_md->get_country();
        
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
        }else{
            $data['city_list'] = "";
        }
        
        
        $result = $this->sp_md->get_list($search);
        
        $this->load->library('pagination');
    
        $config['base_url'] = '/Space/list';
        $config['reuse_query_string'] = true;
        $config['total_rows'] = count($result);
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

        $this->load->view('space_list',$data);
        
        $this->load->view('footer');
        
    }
    
    function detail($idx){
        
        $data = array();
        
        $data['detail_info'] = $this->org_md->get_organization_idx($idx);
  
        $this->load->view('organization_detail',$data);
    }
    
    public function insert(){
        
    }
    
    public function add_set(){
        
    }
    
    public function modify(){
        
    }
    
    public function modify_set(){
        
    }
    
    public function delete(){
        
    }
    
    public function delete_set(){
        
    }
    
    
    
}

?>