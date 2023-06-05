<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Community extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Community_model', 'com_md', TRUE);
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        
        $lang = $this->session->userdata('lang');
        $this->lang->load('controller', $lang);

        $lang_array = get_langueage_list();
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
        $search = array();
        
        $data['country_list'] = $this->cont_md->get_country();
        
        $search['country'] = $this->input->get_post("country");
        $search['city'] = $this->input->get_post("city");
        $search['language'] = $this->input->get_post("language");
        
        
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
        }else{
            $data['city_list'] = "";
        }
        
        $data['language'] = $this->session->userdata('lang');
        $data['search'] = $search;
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('community_write', $data);
        $this->load->view('footer');
    }
    
    function write_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        $params['country_idx'] = $this->input->post("country");
        $params['city_idx'] = $this->input->post("city");
        $params['language'] = $this->input->post("language");
        $params['title'] = $this->input->post("title");
        $params['content'] = $this->input->post("content");
       

        $result = $this->com_md->insert_community($params);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }

        header("Content-Type: application/json;");
        echo json_encode($data);
        
        
    }
    
    function detail($idx){
        
        $data = array();
        
        $data['detail'] = $this->com_md->detail_community($idx);
        $data['comment'] = $this->com_md->comment_community($idx, 1);
        $data['sub_comment'] = $this->com_md->comment_community($idx, 2);
        $data['idx'] = $idx;
        
        $cnt = $this->com_md->count_community($idx);
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('community_detail', $data);
        $this->load->view('footer');
        
        
    }
    
    function modify($idx){
        
        $data['detail'] = $detail =  $this->com_md->detail_community($idx);
        $data['idx'] = $idx;
        
        $data['country_list'] = $this->cont_md->get_country();
        
        if(!empty($detail['country_idx'])){
            $data['city_list'] = $this->city_md->get_city($detail['country_idx']);
        }else{
            $data['city_list'] = "";
        }
        
        $cnt = $this->com_md->count_community($idx);
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('community_modify', $data);
        $this->load->view('footer');
    }
    
    function modify_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        $params['country_idx'] = $this->input->post("country");
        $params['city_idx'] = $this->input->post("city");
        $params['language'] = $this->input->post("language");
        $params['title'] = $this->input->post("title");
        $params['content'] = $this->input->post("content");
        $idx = $this->input->post("idx");
        
        $result = $this->com_md->modify_community($params, $idx);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }

        header("Content-Type: application/json;");
        echo json_encode($data);
        
        
    }
    
    function like_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $mode = "like";
        $idx = $this->input->post("idx");
        
        $result = $this->com_md->like_community($idx, $mode);
    }
    function hate_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $mode = "hate";
        $idx = $this->input->post("idx");
        
        $result = $this->com_md->like_community($idx, $mode);
    }
    
    function delete_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        $params['state'] = 2;

        $idx = $this->input->post("idx");

        $result = $this->com_md->modify_community($params, $idx);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }

        header("Content-Type: application/json;");
        echo json_encode($data);
        
        
    }
    
    function comment_write_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        
        $params = array();
        $params['community_idx'] = $this->input->post("community_idx");
        $params['content'] = $this->input->post("comment");
        
        if(empty($this->session->userdata('name') )){
            $data['result'] = 401;
            $data['message'] = $this->lang->line('loginerror');
        }else{
        
        
            $result = $this->com_md->insert_comment($params);

            if(!$result){
                $data['result'] = 400;
                $data['message'] = $this->lang->line('dataerror');
            }
        }

        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    function comment_modify_ajax(){
        
         $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        $params['content'] = $this->input->post("content");
        $idx = $this->input->post("idx");

        $result = $this->com_md->modify_comment($params, $idx);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }

        header("Content-Type: application/json;");
        echo json_encode($data);
    }
    
    function comment_delete_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        $idx = $this->input->post("idx");
        $params['state'] = 2;
        
        $result = $this->com_md->modify_comment($params, $idx);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }

        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    function comment_like_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $mode = "like";
        $idx = $this->input->post("idx");
        
        $result = $this->com_md->like_comment($idx, $mode);
    }
    function comment_hate_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $mode = "hate";
        $idx = $this->input->post("idx");
        
        $result = $this->com_md->like_comment($idx, $mode);
    }
    
    
    function image_upload(){
        
        $this->load->helper(array('form', 'url'));
        
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        //$config['upload_path']          = SET_IMAGE_PATH.'community';
        $config['upload_path']          = './asset/image/community';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 10000;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;

        $this->load->library('upload', $config);
        
        if ( ! $this->upload->do_upload("upload")){
            //$this->upload->display_errors();
            $data = array('error' => $this->upload->display_errors());
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
