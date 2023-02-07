<?php
    // 데이터베이스 연결
    $DB_SERVER_NAME = "localhost";                  // 데이터베이스 주소
    $DB_USER_NAME = "sha";                          // 데이터베이스 사용자명
    $DB_USER_PASSWORD = "JlzpPX5briAE01K4";         // 데이터베이스 사용자 비밀번호    
    $DB_NAME = "sha";                               // 데이터베이스명

    // 관리자 비밀번호 초기화 시
    $INIT_ADMIN_PASS = "!sha2022!@#";

    define("ERR_UPLOAD_MESSAGE", array(
        '업로드 최대 크기 초과(post_max_size)', // 0
        '업로드 최대 크기 초과', // 1
        '업로드 최대 크기 초과(upload_max_filesize)', // 2
        '파일 부분적 업로드', //3
        '업로드 파일 없음', //4
        'TEMP 폴더 없음', //5
        '디스크 쓰기 실패', //6
        '업로드 불가 확장자(시스템 파일)', // 7
        '업로드 폴더 생성 오류', // 8
        '업로드 POST 실행 오류' , // 9
        '허용 불가 확장자 (허용가능 : %s)', // 10
        '동일한 파일명 존재', // 11
        '알 수 없는 오류 (%d %s)', //12
        '업로드 형식 미정의'
    ));

    // 오류 메시지 출력 처리, 실제 배포시에는 display_errors = 0으로
    error_reporting(E_ALL ^ E_NOTICE);
    ini_set("display_errors", 1);
?>

