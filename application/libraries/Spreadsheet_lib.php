<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Spreadsheet_lib
 * * CodeIgniter 3에서 PhpSpreadsheet 라이브러리를 로드하기 위한 Wrapper 클래스입니다.
 */
class Spreadsheet_lib {

    public function __construct() {
        // PhpSpreadsheet 라이브러리는 Composer로 관리되므로,
        // vendor/autoload.php 파일을 로드하여 모든 클래스를 자동으로 등록합니다.
        
        // 1. Composer Autoloader 파일 경로 설정
        // 일반적으로 Composer 설치는 CI 프로젝트 루트에서 이루어지지만,
        // 여기서는 PhpSpreadsheet 라이브러리가 third_party 폴더에 있다고 가정하고 경로를 설정합니다.
        
        // 💡 경로 확인: 프로젝트 구성에 따라 이 경로를 수정해야 합니다.
        // 현재 PhpSpreadsheet를 third_party 폴더 내에 설치하고, 그 안에 vendor 폴더가 있다고 가정합니다.
        $autoloader_path = APPPATH . 'third_party/PhpSpreadsheet/vendor/autoload.php';
        
        // 만약 vendor 폴더를 CI 프로젝트 루트에 설치했다면, 아래 경로를 사용합니다.
        // $autoloader_path = FCPATH . 'vendor/autoload.php'; 

        
        // 2. Autoloader 파일 로드
        if (file_exists($autoloader_path)) {
            require_once($autoloader_path); 
        } else {
            // 파일을 찾지 못하면 오류를 발생시켜 경로 문제를 사용자에게 알립니다.
            // PhpSpreadsheet 사용을 위해서는 이 파일이 필수적입니다.
            throw new Exception("Composer Autoloader not found at: " . $autoloader_path);
        }
    }

    /**
     * 필요하다면 여기에 PhpSpreadsheet 객체를 반환하는 헬퍼 메서드를 추가할 수 있습니다.
     * * @return \PhpOffice\PhpSpreadsheet\Spreadsheet
     */
    public function spreadsheet() {
        return new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    }
}