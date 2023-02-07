<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTACT</title>
    
    <!--style-->
    <link rel="stylesheet" href="css/common/reset.css">
    <link rel="stylesheet" href="css/text.css">
    

    <!--script-->
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script  src="js/common.js"></script>
    
</head>
<body>
<?php
require_once('db.php')
?>
<?php
    $b_idx = $_POST['b_idx'];

    $sql = "DELETE FROM contact WHERE b_idx = $b_idx";
    $result = $conn->query($sql);
    if($result === false){
        echo '삭제가 되지 않았습니다.';
        error_log(mysqli_error($conn));
    }else{
        echo "<div class='text'>삭제가 완료되었습니다.</div>";
    }
    mysqli_close($conn);
    print "<a href='contact.php'>확인</a>"
?>
</body>
</html>