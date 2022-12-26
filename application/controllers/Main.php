<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent ::__construct();
        
        $this->load->model('Schedule_model', 'sch_md', TRUE);
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        $this->load->model('Organization_model', 'org_md', TRUE);
    }
    function index(){
        
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('main');
        $this->load->view('footer');
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
    
    function schedule_insert(){
        
        $data = array();
        
        $data['country'] = $this->cont_md->get_country();
        $data['city'] = $this->city_md->get_city();
        $data['organization'] = $this->org_md->get_organization();
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('schedule_insert',$data);
        $this->load->view('footer');
    }
    
    function schedule_insert_ajax(){
        
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
    
    function schedule_excel(){
        
        $data = array();
                
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('schedule_excel',$data);
        $this->load->view('footer');
    }
    
    function schedule_excel_process(){
        
        // PHPExcel 라이브러리 로드
        $this->load->library('excel');
        
        $filename =  iconv("UTF-8", "EUC-KR", $_FILES['upload_excel']['tmp_name']);
        
        try{
        // 엑셀 파일 읽기
        $objPHPExcel = PHPExcel_IOFactory::load($filename);
        
        
            $extension = strtoupper(pathinfo($filename, PATHINFO_EXTENSION));
            $sheetsCount = $objPHPExcel -> getSheetCount();

            // 시트Sheet별로 읽기
            for($sheet = 0; $sheet < $sheetsCount; $sheet++) {

                $objPHPExcel -> setActiveSheetIndex($sheet);
                $activesheet = $objPHPExcel -> getActiveSheet();
                $highestRow = $activesheet -> getHighestRow();          // 마지막 행
                $highestColumn = $activesheet -> getHighestColumn();    // 마지막 컬럼

                // 한줄읽기
                for($row = 1; $row <= $highestRow; $row++) {

                    // $rowData가 한줄의 데이터를 셀별로 배열처리 된다.
                    $rowData = $activesheet -> rangeToArray("A" . $row . ":" . $highestColumn . $row, NULL, TRUE, FALSE);

                    // $rowData에 들어가는 값은 계속 초기화 되기때문에 값을 담을 새로운 배열을 선안하고 담는다.
                    $allData[$row] = $rowData[0];

                    //echo $rowData[0];
                }
            }
        } catch(exception $exception) {
            echo $exception;
        }

        //echo "<pre>";
        //print_r($allData);
        //echo "</pre>";


        foreach($allData as $key=>$value){
            //echo $key . " : " . $value . "</br>";

            foreach($value as $key2=>$value2){
                echo $key2 . " : " . $value2 . "</br>";
            }

            echo "</br>";
        }

        echo "</br></br></br></br>";



        foreach($allData as $key=>$value){
            echo $value[0]."/".$value[1]."</br>";
        }

    }
    
}