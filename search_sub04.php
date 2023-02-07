<?php
require_once('db.php')
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항 & 새소식</title>
    
    <!--style-->
    <link rel="stylesheet" href="css/common/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/sub04.css">
    <link rel="stylesheet" href="css/table2.css">
    <link rel="stylesheet" href="css/search.css">

    <!--script-->
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script  src="js/common.js"></script>
    <script  src="js/ck_event.js"></script>
    
</head>
<body>
    <div class="common-header"></div>

    <div class="banner">
        <div class="imgBox">
        </div>
        <div class="textBox">
            <h2>공지사항 & 새소식</h2>
        </div>
    </div>

    <section>
        <div class="section01">
            <h1>공지사항 & 새소식</h1>
        </div>
        <div class="listBtn">
            <a href="sub04.php">목록보기</a>
        </div>
        <div class="section02">
            <div class="notice">
                <div class="title1">번호</div>
                <div class="title2">제목</div>
                <div class="title3">작성자</div>
                <div class="title4">등록일</div>
            </div>
        </div>
        <div class="section03">
        <?php
            $user_skey = $_POST['skey'];

             $sql = "SELECT * FROM notice WHERE b_title LIKE '%$user_skey%'";
             if ($result = $conn->query($sql)){
                 while($row = $result->fetch_array(MYSQLI_ASSOC)) {      // 필드명도 함께 출력
                    $data_array[] = $row; 

                // $sql = "SELECT * FROM news order by b_idx desc limit 0,10";
                // $result = $conn->query($sql);

                // while ($row = $result->fetch_assoc()){
                    
                 
                echo"<div class='table'>",
                    "<div class='col1'>", $row['b_idx'] ,"</div>",
                    "<div class='col2'><a href='view.php?b_idx={$row['b_idx']}'>", $row['b_title'],"</a></div>",
                    "<div class='col3'>", $row['b_writer'], "</div>",
                    "<div class='col4'>", $row['b_date'], "</div>",
                    "</div>";           
            } 
            $result->close();
        } else
        {
            $tmp_json["value"] = "fail";
            $tmp_json["desc"] = $mysqli->error . $sql;          
            $return_data = json_encode($tmp_json, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
            echo($return_data);          
        }
        $conn->close();
            ?>
        </div>
    </section>

    <div class="footer"></div>
</body>
</html>