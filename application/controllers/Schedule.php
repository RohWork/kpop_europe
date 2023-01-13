<?php

class Schedule extends CI_Controller {
    
    function __construct() {
        parent ::__construct();
        
        $this->load->model('Schedule_model', 'sch_md', TRUE);
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        $this->load->model('Organization_model', 'org_md', TRUE);
    }
    
    
    function calendar(){
        
        $data['get_country'] = $country = $this->input->get('country') !== null ? $this->input->get('country') : '1';
        
        //---- 오늘 날짜
        $data['thisyear'] = $thisyear = date('Y'); // 4자리 연도
        $data['thismonth'] = $thismonth = date('n'); // 0을 포함하지 않는 월
        $data['today'] = $today = date('j'); // 0을 포함하지 않는 일

        //------ $year, $month 값이 없으면 현재 날짜
        $data['year'] = $year = $this->input->get('year') !== null ? $this->input->get('year') : $thisyear;
        $data['month'] =$month =  $this->input->get('month') !== null ?$this->input->get('month') : $thismonth;
        $data['day'] = $day = $this->input->get('month') !== null ? $this->input->get('month') : $today;
        
        $data['country'] = $this->cont_md->get_country(); 
        
        $data_calendar = $this->sch_md->get_schedule_cnt($country, $year , sprintf("%02d",$month));

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

        
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('calendar',$data);
        $this->load->view('footer');
    }
    
    function list($page=0){
        
        
        $search = array();
        
        $search['date'] = $this->input->get_post("date");
        $search['country'] = $this->input->get_post("country");
        $search['city'] = $this->input->get_post("city");
        $search['organizer'] = $this->input->get_post("organizer");
        

        
        $data = array();
        $total = $this->sch_md->get_schedule($search);
        
        $this->load->library('pagination');
        
        $config['base_url'] = '/schedule/list';
        $config['total_rows'] = count($total);
        $config['per_page'] = 10;
        $this->pagination->initialize($config);
        $data['paging'] = $this->pagination->create_links();
        
        $paging = array(
            "start" => $page,
            "end"   => $config['per_page']
        );
        
        $data['list'] = $this->sch_md->get_schedule($search, $paging);
        $data['country_list'] = $this->cont_md->get_country();
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
        }else{
            $data['city_list'] = "";
        }
        $data['organization_list'] = $this->org_md->get_organization();
        $data['search'] = $search;
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('list',$data);
        $this->load->view('footer');
        
    }
    
    function detail($idx){
        

        $data = array();
        
        $data['detail_info'] = $this->sch_md->get_detail_schedule($idx);
        $data['detail_img'] =  $this->sch_md->get_schedule_image($idx);
        
        $this->load->view('detail',$data);

        
    }

    function frame_list(){
        
        $search = array();
        
        $search['date'] = $this->input->get_post("date");
        $search['country'] = $this->input->get_post("country");
        
        
        $data = array();
        $data['list'] = $this->sch_md->get_schedule($search);
        
        $this->load->view('frame_list',$data);
        
        
    }
    
    function frame_detail($idx){
        
        $data = array();
        $data['detail_info'] = $this->sch_md->get_detail_schedule($idx);
        $data['detail_img'] =  $this->sch_md->get_schedule_image($idx);
        
        $this->load->view('frame_detail',$data);
        
        
    }
    
    function insert(){
        
        $data = array();
        
        $data['country'] = $this->cont_md->get_country();
        $data['city'] = $this->city_md->get_city();
        $data['organization'] = $this->org_md->get_organization();
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('schedule_insert',$data);
        $this->load->view('footer');
    }
    
    function insert_ajax(){
        
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
        $data['country_idx'] = $this->input->post("check_country");
        $data['city_idx'] = $this->input->post("check_city");
        $data['organization_idx'] = $this->input->post("check_organization");
        $data['remark'] = $this->input->post("input_remark");
        $data['type'] = $this->input->post("input_type");
        
        $image_title = $this->input->post("input_name");
        $image_data = $this->input->post("input_image");
       
        
        if(!empty($data['name']) && !empty($data['start_date']) && !empty($data['end_date'])){
            
            $image_params['kpop_idx'] = $this->sch_md->insert_schedule($data);
            
            $i=1;
            
            
            foreach ($image_data as $img){

                
                if(!empty($img[$i])){
                    $image_params['title'] =  $image_title.$i;
                    $image_params['src'] = $img;
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
    
    function delete_ajax(){
        
        $data = array();
        $image_data = array();
        
        $idx= $this->input->post("idx");

        $info =  $this->sch_md->get_detail_schedule($idx);
        
        if($this->session->userdata('level') < 2 || $this->session->userdata('org_idx') != $info['organization_idx'] ){ 
            
                $data['message'] = "Not You'r Schedule";

                $data['result'] = 201;
            
        }else{
            if(!empty($idx)){

                $this->sch_md->delete_schedule($idx);

                $data['result'] = 200;


            }else{
                $data['message'] = "Check To you're idx";

                $data['result'] = 201;
            }
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    function modify(){
        
        $idx = $this->input->get("idx");
        
        $data = array();
        $data['detail_info'] = $detail_info =  $this->sch_md->get_detail_schedule($idx);        
        $data['detail_img'] =  $this->sch_md->get_schedule_image($idx);
        
        $this->load->view('detail',$data);
        
    }
    
    function excel(){
        
        $data = array();
                
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('schedule_excel',$data);
        $this->load->view('footer');
    }
    
    function excel_process(){
        
        
        $data = array();
        
        // PHPExcel 라이브러리 로드
        $this->load->library('excel');
        
        $filename =  $_FILES['upload_excel']['tmp_name'];
        
        try{
        // 엑셀 파일 읽기
        $objPHPExcel = PHPExcel_IOFactory::load($filename);
        
        
            $extension = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
            $sheetsCount = $objPHPExcel -> getSheetCount();

            $excel_data = array();
            
            // 시트Sheet별로 읽기
            for($sheet = 0; $sheet < $sheetsCount; $sheet++) {

                $objPHPExcel -> setActiveSheetIndex($sheet);
                $activesheet = $objPHPExcel -> getActiveSheet();
                $highestRow = $activesheet -> getHighestRow();          // 마지막 행
                $highestColumn = $activesheet -> getHighestColumn();    // 마지막 컬럼

                // 한줄읽기
                for($row = 2; $row <= $highestRow; $row++) {
                    
                    $params['type'] = $a = $activesheet->getCell('A' . $row)->getValue(); // type
                    
                    $params = array();
                    
                    
                    $params['name'] = $b= $activesheet->getCell('B' . $row)->getValue(); // type

                    $c =  $activesheet->getCell('C' . $row)->getValue(); // Company 
                    $organization = $this->org_md->get_organization_name($c);
                    
                    
                    $d = $activesheet->getCell('D' . $row)->getValue(); // Date
                    $date = PHPExcel_Style_NumberFormat::toFormattedString($d, 'YYYY-MM-DD');
                    
                    
                    $e = $activesheet->getCell('E' . $row)->getValue();  // DOW 

                    $f = $activesheet->getCell('F' . $row)->getValue(); // Country
                    $country = $this->cont_md->get_country_name($f);

                    $g = $activesheet->getCell('G' . $row)->getValue(); // City 
                    $city = $this->city_md->get_city_name($g);

                    $params['addr'] = $h = $activesheet->getCell('H' . $row)->getValue(); // Address

                    $i = $activesheet->getCell('I' . $row)->getValue(); // Open
                    $params['start_date'] = $i = PHPExcel_Style_NumberFormat::toFormattedString($i, 'YYYY-MM-DD h:i');
                    
                    $j = $activesheet->getCell('J' . $row)->getValue(); // Close
                    $params['end_date'] = $j = PHPExcel_Style_NumberFormat::toFormattedString($j, 'YYYY-MM-DD h:i');
                    
                    $params['homepage']=  $k = $activesheet->getCell('K' . $row)->getValue(); // Hompage 
                    $params['insta'] = $l = $activesheet->getCell('L' . $row)->getValue(); // Insta
                    $params['face'] = $m = $activesheet->getCell('M' . $row)->getValue(); // Facebook
                    
                    
                    if(!empty($organization) && !empty($country) && !empty($city)){
                        
                        $params['organization_idx'] = $organization['idx'];
                        $params['country_idx'] = $country['idx'];
                        $params['city_idx'] = $city['idx'];
                        
                        
                        $result = $this->sch_md->insert_schedule($params);
                        $result_code = "1";
                        
                    }else{
                        
                        if(empty($organization)){
                            $result = "not found Organizer.";
                        }else if(empty($countrty)){
                            $result = "not found Country.";
                        }else{
                            $result = "not found City.";
                        }
                        $result_code = "0";
                    }
                    $excel_data[$row] = array(
                        "code" => $result_code,
                        "result" => $result,
                        "type" => $a,
                        "party_name" => $b,
                        "orgnizer" => $c,
                        "date" => $d,
                        "dow" => $e,
                        "country" => $f,
                        "city" => $g,
                        "address" => $h,
                        "open" => $i,
                        "close" => $j,
                        "homepage" => $k,
                        "insta" => $l,
                        "facebook" => $m,
                    );
                    
                    
                    
                    
                }
            }
        } catch(exception $exception) {
            echo $exception;
        }

        $data['excel'] = $excel_data;
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('excel_result',$data);
        $this->load->view('footer');
    }
    
    
    
}
