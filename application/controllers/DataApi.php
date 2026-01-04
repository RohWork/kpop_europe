<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DataApi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // 모델 로드
        $this->load->model('Schedule_model');
        
        // CORS 및 JSON 헤더 설정 (외부 통신 허용)
        header('Content-Type: application/json; charset=utf-8');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    }

    /**
     * 1. 일정 목록 조회 (필터 및 페이징)
     * URL: /DataApi/get_schedule_list
     */
    public function get_schedule_list() {
        $search = [
            'country'   => $this->input->get_post('country'),
            'city'      => $this->input->get_post('city'),
            'organizer' => $this->input->get_post('organizer'),
            'date'      => $this->input->get_post('date'),
            'type'      => $this->input->get_post('type'),
            'future'    => $this->input->get_post('future')
        ];

        $paging = [];
        if ($this->input->get_post('start') !== NULL) {
            $paging['start'] = $this->input->get_post('start');
            $paging['end']   = $this->input->get_post('limit') ?: 10;
        }

        $list = $this->Schedule_model->get_schedule($search, $paging);

        echo json_encode(["status" => "success", "data" => $list]);
    }

    /**
     * 2. 일정 상세 정보 (상세데이터 + 이미지 갤러리)
     * URL: /DataApi/get_schedule_detail?idx=1
     */
    public function get_schedule_detail() {
        $idx = $this->input->get_post('idx');

        if (!$idx) {
            echo json_encode(["status" => "error", "message" => "idx is required"]);
            return;
        }

        $detail = $this->Schedule_model->get_detail_schedule($idx);
        $images = $this->Schedule_model->get_schedule_image($idx);

        if ($detail) {
            $detail['gallery'] = $images;
            echo json_encode(["status" => "success", "data" => $detail]);
        } else {
            echo json_encode(["status" => "error", "message" => "Data not found"]);
        }
    }

    /**
     * 3. 캘린더용 월별 일정 카운트
     * URL: /DataApi/get_calendar_status
     */
    public function get_calendar_status() {
        $year  = $this->input->get_post('year') ?: date('Y');
        $month = $this->input->get_post('month') ?: date('m');
        
        $search = [
            'country'   => $this->input->get_post('country'),
            'city'      => $this->input->get_post('city'),
            'organizer' => $this->input->get_post('organizer'),
            'type'      => $this->input->get_post('type')
        ];

        $counts = $this->Schedule_model->get_schedule_cnt($search, $year, $month);
        echo json_encode(["status" => "success", "data" => $counts]);
    }

    /**
     * 4. 지도 표시용 위치 정보 (최신 일정 기준 장소 정보)
     * URL: /DataApi/get_map_locations
     */
    public function get_map_locations() {
        $search = [
            'country' => $this->input->get_post('country'),
            'city'    => $this->input->get_post('city')
        ];

        $locations = $this->Schedule_model->get_space_info($search);
        echo json_encode(["status" => "success", "data" => $locations]);
    }

    /**
     * 5. 좋아요 업데이트
     * URL: /DataApi/update_like
     */
    public function update_like() {
        $idx  = $this->input->post('idx');
        $mode = $this->input->post('mode') ?: "1"; // "1":증가, "0":감소

        if (!$idx) {
            echo json_encode(["status" => "error", "message" => "idx is required"]);
            return;
        }

        $result = $this->Schedule_model->set_like($idx, $mode);
        echo json_encode(["status" => "success", "affected" => $result]);
    }

    /**
     * 6. 일정 삭제
     * URL: /DataApi/remove_schedule
     */
    public function remove_schedule() {
        $idx = $this->input->post('idx');
        
        if (!$idx) {
            echo json_encode(["status" => "error", "message" => "idx is required"]);
            return;
        }

        $result = $this->Schedule_model->delete_schedule($idx);
        echo json_encode(["status" => "success", "affected" => $result]);
    }
    
    /**
     * 7. 일정 신규 등록
     * URL: /DataApi/add_schedule
     * Method: POST
     */
    public function add_schedule() {
        // 1. 관련 모델 로드
        $this->load->model('country_model');
        $this->load->model('city_model');
        $this->load->model('space_model');

        // 2. 필수 입력값 수신
        $name = $this->input->post('name');
        $start_date = $this->input->post('start_date');
        
        // 검증 대상 명칭 수신
        $country_name = $this->input->post('country_name');
        $city_name = $this->input->post('city_name');
        $space_name = $this->input->post('space_name');

        if (empty($name) || empty($start_date) || empty($country_name) || empty($city_name) || empty($space_name)) {
            echo json_encode([
                "status" => "error", 
                "message" => "행사명, 시작일시, 국가명, 도시명, 장소명은 필수 항목입니다."
            ]);
            return;
        }

        // 3. 국가 검증 (country_model)
        $country_info = $this->country_model->get_country_name($country_name);
        if (empty($country_info)) {
            echo json_encode(["status" => "error", "message" => "존재하지 않는 국가명입니다."]);
            return;
        }
        $country_idx = $country_info['idx'];

        // 4. 도시 검증 (city_model)
        $city_info = $this->city_model->get_city_name($city_name);
        if (empty($city_info)) {
            echo json_encode(["status" => "error", "message" => "존재하지 않는 도시명입니다."]);
            return;
        }
        $city_idx = $city_info['idx'];

        // 5. 장소 검증 (space_model)
        $space_info = $this->space_model->get_space_name($space_name);
        if (empty($space_info)) {
            echo json_encode(["status" => "error", "message" => "존재하지 않는 장소명입니다."]);
            return;
        }
        $space_idx = $space_info['idx'];

        // 6. 파라미터 구성 (검증된 idx 사용)
        $params = [
            'name'             => $name,
            'company'          => $this->input->post('company'),
            'country_idx'      => $country_idx,
            'city_idx'         => $city_idx,
            'space_idx'        => $space_idx,
            'organization_idx' => $this->input->post('organization_idx'),
            'space'            => $space_name, // 문자열 장소명 저장
            'homepage'         => $this->input->post('homepage'),
            'addr'             => $this->input->post('addr'),
            'remark'           => $this->input->post('remark'),
            'start_date'       => $start_date,
            'end_date'         => $this->input->post('end_date') ?: $start_date,
            'face'             => $this->input->post('face'),
            'insta'            => $this->input->post('insta'),
            'yout'             => $this->input->post('yout'),
            'type'             => $this->input->post('type') ?: 'party'
        ];

        // 7. 일정 등록 실행
        $new_idx = $this->Schedule_model->insert_schedule($params);
        
        if ($new_idx) {
            echo json_encode([
                "status" => "success",
                "message" => "일정이 성공적으로 등록되었습니다.",
                "idx" => $new_idx
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "등록 중 DB 오류가 발생했습니다."]);
        }
    }
    
    /**
     * 8. 국가 추가 API (kpop_country 구조 맞춤)
     * URL: /DataApi/add_country
     */
    public function add_country() {
        $this->load->model('country_model');
        
        // 1. 필수값 체크
        $name = $this->input->post('name');
        if (empty($name)) {
            echo json_encode(["status" => "error", "message" => "국가명(name)은 필수입니다."]);
            return;
        }

        // 2. 중복 체크
        if ($this->country_model->get_country_name($name)) {
            echo json_encode(["status" => "error", "message" => "이미 등록된 국가명입니다."]);
            return;
        }

        // 3. 파라미터 구성 (테이블 컬럼명에 매칭)
        $params = [
            'name'      => $name,
            'ord'       => $this->input->post('ord') ?: 99,        // 정렬순서 (기본값 99)
            'space_x'   => $this->input->post('space_x'),         // decimal(65,15)
            'space_y'   => $this->input->post('space_y'),         // decimal(65,15)
            'writer'    => $this->input->post('writer') ?: 'admin', // 작성자
            'state'     => $this->input->post('state') ?: '1',      // 상태 ('1':활성, '2':비활성)
            'regi_date' => date('Y-m-d H:i:s'),
            'modi_date' => date('Y-m-d H:i:s')
        ];

        // 4. 모델 호출 및 결과 반환
        $new_idx = $this->country_model->insert_country($params);

        if ($new_idx) {
            echo json_encode([
                "status" => "success", 
                "idx" => $new_idx, 
                "message" => "국가 정보가 성공적으로 등록되었습니다."
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "데이터베이스 저장 중 오류가 발생했습니다."]);
        }
    }
    
    /**
     * 9. 도시 추가 API (kpop_city 구조 맞춤)
     * URL: /DataApi/add_city
     */
    public function add_city() {
        // 관련 모델 로드
        $this->load->model('city_model');
        $this->load->model('country_model');
        
        // 1. 필수값 체크
        $name = $this->input->post('name');
        $country_idx = $this->input->post('country_idx');

        if (empty($name) || empty($country_idx)) {
            echo json_encode([
                "status" => "error", 
                "message" => "도시명(name)과 소속 국가 번호(country_idx)는 필수입니다."
            ]);
            return;
        }

        // 2. 상위 국가 존재 여부 확인 (데이터 무결성 검사)
        // country_model에 해당 idx로 조회하는 함수가 있다고 가정 (없으면 기본 DB조회 사용)
        $country_exists = $this->db->where('idx', $country_idx)->get('kpop_country')->row();
        if (!$country_exists) {
            echo json_encode(["status" => "error", "message" => "유효하지 않은 국가 번호입니다."]);
            return;
        }

        // 3. 동일 국가 내 도시명 중복 체크 (선택 사항)
        $city_exists = $this->city_model->get_city_name($name);
        if ($city_exists && $city_exists['country_idx'] == $country_idx) {
            echo json_encode(["status" => "error", "message" => "해당 국가에 이미 등록된 도시명입니다."]);
            return;
        }

        // 4. 파라미터 구성 (kpop_city 컬럼 매칭)
        $params = [
            'country_idx' => $country_idx,
            'name'        => $name,
            'ord'         => $this->input->post('ord') ?: 99,
            'space_x'     => $this->input->post('space_x'),
            'space_y'     => $this->input->post('space_y'),
            'writer'      => $this->input->post('writer') ?: 'admin',
            'state'       => $this->input->post('state') ?: '1',
            'regi_date'   => date('Y-m-d H:i:s'),
            'modi_date'   => date('Y-m-d H:i:s')
        ];

        // 5. 모델 호출 및 결과 반환
        $new_idx = $this->city_model->insert_city($params);

        if ($new_idx) {
            echo json_encode([
                "status" => "success", 
                "idx" => $new_idx, 
                "message" => "도시 정보가 성공적으로 등록되었습니다."
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "데이터베이스 저장 중 오류가 발생했습니다."]);
        }
    }
    
    /**
     * 10. 장소 추가 API (kpop_space 구조 맞춤)
     * URL: /DataApi/add_space
     */
    public function add_space() {
        // 관련 모델 로드
        $this->load->model('space_model');

        // 1. 필수값 체크
        $space_name = $this->input->post('space_name');
        $country_idx = $this->input->post('country_idx');
        $city_idx = $this->input->post('city_idx');

        if (empty($space_name) || empty($country_idx) || empty($city_idx)) {
            echo json_encode([
                "status" => "error", 
                "message" => "장소명(space_name), 국가번호(country_idx), 도시번호(city_idx)는 필수입니다."
            ]);
            return;
        }

        // 2. 상위 데이터(국가/도시) 존재 여부 간이 체크 (생략 가능하나 권장)
        $city_exists = $this->db->where('idx', $city_idx)->get('kpop_city')->row();
        if (!$city_exists) {
            echo json_encode(["status" => "error", "message" => "유효하지 않은 도시 번호입니다."]);
            return;
        }

        // 3. 파라미터 구성 (kpop_space 컬럼 매칭)
        $params = [
            'country_idx'    => $country_idx,
            'city_idx'       => $city_idx,
            'space_name'     => $space_name,
            'space_location' => $this->input->post('space_location'), // 클럽위치 설명
            'space_x'        => $this->input->post('space_x'),        // 좌표X
            'space_y'        => $this->input->post('space_y'),        // 좌표Y
            'space_etc'      => $this->input->post('space_etc'),      // 클럽 상세설명
            'state'          => $this->input->post('state') ?: 'Y'    // 사용여부 (Y/N)
        ];

        // 4. 모델 호출 및 결과 반환
        $new_idx = $this->space_model->insert_space($params);

        if ($new_idx) {
            echo json_encode([
                "status" => "success", 
                "idx" => $new_idx, 
                "message" => "장소 정보가 성공적으로 등록되었습니다."
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "데이터베이스 저장 중 오류가 발생했습니다."]);
        }
    }
}