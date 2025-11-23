<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spreadsheet_lib {

    public function __construct() {
        
        // 1. 수동으로 생성한 Autoloader 파일의 경로 설정
        $autoloader_path = APPPATH . 'third_party/PhpSpreadsheet/autoload.php';
        
        // 2. Autoloader 파일 호출
        if (file_exists($autoloader_path)) {
            require_once($autoloader_path); 
        } else {
            // 파일이 없다면 에러를 발생시켜 경로 문제를 즉시 알 수 있도록 합니다.
            throw new Exception("PhpSpreadsheet Autoloader not found at: " . $autoloader_path);
        }
        
        // 주의: 모든 수동 require_once는 제거해야 합니다.
    }

}