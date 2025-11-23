<?php
// /application/third_party/PhpSpreadsheet/autoload.php 파일 내용

$baseDir = __DIR__ . '/src/PhpSpreadsheet/';

// 필수 Reader 클래스 수동 등록 (Excel, CSV 등을 위해)
$requiredClasses = [
    

    
    'IOFactory.php',
    'Spreadsheet.php',
    'Shared/File.php',
    'Reader/ReadFilterInterface.php',
    'Reader/DefaultReadFilter.php',
    'Reader/BaseReader.php',
    'Reader/IReader.php',
    'Reader/Xlsx.php', 
    'Reader/Csv.php',
    'Reader/Ods.php',
    'Reader/Xls.php',
    'Reader/Xml.php',
    'Reader/IReadFilter.php', 
    

    
    'Reader/BaseReader.php',
    // 다른 Reader/Writer 클래스도 필요하면 추가합니다.
];

foreach ($requiredClasses as $file) {
    if (file_exists($baseDir . $file)) {
        require_once($baseDir . $file);
    }
}

// 나머지 클래스들을 위한 기본적인 SPL Autoloader 등록
spl_autoload_register(function ($className) use ($baseDir) {
    // PhpOffice\PhpSpreadsheet\... 클래스만 처리
    if (strpos($className, 'PhpOffice\\PhpSpreadsheet\\') === 0) {
        
        // 네임스페이스 경로를 파일 경로로 변환
        $file = $baseDir . str_replace('PhpOffice\\PhpSpreadsheet\\', '', $className) . '.php';
        $file = str_replace('\\', '/', $file);
        
        if (file_exists($file)) {
            require_once($file);
        }
    }
});