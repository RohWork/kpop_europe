<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter용 PhpSpreadsheet 라이브러리 래퍼 (CI 3 & No Composer)
 * * PHPOffice/PhpSpreadsheet 라이브러리의 클래스를 사용 가능하게 로드합니다.
 */
class Spreadsheet_lib {

    public function __construct() {
        // CI3의 third_party 폴더 경로 설정
        $path = APPPATH . 'third_party/PhpSpreadsheet/';
        
        if (!is_dir($path)) {
            exit('PhpSpreadsheet 라이브러리가 ' . $path . '에 없습니다.');
        }

        // PhpSpreadsheet의 오토로더를 로드합니다.
        // Composer를 사용하지 않는 경우, PhpSpreadsheet는 기본적으로 src/Bootstrap.php를 통해 클래스를 로드합니다.
        // 하지만 CI3 환경에서는 자체적으로 클래스 로딩을 처리해야 합니다.
        // 가장 간단한 방법은 직접 클래스 별칭을 지정하거나, 필요한 클래스만 require 하는 것입니다.
        
        // 여기서는 PhpSpreadsheet의 기본 로직인 클래스 로드를 사용합니다.
        // CI3의 `application/third_party/PhpSpreadsheet/` 내부에 `src/` 디렉토리가 있어야 합니다.
        
        require_once($path . 'src/PhpSpreadsheet/IOFactory.php'); 
        require_once($path . 'src/PhpSpreadsheet/Spreadsheet.php'); 
        
        // 추가적으로 필요한 클래스가 있다면 여기에 추가합니다.
        // 예를 들어:
        // require_once($path . 'src/PhpSpreadsheet/Worksheet/Worksheet.php');
    }
}