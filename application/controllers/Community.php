<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Community extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Community_model', 'com_md', TRUE);
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        $this->load->model('Schedule_model', 'sch_md', TRUE);
        
        $lang = $this->session->userdata('lang');
        $this->lang->load('controller', $lang);

        $lang_array = get_langueage_list();
    }

    function list($page =0){
        
        $search = array();
        $data = array();
        
        $search['type'] = $this->input->get_post("type");
        
        if(empty($search['type'])){
             $search['type'] = 1;
        }
        $search['country'] = $this->session->userdata('country_idx');
        $search['city'] = $this->session->userdata('city_idx');
        $search['language'] = $this->session->userdata('lang');
        
        if(!empty($this->input->get_post("country"))){
            $search['country'] = $this->input->get_post("country");
        }
        if(!empty($this->input->get_post("city"))){
            $search['city'] = $this->input->get_post("city");
        }
        if(!empty($this->input->get_post("language"))){
            $search['language'] = $this->input->get_post("language");
        }
        if(!empty($this->input->get_post("language"))){
            $search['kpop_idx'] = $this->input->get_post("kpop_idx");
        }
        
        $data['country_list'] = $this->cont_md->get_country();
        
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
        }else{
            $data['city_list'] = "";
        }
        
        $data['schedule_list'] = $this->sch_md->get_schedule($search);
        
        
        $result = $this->com_md->get_list($search);
        
        $this->load->library('pagination');
    
        $config['base_url'] = '/community/list';
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
        if($search['type'] == 2){
            $this->load->view('kpop_community_list',$data);
        }else{
            $this->load->view('community_list',$data);
        }
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
        $params['hashtag'] = $this->input->post("hashtag");
        

        

        $result = $this->com_md->insert_community($params);
        
        if(!$result){
            $data['result'] = 400;
            
            $data['message'] = $this->lang->line('dataerror');
        }
        $data['idx'] = $result;

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
        $params['hashtag'] = $this->input->post("hashtag");
        
        $idx = $this->input->post("idx");
        

        
        $result = $this->com_md->modify_community($params, $idx);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }

        header("Content-Type: application/json;");
        echo json_encode($data);
        
        
    }
    
    function like_community_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $lang = $this->session->userdata('lang');
        $this->lang->load('view', $lang);

        
        $mode = $this->input->post("mode");
        $idx = $this->input->post("idx");
        
        if(empty($this->session->userdata('name') )){
            $data['result'] = 401;
            $data['message'] = $this->lang->line('loginerror');
        }else if(count($this->com_md->get_like_history($idx, "community", $mode, 0) )> 0){
            
            $this->com_md->modify_like_history($idx, $mode, "community", 0);
            $result = $this->com_md->cancel_like_community($idx, $mode);
            
            if(!$result){
                $data['result'] = 400;
                $data['message'] = $this->lang->line('dataerror');
            }
            
        }else{
            
            
            $this->com_md->set_like_history($idx, $mode, "community", 0);
            $result = $this->com_md->like_community($idx, $mode);
            
            if($mode == 2){
                $dis_info = $this->com_md->detail_community($idx);
                if($dis_info['hate'] >= 10){
                    $params = array("state" => "2");
                    $this->com_md->modify_community($params, $idx);
                }
            }
            
            if(!$result){
                $data['result'] = 400;
                $data['message'] = $this->lang->line('dataerror');
            }
        }
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }

    
    function delete_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $params = array();
        if($this->session->userdata('level') > 2){
            $params['state'] = 4;
        }else{
            
            $params['state'] = 3;
        }

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
        if($this->session->userdata('level') > 2){
            $params['state'] = 4;
        }else{
            $params['state'] = 3;
        }
        
        $result = $this->com_md->modify_comment($params, $idx);
        
        if(!$result){
            $data['result'] = 400;
            $data['message'] = $this->lang->line('dataerror');
        }

        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    function like_comment_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $lang = $this->session->userdata('lang');
        $this->lang->load('view', $lang);

        $mode = $this->input->post("mode");
        $idx = $this->input->post("idx");
        $board_idx = $this->input->post("board_idx");
        
        
        if(empty($this->session->userdata('name') )){
            $data['result'] = 401;
            $data['message'] = $this->lang->line('loginerror');
        }else{
            if(count($this->com_md->get_like_history($board_idx, "comment", $mode, $idx)) > 0){   //중복된 추천,비추천인경우 이전의 추천,비추천 취소

                $this->com_md->modify_like_history($board_idx,$mode,"comment", $idx);
                $result = $this->com_md->cancel_like_comment($idx, $mode);


                if(!$result){
                    $data['result'] = 400;
                    $data['message'] = $this->lang->line('dataerror');
                }
            }else{  //중복되지 않은 추천인경우 이전의 추천, 비추천 제거후 추천, 비추천  
                
                if($mode == 1){
                    $switch_mode = 2;
                }else{
                    $switch_mode = 1;
                }
                
                if(count($this->com_md->get_like_history($board_idx, "comment", $switch_mode, $idx)) > 0){ //반대의 추천, 비추천이 있을경우 해당 반대도 취소처리후 처리
                    $this->com_md->modify_like_history($board_idx,$switch_mode,"comment", $idx);
                    $result = $this->com_md->cancel_like_comment($idx, $switch_mode);
                }
                

                $this->com_md->set_like_history($board_idx, $mode, "comment", $idx);
                $result = $this->com_md->like_comment($idx, $mode);

                if($mode == 2){
                    $dis_info = $this->com_md->get_comment_info($idx);
                    if($dis_info->hate >= 10){
                        $params = array("state" => "2");
                        $this->com_md->modify_comment($params, $idx);
                    }
                }

                if(!$result){
                    $data['result'] = 400;
                    $data['message'] = $this->lang->line('dataerror');
                }
            }
        }
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }

    function re_comment_write_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        
        $params = array();
        $params['community_idx'] = $this->input->post("community_idx");
        $params['content'] = $this->input->post("comment");
        $params['parent_idx'] = $this->input->post("parent_idx");
        
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
