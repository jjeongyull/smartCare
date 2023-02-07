<?php
require_once('db.php')
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>공지사항</title>

    <!--style-->
    <link rel="stylesheet" href="css/common/reset.css">
    <link rel="stylesheet" href="css/text.css">
    
    <!--script-->
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script  src="js/common.js"></script>
    <script  src="js/ck_event.js"></script>
    <script  src="js/api.js"></script>
        
</head>
<body>
<?php

            $b_idx = $_POST['b_idx'];
            $b_title = $_POST['b_title'];
            $b_content = $_POST['b_content'];

            $sql = "UPDATE notice SET b_title = '$b_title', b_content = '$b_content' WHERE b_idx = '$b_idx'";
            
            $result = mysqli_query($conn, $sql);

            if($result === false){
                echo '수정하지 못했습니다.';
                error_log(mysqli_error($conn));
            }else{
                echo "<div class='text'>수정하였습니다.</div>";
            }
            mysqli_close($conn);
            print "<a href='b_write0.php'>확인</a>"
?> 
</body>
</html>           