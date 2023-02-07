<?php

    session_start();

    include_once 'global.php';
    include_once 'function.php';
    include_once 'database.php';


    // 데이터베이스 커넥션 생성
    $databaseService = new DatabaseService($DB_SERVER_NAME, $DB_USER_NAME, $DB_USER_PASSWORD, $DB_NAME);
    $conn = $databaseService->getConnection();
    if ($conn === NULL)
    {
        $ERR_MSG = "데이터베이스 연결 오류 : " . $mysqli->connect_error;
        echo "<script>alert('" . $ERR_MSG . "');</script>";   
        die();
    }

    // 결과값 리턴 배열 선언
    $return_data = array();
    $data_array = array();

    // 설정할 경우 자바스크립트에서 객체로 인식, JSON 타입으로 리턴을 위해 설정
    Header('Content-Type: application/json');  

    // 명령 처리 구분
    $cmd = fn_URIString('cmd', "string", "");

    // 게시판 정보
    // 게시판 유형
    $board_type = fn_URIString('board_type', "string", "");
    // 게시물 제목
    $b_title = fn_URIString('b_title', "string", "");
    // 게시물 내용
    $b_contents = fn_URIString('b_contents', "string", "");
    // 게시물 작성자
    $b_writer = fn_URIString('b_writer', "string", "관리자");
    // 첨부 파일
    $b_file = fn_URIString('b_file', "string", "");
    // 수정, 삭제를 위한 idx
    $b_idx = fn_URIString('b_idx', "int", 0);
    // 페이지 정보 변수
    // 현재 페이지
    $b_nowpage = fn_URIString('b_nowpage', "int", 1);
    // 페이지당 카운트할 개수 (기본 10개씩 리턴)
    $b_loadcount = fn_URIString('b_loadcount', "int", 10);
    // 시작 페이지가 0보다 작을 경우 0으로 설정, 읽어들일 개수물 시작점
    $b_startcount = ($b_nowpage-1) * $b_loadcount;
    if ($b_startcount < 0) {
        $b_startcount = 0;
    }

    // 게시판 검색어
    $b_searchdata = fn_URIString('b_searchdata', "string", ""); 
    // 게시판 검색 유형
    $b_searchtype = fn_URIString('b_searchtype', "string", ""); 
    $b_search_sdate = fn_URIString('b_search_sdate', "string", ""); 
    $b_search_edate = fn_URIString('b_search_edate', "string", ""); 

    if (($b_searchtype <> "") && ($b_searchdata <> "")) {
        if ($b_searchtype == "s_title") {
            $b_searchdata = " b_title like '%" . $b_searchdata . "%' ";
        }
        else if  ($b_searchtype == "s_contents"){
            $b_searchdata = " b_contents like '%" . $b_searchdata . "%' ";
        }
        else if  ($b_searchtype == "s_writer"){
            $b_searchdata = " b_writer like '%" . $b_searchdata . "%' ";
        }    
    }

    if (($b_search_sdate <> "") &&  ($b_search_edate <> "")){
        if ($b_searchdata === ""){
            $b_searchdata = " DATE(b_date) = BETWEEN '" . $b_search_sdate . "' AND '" . $b_search_edate . "'";
        }else{
            $b_searchdata = $b_searchdata . " AND DATE(b_date) = BETWEEN '" . $b_search_sdate . "' AND '" . $b_search_edate . "'";
        }
    }
    else{
        if ($b_search_sdate <> "") {
            if ($b_searchdata === ""){
                $b_searchdata = " DATE(b_date) = '" . $b_search_sdate . "'";
            }else{
                $b_searchdata = $b_searchdata . " AND DATE(b_date) = '" . $b_search_sdate . "'";
            }
        }
        if ($b_search_edate <> "") {
            if ($b_searchdata === ""){
                $b_searchdata = " DATE(b_date) = '" . $b_search_edate . "'";
            }else{
                $b_searchdata = $b_searchdata . " AND DATE(b_date) = '" . $b_search_edate . "'";
            }
        }
    }
    
    // 관리자 로그인 정보
    $login_id = fn_URIString('login_id', "string", "");  
    $login_password = fn_URIString('login_password', "string", "");  

    // 타겟 테이블 설정
    switch ($board_type){
        case "notice" :
            $tbl_name = "notice";
            break;
        case "pds" :
            $tbl_name = "pds";
            break;
        case "news" :
            $tbl_name = "news";
            break;
        case "contact" :
            $tbl_name = "contact";
            break;
        case "login" :
            $tbl_name = "member";
        default:
            break;
    }

    switch ($cmd){
        // 관리 테이블 초기화
        // 관리자 정보 테이블의 패스워드를 초기화 시킨다.
        // mem_id에 admin이 없을 경우 id=admin, pw=INIT_ADMIN_PASS 를 등록한다.
        case "init" :
            $sql = "SELECT count(mem_id) as cnt FROM ". $tbl_name . " where mem_id = 'admin'";
            // PDO 준비
            try{
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $count = $stmt->fetchColumn();
                if ($count == 0){
                    $sql = "INSERT INTO " . $tbl_name . " (mem_id, mem_password, mem_type) VALUES (:mem_id, :mem_password, '1')";
                    $admin_id = "admin";
                    $admin_password = hash("sha256", utf8_encode($INIT_ADMIN_PASS));
                    try{                    
                        $stmt = $conn->prepare($sql);
                        $stmt->bindValue(":mem_id", $admin_id, PDO::PARAM_STR);
                        $stmt->bindValue(":mem_password", $admin_password, PDO::PARAM_STR);
                        $stmt->execute();
                        $count = $stmt->rowCount();
                        if ($count == 1){
                            $tmp_json["value"] = "ok";
                            $tmp_json["desc"] = "insert";
                            $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                        }
                        else{
                            $tmp_json["value"] = "fail";
                            $tmp_json["desc"] = $admin_password;
                            $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                        }
                        echo($return_data);    
                    }
                    catch(PDOException $e){
                        $tmp_json["value"] = "fail";
                        $tmp_json["desc"] = $e->getMessage();
                        $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                        echo($return_data);      
                    }
                }
                else{
                    // 주의 : PDO를 사용할 경우 Update가 일어나지 않을 경우 rowCount는 0을 반환 (mysql에서 동일한 값이 있을 경우 0을 반환한다.)
                    $sql = "UPDATE ". $tbl_name . " SET mem_password = :init_password WHERE mem_id = 'admin'";
                    try{
                        // PDO 준비
                        $stmt = $conn->prepare($sql);
                        $admin_password = hash("sha256", utf8_encode($INIT_ADMIN_PASS));
                        // 파라미터 바인딩, ?로 할 경우 bindValue로 
                        $stmt->bindValue(":init_password", $admin_password, PDO::PARAM_STR);
                        $stmt->execute();
                        if ($stmt !== false){
                            $tmp_json["value"] = "ok";
                            $tmp_json["desc"] = "update";
                            $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                            echo($return_data);      
                        }
                        else{
                            $tmp_json["value"] = "fail";
                            $tmp_json["desc"] = '쿼리 실행 처리 오류';
                            $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                            echo($return_data);       
                        }
                    }
                    catch(PDOException $e){
                        $tmp_json["value"] = "fail";
                        $tmp_json["desc"] = $e->getMessage();
                        $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                        echo($return_data);      
                    }
                }
                /*
                while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
                    print "Name: <p>{$row[0] $row[1]}</p>";
                }
                */
            }
            catch(PDOException $e){
                $tmp_json["value"] = "fail";
                $tmp_json["desc"] = $e->getMessage();
                $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);      
            }
            break;
        case "login" :
            $sql = "SELECT count(mem_id) as cnt FROM ". $tbl_name . " where mem_id = :login_id and mem_password = :login_password";
            $login_password = hash("sha256", utf8_encode($login_password));
            // PDO 준비
            try{
                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":login_id", $login_id, PDO::PARAM_STR);
                $stmt->bindValue(":login_password", $login_password, PDO::PARAM_STR);
                $stmt->execute();
                $count = $stmt->fetchColumn();
                if ($count == 1){
                    try{          
                        // 세션을 설정한다.
                        $_SESSION["login_id"] = "admin";
                        $tmp_json["value"] = "ok";
                        $tmp_json["desc"] = "login success";
                        $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                        echo($return_data);    
                    }
                    catch(PDOException $e){
                        $tmp_json["value"] = "fail";
                        $tmp_json["desc"] = $e->getMessage();
                        $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                        echo($return_data);      
                    }
                }
                else{
                    $tmp_json["value"] = "fail";
                    $tmp_json["desc"] = "login fail(2)";
                    $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);     
                    echo($return_data);      
                }
            }
            catch(PDOException $e){
                $tmp_json["value"] = "fail";
                $tmp_json["desc"] = $e->getMessage();
                $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);      
            }
            break;
        // contact
        case "write":
            // contact일 경우 email => b_title, name => b_writer, message => b_contents에 저장
            $sql = "INSERT INTO ". $tbl_name . " (b_title, b_contents, b_writer, b_file, b_date) VALUES" ;
            $sql = $sql . "(:b_title, :b_contents, :b_writer, :b_file, now())";
            try{
                // PDO 준비
                $stmt = $conn->prepare($sql);
                // 파라미터 바인딩, ?로 할 경우 bindValue로 
                $stmt->bindParam(":b_title", $b_title, PDO::PARAM_STR);
                $stmt->bindParam(":b_contents", $b_contents, PDO::PARAM_STR);
                $stmt->bindParam(":b_writer", $b_writer, PDO::PARAM_STR);
                $stmt->bindParam(":b_file", $b_file, PDO::PARAM_STR);
                $stmt->execute();
                if (($stmt->rowCount()) > 0){
                    $tmp_json["value"] = "ok";
                    $tmp_json["desc"] = "write";
                    $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                    echo($return_data);      
                }
                else{
                    $tmp_json["value"] = "fail";
                    $tmp_json["desc"] = $b_title . $b_contents . $b_writer . $sql;
                    $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                    echo($return_data);      
                }
            }
            catch(PDOException $e){
                $tmp_json["value"] = "fail";
                $tmp_json["desc"] = $e->getMessage();
                $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);      
            }
            break;
        case "update" :
            $sql = "UPDATE ". $tbl_name . " SET b_title = :b_title, b_contents = :b_contents WHERE b_idx = :b_idx";
            //echo $sql;
            try{
                // PDO 준비
                $stmt = $conn->prepare($sql);
                // 파라미터 바인딩, ?로 할 경우 bindValue로 
                $stmt->bindValue(":b_title", $b_title, PDO::PARAM_STR);
                $stmt->bindValue(":b_contents", $b_contents, PDO::PARAM_STR);
                $stmt->bindValue(":b_idx", $b_idx, PDO::PARAM_INT);
                $stmt->execute();
                //$stmt->debugDumpParams();
                if ($stmt !== false){
                    $tmp_json["value"] = "ok";
                    $tmp_json["desc"] = "update";
                    $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                    echo($return_data);      
                }
                else{
                    $tmp_json["value"] = "fail";
                    $tmp_json["desc"] = '쿼리 실행 처리 오류';
                    $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                    echo($return_data);       
                }
            }
            catch(PDOException $e){
                $tmp_json["value"] = "fail";
                $tmp_json["desc"] = $e->getMessage();
                $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);      
            }
            break;
        case "delete" :
            $sql = "DELETE FROM " . $tbl_name . " WHERE b_idx = :b_idx";
            try{
                // PDO 준비
                $stmt = $conn->prepare($sql);
                // 파라미터 바인딩, ?로 할 경우 bindValue로 
                $stmt->bindParam(":b_idx", $b_idx, PDO::PARAM_INT);
                $stmt->execute();
                if (($stmt->rowCount()) > 0){
                    $tmp_json["value"] = "ok";
                    $tmp_json["desc"] = "";
                    $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                    echo($return_data);      
                }else{
                    $tmp_json["value"] = "fail";
                    $tmp_json["desc"] = $b_idx . $b_title . $b_contents . $b_writer . $sql;
                    $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                    echo($return_data);      
                }
            }
            catch(PDOException $e){
                $tmp_json["value"] = "fail";
                $tmp_json["desc"] = $e->getMessage();
                $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);      
            }
            break; 
        case "load":
            // 검색이 아닐 경우 
            if ($b_searchdata === ""){
                $sql = "SELECT * FROM " . $tbl_name . " order by b_idx desc limit " . $b_startcount . ", " . $b_loadcount; 
                $sql_count = "SELECT count(b_idx) as cnt FROM " . $tbl_name; 
            }
            else{
                $sql = "SELECT * FROM " . $tbl_name . " WHERE" . $b_searchdata . " order by b_idx desc limit " . $b_startcount . ", " . $b_loadcount; 
                $sql_count = "SELECT count(b_idx) as cnt FROM " . $tbl_name . " WHERE" . $b_searchdata; 

            }
            //echo $sql;
            try{
                $stmt = $conn->prepare($sql_count);
                $stmt->execute();
                $totcount = $stmt->fetchColumn();

                $stmt = $conn->prepare($sql);
                $stmt->execute();
                $nowpage = $b_nowpage;
                while($row = $stmt->fetchAll(PDO::FETCH_ASSOC))
	              {
                    $data_array = $row;
                }   
                $result_data = array("totcount"=>$totcount, "nowpage"=>$nowpage);
                $result_data["tabledata"] = $data_array;
                $return_data = json_encode($result_data, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);      
            }
            catch(PDOException $e){
                $tmp_json["value"] = "fail";
                $tmp_json["desc"] = $e->getMessage();
                $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);      
            }
            break;
        // 수정이면
        case "modify" : 
            // 주의 : PDO를 사용할 경우 Update가 일어나지 않을 경우 rowCount는 0을 반환 (mysql에서 동일한 값이 있을 경우 0을 반환한다.)
            $sql = "UPDATE ". $tbl_name . " SET b_title = :title, b_contents = :contents WHERE b_idx = :idx";
            try{
                // PDO 준비
                $stmt = $conn->prepare($sql);
                $admin_password = hash("sha256", utf8_encode($INIT_ADMIN_PASS));
                // 파라미터 바인딩, ?로 할 경우 bindValue로 
                $stmt->bindValue(":title", $b_title, PDO::PARAM_STR);
                $stmt->bindValue(":contents", $b_contents, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt !== false){
                    $tmp_json["value"] = "ok";
                    $tmp_json["desc"] = "update";
                    $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                    echo($return_data);      
                }
                else{
                    $tmp_json["value"] = "fail";
                    $tmp_json["desc"] = '쿼리 실행 처리 오류';
                    $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                    echo($return_data);       
                }
            }
            catch(PDOException $e){
                $tmp_json["value"] = "fail";
                $tmp_json["desc"] = $e->getMessage();
                $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
                echo($return_data);      
            }
            break;
        default:
            break;
        }
    $conn=null;
?>