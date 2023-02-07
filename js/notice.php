<?php
 // 데이터베이스 연결
 $DB_SERVER_NAME = "localhost";                  // 데이터베이스 주소
 $DB_USER_NAME = "root";                        // 데이터베이스 사용자명
 $DB_USER_PASSWORD = "!shadb2022!@#";            // 데이터베이스 사용자 비밀번호
 $DB_NAME = "sha";                               // 데이터베이스명

 // 데이터베이스 커넥션 생성
 $mysqli = new mysqli($DB_SERVER_NAME, $DB_USER_NAME, $DB_USER_PASSWORD, $DB_NAME);
 if ($mysqli->connect_errno) {
     $ERR_MSG = "데이터베이스 연결 오류 : " . $mysqli->connect_error;
     echo "<script>alert('" . $ERR_MSG . "');</script>";   
     exit();
 }

 // DB 한글 꺠짐 처리
 mysqli_query ($mysqli, 'SET NAMES utf8'); 
 mysqli_query ($mysqli, 'set session character_set_connection=utf8');
 mysqli_query ($mysqli, 'set session character_set_results=utf8');
 mysqli_query ($mysqli, 'set session character_set_client=utf8');


 // 결과값 리턴 배열 선언
 $return_data = array();
 $data_array = array();
 // 설정할 경우 자바스크립트에서 객체로 인식
 Header('Content-Type: application/json');  

    // write.html에서 넘어온 값 처리
    $cmd = isset($_POST['cmd']) ? $_POST['cmd'] : "";           
    if ($cmd == ""){
        $cmd = isset($_GET['cmd']) ? $_GET['cmd'] : "";         
    }
    $title = isset($_POST['title']) ? $_POST['title'] : "";           
    if ($title == ""){
        $title = isset($_GET['title']) ? $_GET['title'] : "";         
    }
    $contents = isset($_POST['contents']) ? $_POST['contents'] : "";           
    if ($contents == ""){
        $contents = isset($_GET['contents']) ? $_GET['contents'] : "";         
    }
    $file = isset($_POST['file']) ? $_POST['file'] : "";           
    if ($file == ""){
        $file = isset($_GET['file']) ? $_GET['file'] : "";         
    }

   
    switch ($cmd){
        // 입력이면
        case "write" :

            $sql = "INSERT INTO news (b_title, b_content, b_writer, b_date, b_file) VALUES" ;
            $sql = $sql . "('" . $title . "', '" . $contents . "', 'admin', now(), '" . $file . "')";
            //echo $sql;
            if ($result = $mysqli->query($sql)){
                $tmp_json["value"] = "ok";
                $tmp_json["desc"] = "";
                $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);      
            }   
            else
            {
                $tmp_json["value"] = "fail";
                $tmp_json["desc"] = $mysqli->error;
                $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);          
            }
            break;
        // 수정이면
        case "modify" : 
           
            break;
        case "delete" : 
            break;
        // 불러오기
        case "btn_load" : 
            $sql = "select * from news";
            if ($result = $mysqli->query($sql)){
                while($row = $result->fetch_array(MYSQLI_ASSOC)) {      // 필드명도 함께 출력
                   $data_array[] = $row; 

               }   
               $result_data = array("totcount"=>$totcount, "nowpage"=>$nowpage);
               $result_data["tabledata"] = $data_array;

               $return_data = json_encode($result_data, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
               echo($return_data);     
               $result->close();
           }   
           else
           {
               $tmp_json["value"] = "fail";
               $tmp_json["desc"] = $mysqli->error . $sql;          
               $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
               echo($return_data);          
           }

            break;
        default:
            break;
    }
    $mysqli->close();
?>