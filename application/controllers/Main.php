<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Schedule_model', 'sch_md', TRUE);
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        $this->load->model('Organization_model', 'org_md', TRUE);
        $this->load->model('Community_model', 'com_md', TRUE);
    }
    function index(){
        
        
        $search = array();
        
        if(!empty($this->input->get_post("date"))){
            $search['date'] =  date("Y-m-d", strtotime($this->input->get_post("date")));
        }
        
        $plang = $this->input->get_post("lang");
        $return_url = $this->input->get_post("return_url");
        
        
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
        if(!empty($return_url)){

            $return_url = str_replace('_','&',$return_url);
            header('Location: '.$return_url);
        }

        
        
        
        $search['country'] = $this->input->get_post("country");
        $search['city'] = $this->input->get_post("city");
        $search['organizer'] = $this->input->get_post("organization");
        
        
        
        if(!confirm_mobile()){
            
            if(!empty($this->session->userdata['country_idx'])){
                $search['country'] = $this->session->userdata['country_idx'];
            }
            if(!empty($this->session->userdata['city_idx'])){
                $search['city'] = $this->session->userdata['city_idx'];
            }
            $page = array (
                "start" => 0,
                "end" => 5
            );
            
            $data['community_idx'] = $this->com_md->get_list($search, $page);
            
            $search['order'] = "great";
            $data['community_great'] = $this->com_md->get_list($search, $page);
            
            $data['schedule_list'] = $this->sch_md->get_schedule($search, $page);
        }
        
        $data['country_list'] = $this->cont_md->get_country();
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
        }else{
            $data['city_list'] = "";
        }
        $data['organization_list'] = $this->org_md->get_organization();
        

        //---- 오늘 날짜
        $data['thisyear'] = $thisyear = date('Y'); // 4자리 연도
        $data['thismonth'] = $thismonth = date('n'); // 0을 포함하지 않는 월
        $data['today'] = $today = date('j'); // 0을 포함하지 않는 일

        //------ $year, $month 값이 없으면 현재 날짜
        $data['year'] = $year = $this->input->get('year') !== null ? $this->input->get('year') : $thisyear;
        $data['month'] =$month =  $this->input->get('month') !== null ?$this->input->get('month') : $thismonth;
        $data['day'] = $day = $this->input->get('month') !== null ? $this->input->get('month') : $today;
        
        $data['search'] = $search;
        
        $data_calendar = $this->sch_md->get_schedule_cnt($search['country'], $year , sprintf("%02d",$month));

        $data['calendar'] = $data_calendar;
        
        
        $data['prev_month'] = $prev_month = $month - 1;
        $data['next_month'] = $next_month =  $month + 1;
        $data['prev_year'] = $data['next_year'] = $year;
        
        if ($month == 1) {
            $data['prev_month'] = 12;
            $data['prev_year'] = $year - 1;
        } else if ($month == 12) {
            $data['next_month'] = 1;
            $data['next_year'] = $year + 1;
        }
        $data['preyear'] = $year - 1;
        $data['nextyear'] = $year + 1;

        $data['predate'] = date("Y-m-d", mktime(0, 0, 0, $month - 1, 1, $year));
        $data['nextdate'] = date("Y-m-d", mktime(0, 0, 0, $month + 1, 1, $year));

        // 1. 총일수 구하기
        $data['max_day'] = $max_day =  date('t', mktime(0, 0, 0, $month, 1, $year)); // 해당월의 마지막 날짜
        //echo '총요일수'.$max_day.'<br />';

        // 2. 시작요일 구하기
        $data['start_week'] = $start_week =  date("w", mktime(0, 0, 0, $month, 1, $year)); // 일요일 0, 토요일 6

        // 3. 총 몇 주인지 구하기
        $data['total_week'] = ceil(($max_day + $start_week) / 7);

        // 4. 마지막 요일 구하기
        $data['last_week'] = date('w', mktime(0, 0, 0, $month, $max_day, $year));

        if(confirm_mobile()){ //MOBILE
            $this->load->view('/mobile/header');
            $this->load->view('/mobile/calendar',$data);
            $this->load->view('footer');
        }else{                                                      //PC
            $this->load->view('header');
            $this->load->view('sidebar');
            $this->load->view('main', $data);
            $this->load->view('footer');
        }

        
    }
    
}