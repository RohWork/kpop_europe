<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Community extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Community_model', 'com_md', TRUE);
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
    }

    function list($page =0){
        
        $search = array();
        $data = array();
        
        $search['country'] = $this->input->get_post("country");
        $search['city'] = $this->input->get_post("city");
        $search['language'] = $this->input->get_post("language");
        
        if(empty($search['language'])){
            $search['language'] = $this->session->userdata('lang');
        }
        
        $data['country_list'] = $this->cont_md->get_country();
        
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
        }else{
            $data['city_list'] = "";
        }
        
        $result = $this->com_md->get_list($search);
        
        $this->load->library('pagination');
    
        $config['base_url'] = '/schedule/list';
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
        $this->load->view('community_list',$data);
        $this->load->view('footer');
        
    }
    
    function write(){
        
        if(empty($this->session->userdata('name') )){
            header('Location: /member/login');
        }
        
        $data = array();
        
        $data['country_list'] = $this->cont_md->get_country();
        
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
        }else{
            $data['city_list'] = "";
        }
        
        $data['language'] = $this->session->userdata('lang');
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('community_write', $data);
        $this->load->view('footer');
    }
    
    function image_upload(){
        
        $this->load->helper(array('form', 'url'));
        
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $config['upload_path']          = SET_IMAGE_PATH.'/community';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload()){
            //$this->upload->display_errors()
            $data = array('error' => $config['upload_path']);
        }else{
            
            $file = $this->upload->data();
            $filename = $file['file_name'];
            
            $url = "/asset/image/community/".$filename;
            
            $data = array("url"=>$url);
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
    }
}
?>
