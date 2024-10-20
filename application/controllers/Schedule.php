<?php

class Schedule extends CI_Controller {
    
    function __construct() {
        parent ::__construct();
        
        $this->load->model('Schedule_model', 'sch_md', TRUE);
        $this->load->model('Community_model', 'com_md', TRUE);
        $this->load->model('Country_model', 'cont_md', TRUE);
        $this->load->model('City_model', 'city_md', TRUE);
        $this->load->model('Organization_model', 'org_md', TRUE);
        $this->load->model('Bookmark_model', 'mark_md',  TRUE);
        $this->load->model('Space_model', 'space_md',  TRUE);
        
        $lang = $this->session->userdata('lang');
        if(empty($lang)){
            $lang = "en"; 
        }
        $this->session->set_userdata('lang',$lang);
        
        $this->lang->load('controller', $lang);
    }
    
    
    function calendar(){
        
        $data['mode'] = "calendar";
        
        $search = array();
        
        if(!empty($this->input->get_post("date"))){
            $search['date'] =  date("Y-m-d", strtotime($this->input->get_post("date")));
        }
        
        $search['country'] = $this->session->userdata('country_idx');
        $search['city'] = $this->session->userdata('city_idx');
        
        if(!empty($this->input->get_post("country"))){
            $search['country'] = $this->input->get_post("country");
        }
        if(!empty($this->input->get_post("city"))){
            $search['city'] = $this->input->get_post("city");
        }
        $search['organizer'] = $this->input->get_post("organization");
        $search['type'] = $this->input->get_post("type");
        
        $data['country_list'] = $this->cont_md->get_country();
        if(!empty($search['country'])){
            $data['city_list'] = $this->city_md->get_city($search['country']);
        }else{
            $data['city_list'] = "";
        }
        $data['organization_list'] = $this->org_md->get_organization();
        
        
        //유럽식으로 표기
        $search['date'] = $this->input->get_post("date");
        $data['search'] = $search;
        
        //---- 오늘 날짜
        $data['thisyear'] = $thisyear = date('Y'); // 4자리 연도
        $data['thismonth'] = $thismonth = date('n'); // 0을 포함하지 않는 월
        $data['today'] = $today = date('j'); // 0을 포함하지 않는 일

        //------ $year, $month 값이 없으면 현재 날짜
        $data['year'] = $year = $this->input->get('year') !== null ? $this->input->get('year') : $thisyear;
        $data['month'] =$month =  $this->input->get('month') !== null ?$this->input->get('month') : $thismonth;
        $data['day'] = $day = $this->input->get('month') !== null ? $this->input->get('month') : $today;
        
        $data['calendar'] =  $this->sch_md->get_schedule_cnt($search, $year , sprintf("%02d",$month));

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
        }else{   
            $this->load->view('header');
            $this->load->view('sidebar');
            $this->load->view('calendar',$data);
            $this->load->view('footer');
        }
    }
    
    function list($page=0){
        
        $data = array();
        $search = array();
        
        $data['mode'] = "list";
        
        if(!empty($this->input->get_post("date"))){
            $search['date'] =  date("Y-m-d", strtotime($this->input->get_post("date")));
        }
        

        
        $search['country'] = $this->session->userdata('country_idx');
        $search['city'] = $this->session->userdata('city_idx');
        
        if(!empty($this->input->get_post("country"))){
            $search['country'] = $this->input->get_post("country");
        }
        if(!empty($this->input->get_post("city"))){
            $search['city'] = $this->input->get_post("city");
        }
        if(!empty($this->input->get_post("detail"))){
            $search['detail'] = $this->input->get_post("detail");
        }
        
        
        $search['organizer'] = $this->input->get_post("organization");
        $search['type'] = $this->input->get_post("type");
        
        
        
        
        $total = $this->sch_md->get_schedule($search);
        
        $this->load->library('pagination');
        
        $config['base_url'] = '/schedule/list';
        $config['reuse_query_string'] = true;
        $config['total_rows'] = count($total);
        $config['per_page'] = 10;
        $config['attributes'] = array('class' => 'page-link');
        
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
        
        //유럽식으로 표기
        $search['date'] = $this->input->get_post("date");
        $data['search'] = $search;
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('list',$data);
        $this->load->view('footer');
        
    }
    
    function detail($idx){
        

        $data = array();
        
        $data['mode']= $this->input->get_post("mode");
        
        $data['detail_info'] = $this->sch_md->get_detail_schedule($idx);
        $data['detail_img'] =  $this->sch_md->get_schedule_image($idx);
        $data['like'] = count($this->com_md->get_like_history($idx, "schedule", 1, 0));
        
        $this->load->view('detail',$data);

        
    }

    function frame_list(){
        
        $search = array();
        
        $search['date'] = $this->input->get_post("date");
        $search['country'] = $this->input->get_post("country");
        $search['city'] = $this->input->get_post("city");
        $search['organizer'] = $this->input->get_post("organization");
        
        $data = array();
        $data['list'] = $this->sch_md->get_schedule($search);
        
        if(confirm_mobile()){ //MOBILE
            $this->load->view('/mobile/frame_list',$data);
        }else{
            $this->load->view('frame_list',$data);
        }
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
        $data['space'] = $this->space_md->get_space();
        
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
        $data['space_idx'] = $this->input->post("input_space");
        $data['space'] = $this->input->post("input_space_name");
        
        $date_start = DateTime::createFromFormat("d/m/Y H:i:s" , $this->input->post("input_start_date"));
        $date_end = DateTime::createFromFormat("d/m/Y H:i:s" , $this->input->post("input_end_date"));
        
        $data['start_date'] = $date_start->format("Y-m-d H:i:s");
        $data['end_date'] =  $date_end->format("Y-m-d H:i:s");
        
        
        $data['country_idx'] = $this->input->post("check_country");
        $data['city_idx'] = $this->input->post("check_city");
        $data['organization_idx'] = $this->input->post("check_organization");
        $data['remark'] = $this->input->post("input_remark");
        $data['type'] = $this->input->post("input_type");
        
        $image_title = $this->input->post("input_name");
        $image_data = $this->input->post("input_image");
       
        
        if(!empty($data['name']) && !empty($data['start_date']) && !empty($data['end_date'])){
            
            $cnt = $this->sch_md->get_duple_schedule_cnt($data['city_idx'], $data['space'], $data['start_date']);
            if($cnt < 1){
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
                $data['message'] = $this->lang->line('dupleschedule');

                $data['result'] = 202;
            }
            
        }else{
            $data['message'] = $this->lang->line('paramerror');

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
        
        if($this->session->userdata('level') > 2 || $this->session->userdata('org_idx') == $info['organization_idx'] ){
            
                 $this->sch_md->delete_schedule($idx);

                $data['result'] = 200;
            
        }else{
            if(!empty($idx)){

                 $data['message'] = $this->lang->line('mineerror');

                $data['result'] = 201;


            }else{
                $data['message'] = $this->lang->line('idxerror');

                $data['result'] = 201;
            }
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
    function modify($idx){
        
        $data = array();
        $data['detail_info'] = $detail_info =  $this->sch_md->get_detail_schedule($idx);

        $data['country'] = $this->cont_md->get_country();
        $data['city'] = $this->city_md->get_city();
        $data['organization'] = $this->org_md->get_organization();
        $data['space'] = $this->space_md->get_space();
        
        $data['detail_img'] =  $this->sch_md->get_schedule_image($idx);
        
        $this->load->view('modify',$data);
        
    }
    function modify_ajax(){
        
        $sch_idx = $this->input->post("idx");
        
        $params['name']= $this->input->post("name");
        
        $params['homepage'] = $this->input->post("homepage");
        $params['space_idx'] = $this->input->post("space_idx");
        $params['space'] = $this->input->post("space_name");
        $params['addr'] = $this->input->post("addr");
        $params['face'] = $this->input->post("face");
        $params['insta'] = $this->input->post("insta");
        $params['yout'] = $this->input->post("yout");
        
        
        
        $date_start = DateTime::createFromFormat("d/m/Y H:i:s" , $this->input->post("start_date"));
        $date_end = DateTime::createFromFormat("d/m/Y H:i:s" , $this->input->post("end_date"));
        $params['start_date'] = $date_start->format("Y-m-d H:i:s");
        $params['end_date'] =  $date_end->format("Y-m-d H:i:s");
        
        $params['country_idx'] = $this->input->post("country");
        $params['city_idx'] = $this->input->post("city");
        $params['organization_idx'] = $this->input->post("company");
        
        $params['remark'] = $this->input->post("remark");
        $params['type'] = "party";
        
        $image_title = $this->input->post("name");
        $image_data = $this->input->post("input_image");
        
        
        if(!empty($params['name']) && !empty($params['start_date']) && !empty($params['end_date'])){
            
            $result = $this->sch_md->modify_schedule($params,$sch_idx);
            
            if($result){
                
                $this->sch_md->set_schedule_image($sch_idx); //전체사용안함
                $image_params['kpop_idx'] = $sch_idx;
                
                $i=1;
                
                foreach ($image_data as $img){

                    
                    if(!empty($img[$i])){
                        $image_params['title'] =  $image_title.$i;
                        $image_params['src'] = $img;
                        $image_params['sort'] = $i;
                        
                        $check_img = $this->sch_md->select_schedule_image($img);    // 존재하는 이미지인지 확인
                        
                        if($check_img['cnt'] == 0){
                            $this->sch_md->insert_schedule_image($image_params);    // 생성
                        }else{
                            $this->sch_md->update_schedule_image($i);               // 사용으로 상태값 수정
                        }
                            $i++;
                        
                    }

                }
                $data['result'] = 200;

            }else{
                $data['message'] = $this->lang->line('dataerror2');

                $data['result'] = 201;
            }
        }else{
            $data['message'] = $this->lang->line('paramerror');

            $data['result'] = 201;
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
    }
    
        function like_ajax(){
        
        $data = array();
        
        $data['result'] = 200;
        $data['message'] = "";
        
        $lang = $this->session->userdata('lang');
        $this->lang->load('view', $lang);

        $mode =  $this->input->post("mode");
        
        $idx = $this->input->post("idx");
        
        if(empty($this->session->userdata('name') )){
            $data['result'] = 401;
            $data['message'] = $this->lang->line('loginerror');
        }else if(count($this->com_md->get_like_history($idx, "schedule", $mode, 0) )> 0){
            $this->com_md->modify_like_history($idx, $mode, "schedule", 0);    
            $mode = 2;  
            
        }
        
        $this->com_md->set_like_history($idx, $mode, "schedule", 0);
            $result = $this->sch_md->set_like($idx, $mode);

            if(!$result){
                $data['result'] = 400;
                $data['message'] = $this->lang->line('dataerror');
            }
        header("Content-Type: application/json;");
        echo json_encode($data);
        
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
                    
                    //$params['type'] = $a = $activesheet->getCell('A' . $row)->getValue(); // type
                    
                   // if(empty($params['type']) || $params['type'] == ""){
                   //     break;
                    //}
                    
                    $params = array();
                    
                    
                    $params['type'] = $b= $activesheet->getCell('B' . $row)->getValue(); // type

                    $c =  $activesheet->getCell('C' . $row)->getValue(); // Company 
                    $organization = $this->org_md->get_organization_name($c);

                    $d = $activesheet->getCell('D' . $row)->getValue(); // Country
                    $country = $this->cont_md->get_country_name($d);

                    $e = $activesheet->getCell('E' . $row)->getValue(); // City 
                    $city = $this->city_md->get_city_name($e);

                    $params['space'] = $f = $activesheet->getCell('F' . $row)->getValue(); // Address

                    
                    $params['addr'] = $g = $activesheet->getCell('G' . $row)->getValue(); // Address

                    $h = $activesheet->getCell('H' . $row)->getValue(); // Open
                    $h = PHPExcel_Style_NumberFormat::toFormattedString($h, 'DD-MM-YYYY');
                    
                    $i = $activesheet->getCell('I' . $row)->getValue(); // Open Time 
                    
                    $j = $activesheet->getCell('J' . $row)->getValue(); // Close
                    $j = PHPExcel_Style_NumberFormat::toFormattedString($j, 'DD-MM-YYYY');
                    
                    $k = $activesheet->getCell('K' . $row)->getValue(); // Close Time 
                    
                    $date_start = DateTime::createFromFormat("d-m-Y", $h);
                    $date_end = DateTime::createFromFormat("d-m-Y", $j);
                    
                    $params['start_date'] = $date_start->format("Y-m-d")." ".$i;
                    $params['end_date'] =  $date_end->format("Y-m-d")." ".$k;

                    
                    $params['homepage']=  $l = $activesheet->getCell('L' . $row)->getValue(); // Hompage 
                    $params['insta'] = $m = $activesheet->getCell('M' . $row)->getValue(); // Insta
                    $params['face'] = $n = $activesheet->getCell('N' . $row)->getValue(); // Facebook

                    
                    if(!empty($organization) && !empty($country) && !empty($city)){
                        
                        $cnt = $this->sch_md->get_duple_schedule_cnt($city['idx'], $params['space'], $params['start_date']);
                        if($cnt < 1){
                        
                            $params['organization_idx'] = $organization['idx'];
                            $params['country_idx'] = $country['idx'];
                            $params['city_idx'] = $city['idx'];

                            $result = $this->sch_md->insert_schedule($params);
                            $result_code = "1";
                        }else{
                            $result = $this->lang->line('dupleschedule');
                            $result_code = "0";
                        }
                        
                    }else{
                        
                        if(empty($organization)){
                            $result = "Not found Organizer.";
                        }else if(empty($country)){
                            $result = "Not found Country.";
                        }else{
                            $result = "Not found City.";
                        }
                        $result_code = "0";
                    }
                    $excel_data[$row] = array(
                        "code" => $result_code,
                        "result" => $result,
                        "type" => $b,
                        "company" => $c,
                        "country" => $d,
                        "city" => $e,
                        "club name" => $f,
                        "address" => $g,
                        "open" => $h,
                        "open time" => $i,
                        "close" => $j,
                        "close time" => $k,
                        "homepage" => $l,
                        "insta" => $m,
                        "facebook" => $n,
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
    
    function mark_ajax(){
        
        $data = array();

        $idx= $this->input->post("idx");
        
        if(!empty($idx)){
                
            $result = $this->mark_md->chk_cnt($idx);
            
            if($result['cnt'] > 0){
                
                $data['message'] = $this->lang->line('dupleschedule');
                $data['result'] = 202;
                
            }else{
            
                $this->mark_md->insert($idx);

                $data['result'] = 200;
            }
            
        }else{
            
            $data['message'] = $this->lang->line('idxerror');

            $data['result'] = 201;
            
        }
        
        header("Content-Type: application/json;");
        echo json_encode($data);
        
        
    }
    
    
}
