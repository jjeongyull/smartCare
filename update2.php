<?php
require_once('db.php')
?>
        <?php
            $view_num = $_GET['b_idx'];
             $sql = "SELECT * FROM pds WHERE b_idx = $view_num";
             $result = mysqli_query($conn, $sql);
            ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>자료실</title>

    <!--style-->
    <link rel="stylesheet" href="css/common/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/sub05.css">
    <link rel="stylesheet" href="css/writer02.css">
    
    <!--script-->
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script  src="js/common.js"></script>
    <script  src="js/ck_event.js"></script>
    <script  src="js/api.js"></script>
        
</head>
<body>
    <div class="common-header"></div>

    <div class="banner">
        <div class="imgBox">
        </div>
        <div class="textBox">
            <h2>자료실</h2>
        </div>
    </div>

    <section>
        <div class="section01">
            <h1>수정하기</h1>
        </div>

        <div class="section12">
            <div class="inner">
            <?php
        if($row = mysqli_fetch_array($result)){

      
        ?>
                <form class="title" action="insert_update2.php" method="post">
                        <input type="hidden" name="b_idx" value="<?= $view_num ?>">
                    <p>
                        <label for="b_title">제목</label>
                        <input type="text" id="title" name="b_title" value="<?= $row['b_title'] ?>" placeholder="제목을 입력하세요.">    
                    </p>
                    <p>
                        <label for="b_content">내용</label>
                        <textarea id="content" name="b_content" cols="50" rows="10" placeholder="내용을 입력하세요."><?= $row['b_contents'] ?></textarea>
                    </p>
                   <p>
                        <input type="submit" value="수정하기">
                </form>    
        <?php } ?>            
            </div>
        </div>
    </section>

    <div class="footer"></div>
    
</body>
</html>


