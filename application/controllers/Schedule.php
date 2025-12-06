<?php

require_once APPPATH . 'third_party/PhpSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
    
    public function excel_process()
    {
        $data = [];
        $excel_data = [];

        $filename = $_FILES['upload_excel']['tmp_name'];

        try {
            $spreadsheet = IOFactory::load($filename);
            $sheetsCount = $spreadsheet->getSheetCount();

            for ($sheet = 0; $sheet < $sheetsCount; $sheet++) {

                $worksheet = $spreadsheet->getSheet($sheet);
                $highestRow = $worksheet->getHighestRow();

                for ($row = 2; $row <= $highestRow; $row++) {

                    // 셀 객체 미리 캐싱하여 성능 향상
                    $b_cell = $worksheet->getCell("B{$row}");
                    $c_cell = $worksheet->getCell("C{$row}");
                    $d_cell = $worksheet->getCell("D{$row}");
                    $e_cell = $worksheet->getCell("E{$row}");
                    $f_cell = $worksheet->getCell("F{$row}");
                    $g_cell = $worksheet->getCell("G{$row}");
                    $h_cell = $worksheet->getCell("H{$row}"); // Open date
                    $i_cell = $worksheet->getCell("I{$row}"); // Open time
                    $j_cell = $worksheet->getCell("J{$row}"); // Close date
                    $k_cell = $worksheet->getCell("K{$row}"); // Close time
                    $l_cell = $worksheet->getCell("L{$row}");
                    $m_cell = $worksheet->getCell("M{$row}");
                    $n_cell = $worksheet->getCell("N{$row}");

                    $params = [];

                    // 기본 값 매핑
                    $params['type'] = $b_cell->getValue();
                    $companyName = $c_cell->getValue();
                    $countryName = $d_cell->getValue();
                    $cityName    = $e_cell->getValue();
                    $params['space'] = $f_cell->getValue();
                    $params['addr']  = $g_cell->getValue();

                    // DB 매핑
                    $space = $this->space_md->get_space_name($params['space']);
                    $country      = $this->cont_md->get_country_name($countryName);
                    $city         = $this->city_md->get_city_name($cityName);

                    // 날짜 처리 (통합 함수 사용)
                    $start_date = $this->parseExcelDate($h_cell);
                    $end_date   = $this->parseExcelDate($j_cell);

                    // 시간 문자 그대로 사용
                    $start_time = $i_cell->getValue();
                    $end_time   = $k_cell->getValue();

                    if ($start_date && $start_time) {
                        $params['start_date'] = "{$start_date} {$start_time}";
                    } else {
                        $params['start_date'] = null;
                    }

                    if ($end_date && $end_time) {
                        $params['end_date'] = "{$end_date} {$end_time}";
                    } else {
                        $params['end_date'] = null;
                    }

                    // SNS
                    $params['homepage'] = $l_cell->getValue();
                    $params['insta']    = $m_cell->getValue();
                    $params['face']     = $n_cell->getValue();

                    // 성공 / 실패 체크
                    if (!empty($space) && !empty($country) && !empty($city)) {
                        
                        $params['city_idx'] = $city['idx'];
                        $params['space_idx'] = $space['idx'];
                        $params['space'] = $space['space_name'];
                        
                        $cnt = $this->sch_md->get_duple_schedule_cnt($params['city_idx'], $params['space_idx'], $start_date);
                        
                        if($cnt < 1){
                            
                            
                           
                            $kpop_idx = $this->sch_md->insert_schedule($params);
                            
                            $result_msg = "Insert DATA Complete.";
                            $result_code = "1";
                            
                        }else{
                            $result_msg = "Duplicated DATA.";
                            $result_code = "0";
                        }
                        
                        
                        
                    } else {
                        if (empty($country)) $result_msg = "Not found Country.";
                        else if (empty($city)) $result_msg = "Not found City.";
                        else $result_msg = "Not found Space.";

                        $result_code = "0";
                    }

                    $excel_data[$row] = [
                        "code"      => $result_code,
                        "result"    => $result_msg,
                        "type"      => $params['type'],
                        "company"   => $companyName,
                        "country"   => $countryName,
                        "city"      => $cityName,
                        "space" => $params['space'],
                        "address"   => $params['addr'],
                        "open"      => $start_date,
                        "open time" => $start_time,
                        "close"     => $end_date,
                        "close time"=> $end_time,
                        "homepage"  => $params['homepage'],
                        "insta"     => $params['insta'],
                        "facebook"  => $params['face']
                    ];
                }
            }

        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $exception) {
            echo "엑셀 파일 읽기 오류: " . $exception->getMessage();
            return;
        }

        $data['excel'] = $excel_data;

        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('excel_result', $data);
        $this->load->view('footer');
}

    
    private function parseExcelDate($cell)
    {
        // PhpSpreadsheet 1.24 버전에서 Excel 날짜 여부를 판별하는 공식 함수
        if (\PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($cell)) {
            $value = $cell->getValue();
            // 숫자형 Excel 날짜 → DateTime 변환
            $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value);
            return $dt->format("Y-m-d");
        }

        // 문자열 날짜라면 그대로 DateTime 처리
        $value = $cell->getValue();
        $dt = \DateTime::createFromFormat("d-m-Y", $value);
        if ($dt) {
            return $dt->format("Y-m-d");
        }

        return null; // 변환 불가 시
    }
    
    public function register_missing_data() {
        $this->load->model(['cont_md', 'city_md', 'space_md']);

        // register_data는 이제 폼에서 배열 형태로 전송됩니다.
        $register_data_array = $this->input->post('register_data'); 
        $results = [];

        if (!empty($register_data_array)) {
            foreach ($register_data_array as $index => $data) {

                // 체크박스가 선택된 항목만 처리
                if (!isset($data['register']) || $data['register'] != '1') {
                    continue;
                }

                $country_name = $data['country'];
                $city_name = $data['city'];
                $space_name = $data['space'];
                $latitude = $data['latitude']; // 새로 추가된 좌표
                $longitude = $data['longitude']; // 새로 추가된 좌표

                // 1. Country 확인 및 등록
                $country = $this->cont_md->get_country_name($country_name);
                $country_idx = empty($country) ? null : $country['idx'];
                if (empty($country)) {
                    $country_idx = $this->cont_md->insert_country($country_name, $latitude, $longitude); // 위도/경도를 Country 테이블에 저장한다고 가정
                    $results[] = "Country '{$country_name}' 등록 시도 완료.";
                }

                // 2. City 확인 및 등록
                $city = $this->city_md->get_city_name($city_name); // Country ID를 조건으로 사용하여 City 확인 필요
                $city_idx = empty($city) ? null : $city['idx'];
                if (empty($city)) {
                     $city_idx = $this->city_md->insert_city($country_idx, $city_name, $latitude, $longitude); // 위도/경도를 City 테이블에 저장한다고 가정
                    $results[] = "City '{$city_name}' 등록 시도 완료.";
                }

                // 3. Company 확인 및 등록 (Club Name)
                $space = $this->space_md->get_space_name($space_name);
                if (empty($space)) {
                    $space_idx = $this->space_md->insert_space($space_name, $latitude, $longitude); // 위도/경도를 Organization 테이블에 저장한다고 가정
                    $results[] = "Company '{$space_name}' 등록 시도 완료.";
                }

                // 중요: 위도/경도는 Country, City, Club 중 해당 데이터가 없는 곳에 저장해야 합니다.
                // 예를 들어 Country는 있고 City가 없는 경우, City를 등록할 때 좌표를 함께 저장합니다.

            }
        }

        $this->session->set_flashdata('registration_results', $results);
        redirect('schedule/schedule_complete'); 
    }
    
    function schedule_complete(){
        $data = array();
        
        $this->load->view('header');
        $this->load->view('sidebar');
        $this->load->view('schedule_complete',$data);
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
