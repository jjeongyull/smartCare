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
    <link rel="stylesheet" href="css/board.css">
    <link rel="stylesheet" href="css/board_btn.css">

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
        <h1>자료실</h1>
    </div>
    <div class="section02">
        <?php
        if($row = mysqli_fetch_array($result)){

      
        ?>
        <div class="line">
            <div class="title">제목</div>
            <div class="text"><?= $row['b_title'] ?></div>
        </div>
        <div class="line">
            <div class="title">작성일</div>
            <div class="text"><?= $row['b_date'] ?></div>
        </div>
        <div class="line">
            <div class="title">작성자</div>
            <div class="text"><?= $row['b_writer'] ?></div>
        </div>
        <div class="content"> 
        <?= $row['b_contents'] ?>
        <div class="download">
            <a href="file/<?= $row['b_file'] ?>" download=""><img src='./img/sub04/file-regular 1.png' alt=''><?= $row['b_file'] ?></a>
        </div>
        </div>
        <?php } ?>
    </div>
        <div class="modBtn1">
            <a href="update2.php?b_idx=<?= $row['b_idx'] ?>">수정</a>
        </div>
        <form action="delete.php" method="post">
        <input type="hidden" name="b_idx" value="<?= $_GET['b_idx'] ?>">
        <input type="submit" value="삭제">
    </form>
    <?php
       $b_idx = $_GET['b_idx'];
    //    $no = $_GET['no'];

       $sql = "SELECT * FROM pds WHERE b_idx = $b_idx";
       $count_sql = "SELECT count(*) from pds";
       $p_sql = "SELECT * FROM pds WHERE b_idx < $b_idx ORDER BY b_idx DESC LIMIT 1;";
       $n_sql = "SELECT * FROM pds WHERE b_idx > $b_idx ORDER BY b_idx ASC LIMIT 1;";

       $result = mysqli_query($conn, $sql);
       $count_result = mysqli_query($conn, $count_sql);
       $p_result = mysqli_query($conn, $p_sql);
       $n_result = mysqli_query($conn, $n_sql);

       $array = mysqli_fetch_array($result);
       $row = mysqli_fetch_row($count_result);
       $total_count = $row[0];
       $p_array = mysqli_fetch_array($p_result);
       $n_array = mysqli_fetch_array($n_result);
       $b_title = $array['b_title'];
       $b_content = $array['b_contents'];
       $b_writer = $array['b_writer'];
       $b_date = $array['b_date'];

    //    $back_page = ($total_count - $no)/10;
    ?>
      <div class="view-list"><span class="title">이전글</span><p class="view-prev">
            <?php if(empty($p_array['b_idx'])){ ?>
              등록된 이전글이 없습니다.

            <?php } else { ?>
              
            <a href="b_writeView.php?b_idx=<?=$p_array['b_idx']?>"> <?=$p_array['b_title']?></a>
            <?php }?>
            </p>
        </div>

        <div class="view-list"><span class="title">다음글</span><p class="view-next">
            <?php if(empty($n_array['b_idx'])){ ?>
              등록된 다음글이 없습니다.
              <?php } else { ?>
              
              <a href="b_writeView.php?b_idx=<?=$n_array['b_idx']?>"> <?=$n_array['b_title']?></a>
              <?php }?>
              </p> 
        </div>
</section>
<div class="footer"></div>        
</body>
</html>