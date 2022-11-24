<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Schedule_model', 'sch_md', TRUE);
    }
    function index(){
        
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('main');
        $this->load->view('footer');
    }
    
    function calendar(){
        
        $data['country'] = $country = $this->input->get('country') !== null ? $this->input->get('country') : 'Germany';

        //---- 오늘 날짜
        $data['thisyear'] = $thisyear = date('Y'); // 4자리 연도
        $data['thismonth'] = $thismonth = date('n'); // 0을 포함하지 않는 월
        $data['today'] = $today = date('j'); // 0을 포함하지 않는 일

        //------ $year, $month 값이 없으면 현재 날짜
        $data['year'] = $year = $this->input->get('year') !== null ? $this->input->get('year') : $thisyear;
        $data['month'] =$month =  $this->input->get('month') !== null ?$this->input->get('month') : $thismonth;
        $data['day'] = $day = $this->input->get('month') !== null ? $this->input->get('month') : $today;
        
        
        
        $data_calendar = $this->sch_md->get_schedule($country, $year , sprintf("%02d",$month));
        $data_array = array();

        foreach ($data_calendar as $cal) {
            $data_array[$cal['start_date']] = array();
            $data_array[$cal['start_date']]['idx'] = $cal['idx'];
            $data_array[$cal['start_date']]['name'] = $cal['name'];
        }
        $data['calendar'] = $data_array;
        
        
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

        
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('calendar',$data);
        $this->load->view('footer');
    }
    
    function detail($idx){
        
        $data = array();
        $data['detail_info'] = $this->sch_md->get_detail_schedule($idx);
        $data['detail_img'] =  $this->sch_md->get_schedule_image($idx);
        
        $this->load->view('detail',$data);
        
        
    }
    
    function calendar_insert(){
        
        $data = array();
        $image_data = array();
        
        $data['name']= $this->input->post("input_name");
        $data['company'] = $this->input->post("input_company");
        $data['homepage'] = $this->input->post("input_homepage");
        $data['addr'] = $this->input->post("input_addr");
        $data['face'] = $this->input->post("input_face");
        $data['insta'] = $this->input->post("input_insta");
        $data['yout'] = $this->input->post("input_yout");
        $data['start_date'] = $this->input->post("input_start_date");
        $data['end_date'] = $this->input->post("input_end_date");
        $data['country'] = $this->input->post("input_country");
        $data['remark'] = $this->input->post("input_remark");
        $data['type'] = $this->input->post("type");
        
        $image_title = $this->input->post("input_name");
        $image_data = $this->input->post("input_image");
       
        
        if(!empty($data['name']) && !empty($data['start_date']) && !empty($data['end_date'])){
            
            $image_params['kpop_idx'] = $this->sch_md->insert_schedule($data);
            
            $i=1;
            
            var_dump($image_data);
            foreach ($image_data as $img){
                
                
                
                if(!empty($img[$i])){
                    $image_params['title'] =  $image_title.$i;
                    $image_params['src'] = $image_data[$i];
                    $image_params['sort'] = $i;
                    $this->sch_md->insert_schedule_image($image_params);
                    $i++;
                }
                
            }
            
            
            $data['result'] = 200;

            
        }else{
            $data['message'] = "Check To you're name or start_date or end_date";

            $data['result'] = 201;
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
}