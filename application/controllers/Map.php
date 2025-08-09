<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map extends CI_Controller {
        
        function __construct() {
            
            parent ::__construct();
            
            $this->load->model('Schedule_model', 'sch_md', TRUE);
            $this->load->model('Country_model', 'cont_md', TRUE);
            $this->load->model('City_model', 'city_md', TRUE);
        }
	public function index()
	{
            $data = array();
            $search = array();
            
            $search['country'] = $this->input->get_post("country");
            $search['city'] = $this->input->get_post("city");
            
            $data['space_info'] = $this->sch_md->get_space_info($search);
            
            $plang = $this->input->get_post("lang");
            $return_url = $this->input->get_post("return_url");
        
            $data['country_list'] = $this->cont_md->get_country();
            
            $data['city_list'] = $this->city_md->get_city($search['country']);

            
            $country_data = $this->cont_md->get_country_idx($search['country']);
            $city_data = $this->city_md->get_city_idx($search['city']);
            
            if(!empty($search['country'])){
                $data['mapdata'] = $country_data;
            }else if(!empty($search['city'])){
                $data['mapdata'] = $city_data;
            }
            
            $slang = $this->session->userdata('lang');
        
            if(empty($plang)){
                $lang = $slang;
            }
        
            if(empty($slang)){
                $lang = "eng"; 
            }
        
            if(!empty($plang)){
                $this->session->set_userdata('lang',$plang);
                session_commit();
                session_write_close();
            }
            
            
            $data['search'] = $search;
            
            $this->load->view('map/main', $data);
	}
        
        public function detail($idx){
        

            $data = array();

            $data['mode']= $this->input->get_post("mode");

            $data['detail_info'] = $this->sch_md->get_detail_schedule($idx);
            $data['detail_img'] =  $this->sch_md->get_schedule_image($idx);
            $data['like'] = 0;//count($this->com_md->get_like_history($idx, "schedule", 1, 0));

            $this->load->view('map/detail',$data);

        
        }
        public function test(){
            
            
            $this->load->view('main_test');
        }
}


?>