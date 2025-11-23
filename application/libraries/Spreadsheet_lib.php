<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter용 PhpSpreadsheet 라이브러리 래퍼 (CI 3 & No Composer)
 * * PHPOffice/PhpSpreadsheet 라이브러리의 클래스를 사용 가능하게 로드합니다.
 */
class Spreadsheet_lib {

    public function __construct() {
        // CI3의 third_party 폴더 경로 설정
        $lib_path = APPPATH . 'third_party/PhpSpreadsheet/';
        
        // 💡 1단계: 필수 의존성 클래스 로드
        // IOFactory가 사용하기 위해 필요한 클래스입니다.
        // 경로: /var/www/kpop_europe/application/third_party/PhpSpreadsheet/src/PhpSpreadsheet/Shared/File.php
        require_once($lib_path . 'src/PhpSpreadsheet/Shared/File.php'); // <-- 이 한 줄을 추가합니다!
        
        // 2단계: IOFactory 로드 (Shared\File 클래스를 사용하기 때문에 이제 오류가 나지 않음)
        require_once($lib_path . 'src/PhpSpreadsheet/IOFactory.php'); 
        
        // (필요하다면 다른 핵심 클래스도 로드합니다.)
        // require_once($lib_path . 'src/PhpSpreadsheet/Spreadsheet.php');
    }
}