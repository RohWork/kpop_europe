<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spreadsheet_lib {

    public function __construct() {
        
        $lib_path = APPPATH . 'third_party/PhpSpreadsheet/';
        $src_base = $lib_path . 'src/PhpSpreadsheet/'; // 소스 파일 기본 경로 설정
        
        // 💡 1. IOFactory 실행에 필요한 의존성 클래스 로드 (Shared/File)
        require_once($src_base . 'Shared/File.php');
        
        // 💡 2. IOFactory 로드 (IOFactory는 파일 유형을 감지하는 역할)
        require_once($src_base . 'IOFactory.php'); 

        // 💡 3. 새로 추가: IOFactory가 XLSX 파일을 읽기 위해 필요한 Reader 클래스 로드
        // 경로: /.../PhpSpreadsheet/src/PhpSpreadsheet/Reader/Xlsx.php
        require_once($src_base . 'Reader/Xlsx.php'); 
        
        // 추가: Xlsx 리더가 사용하는 필수 필터 클래스를 함께 로드해 주는 것이 좋습니다.
        require_once($src_base . 'Reader/ReadFilterInterface.php');
        require_once($src_base . 'Reader/DefaultReadFilter.php');
        
        // 추가: 다른 형식(CSV, ODS 등)을 사용한다면 해당 Reader 클래스도 추가해야 합니다.
        // 예: require_once($src_base . 'Reader/Csv.php');

    }
}