<?php include $_SERVER["DOCUMENT_ROOT"]."contactPage.php" ?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTACT</title>
    
    <!--style-->
    <link rel="stylesheet" href="css/common/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/sub04.css">
    <link rel="stylesheet" href="css/table2.css">
    <link rel="stylesheet" href="css/page.css">
    <link rel="stylesheet" href="css/search.css">

    <!--script-->
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script  src="js/common.js"></script>
    <script  src="js/ck_event.js"></script>
    
</head>
<body>
    <div class="common-header"></div>

    <div class="banner">
        <div class="textBox">
            <h2>CONTACT</h2>
        </div>
    </div>

    <section>
        <div class="section01">
            <h1>CONTACT</h1>
        </div>
        <div class="section02">
            <div class="notice">
                <div class="title1">번호</div>
                <div class="title2">이름</div>
                <div class="title3">작성자</div>
                <div class="title4">등록일</div>
            </div>
        </div>
        <div class="section03">
        <?php
              include $_SERVER['DOCUMENT_ROOT'].'db.php';
              $sql="select * from contact order by b_idx desc limit $offset, $list_num";
              $result=mysqli_query($conn, $sql);
              while($row=mysqli_fetch_array($result)){
                  $b_idx=$row['b_idx'];
                  $b_name=$row['b_name'];
                  $b_email=$row['b_email'];
                  $b_msg=$row['b_msg'];
                  $b_date=$row['b_date'];
            ?>
                      
                   
                      <div class='table'>
                      <div class='col1'><?= $row['b_idx'] ?></div>
                      <div class='col2'><a href='contactView.php?b_idx=<?= $row['b_idx'] ?>'><?= $row['b_name'] ?></a></div>
                      <div class='col3'><?= $row['b_name'] ?></div>
                      <div class='col4'><?= $row['b_date'] ?></div>
                      </div>
                         
                      <?php
          $cur_num --;}
          ?>
           <div class="pager">
    <?php
            //  페이징 디자인  // 
            if($block > 1) {
                $prev=$first-1;
            ?>  
            <a href='sub04.php?page=1' id='prev' class="page">
                이전
            </a>
            <?php
                }
            if($page > 1) {
            $go_page=$page-1;
            ?>
                <a href='sub04.php?page=<?=$go_page?>' class="page">
                이전
                </a>
        <?php
                }
            for ($page_link=$first+1;$page_link<=$last;$page_link++) {
            if($page_link==$page) {
        ?>
            <a class="page on"><?=$page_link?></a>
        <?php 
            }else {
        ?>
            <a href='sub04.php?page=<?=$page_link?>' class="page">
                <?=$page_link?>
            </a> 
        <?php
            }
        ?>
        <?php
                }
                if ($block < $total_block) {
                $next_page=$page+1;
        ?>
                <a href='sub04.php?page=<?=$next_page?>' class="page">
                        이전
                </a>
        <?php
                }
                if ($last = $total_page) {
        ?>
        <a href='sub04.php?page=<?=$total_page?>' class="page">
            다음
        </a>
            
            <?php
                }
                ?>      
        <!-- page end -->
        </div>
        </div>
    </section>

    <div class="footer"></div>
</body>
</html>