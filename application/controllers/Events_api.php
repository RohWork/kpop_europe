<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Events_api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // 사용하는 모델을 로드합니다
        $this->load->model('Schedule_model');
        $this->load->model('Country_model');
        $this->load->model('City_model');
        $this->load->model('Space_model');
    }

    /**
     * Python 크롤러에서 호출할 엔드포인트 함수
     * 주소 예시: http://도메인/index.php/Events_api/insert_event
     */
    public function insert_event() {
        // 응답을 JSON 형식으로 설정
        header("Content-Type: application/json; charset=UTF-8");

        // POST로 전달된 JSON 데이터 읽기
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);

        if (empty($data)) {
            echo json_encode(['status' => 'error', 'error_code' => 'ERR_EMPTY_DATA', 'message' => '입력된 데이터가 없습니다.']);
            return;
        }

        // 행사명(name) 중복 체크
        $event_name = isset($data['name']) ? $data['name'] : null;
        if ($event_name) {
            // 모델에서 행사명이 이미 존재하는지 확인 (존재하면 true 반환)
            $is_duplicate = $this->Schedule_model->check_event_exists($event_name);
            if ($is_duplicate) {
                echo json_encode(['status' => 'duplicate', 'error_code' => 'ERR_DUPLICATE_NAME', 'message' => '이미 존재하는 행사명입니다.']);
                return;
            }
        }

        // 파이썬 크롤러에서 전달받은 국가명, 도시명을 이용하여 모델에서 idx 조회
        $country_name = isset($data['country_name']) ? $data['country_name'] : null;
        $city_name = isset($data['city_name']) ? $data['city_name'] : null;

        $country_idx = null;
        $city_idx = null;

        if ($country_name) {
            $country_row = $this->Country_model->get_country_name($country_name);
            if (!empty($country_row) && isset($country_row['idx'])) {
                $country_idx = $country_row['idx'];
            } else {
                echo json_encode(['status' => 'error', 'error_code' => 'ERR_COUNTRY_NOT_FOUND', 'message' => "등록되지 않은 국가명입니다: " . $country_name]);
                return;
            }
        }
        if ($city_name) {
            $city_row = $this->City_model->get_city_name($city_name);
            if (!empty($city_row) && isset($city_row['idx'])) {
                $city_idx = $city_row['idx'];
            } else {
                echo json_encode(['status' => 'error', 'error_code' => 'ERR_CITY_NOT_FOUND', 'message' => "등록되지 않은 도시명입니다: " . $city_name]);
                return;
            }
        }

        $space_x = isset($data['space_x']) ? $data['space_x'] : null;
        $space_y = isset($data['space_y']) ? $data['space_y'] : null;
        $space_idx = isset($data['space_idx']) ? (int)$data['space_idx'] : null;

        if ($space_x && $space_y) {
            // 좌표로 기존 공간 검색
            $space_row = $this->Space_model->get_space_xy($space_x, $space_y);
            
            if (!empty($space_row) && isset($space_row['idx'])) {
                $space_idx = $space_row['idx'];
            } else {
                // 존재하지 않으면 새로 인서트
                $space_params = array(
                    'country_idx'    => $country_idx,
                    'city_idx'       => $city_idx,
                    'space_name'     => isset($data['space']) ? $data['space'] : null,
                    'space_location' => isset($data['addr']) ? $data['addr'] : null,
                    'space_x'        => $space_x,
                    'space_y'        => $space_y,
                    'space_etc'      => null,
                    'state'          => 'Y'
                );
                
                $new_space_idx = $this->Space_model->insert_space($space_params);
                if ($new_space_idx) {
                    $space_idx = $new_space_idx;
                }
            }
        }

        // DB에 입력할 배열 구성 (타입 변환 및 기본값 null 처리 포함)
        $insert_data = array(
            'name'             => isset($data['name']) ? $data['name'] : null,
            'company'          => isset($data['company']) ? $data['company'] : null,
            'country_idx'      => $country_idx,
            'city_idx'         => $city_idx,
            'organization_idx' => isset($data['organization_idx']) ? (int)$data['organization_idx'] : null,
            'space'            => isset($data['space']) ? $data['space'] : null,
            'space_idx'        => $space_idx,
            'space_x'          => $space_x,
            'space_y'          => $space_y,
            'homepage'         => isset($data['homepage']) ? $data['homepage'] : null,
            'addr'             => isset($data['addr']) ? $data['addr'] : null,
            'face'             => isset($data['face']) ? $data['face'] : null,
            'face_foll'        => isset($data['face_foll']) ? (int)$data['face_foll'] : null,
            'insta'            => isset($data['insta']) ? $data['insta'] : null,
            'insta_foll'       => isset($data['insta_foll']) ? (int)$data['insta_foll'] : null,
            'yout'             => isset($data['yout']) ? $data['yout'] : null,
            'yout_foll'        => isset($data['yout_foll']) ? (int)$data['yout_foll'] : null,
            'remark'           => isset($data['remark']) ? $data['remark'] : null,
            'start_date'       => isset($data['start_date']) ? $data['start_date'] : null,
            'end_date'         => isset($data['end_date']) ? $data['end_date'] : null,
            'reg_date'         => date("Y-m-d H:i:s"), // 현재 시간
            'udt_date'         => date("Y-m-d H:i:s"), // 현재 시간
            'type'             => isset($data['type']) ? $data['type'] : null,
            'great'            => isset($data['great']) ? (int)$data['great'] : null
        );

        // 모델의 함수를 호출하여 DB에 데이터 삽입
        $insert_id = $this->Schedule_model->insert_event_data($insert_data);

        if ($insert_id) {
            echo json_encode([
                'status' => 'success',
                'message' => '데이터가 성공적으로 등록되었습니다.',
                'insert_id' => $insert_id
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'error_code' => 'ERR_DB_INSERT_FAIL',
                'message' => '데이터베이스 삽입에 실패했습니다.'
            ]);
        }
    }
}
