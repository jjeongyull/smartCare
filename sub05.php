<?php include $_SERVER["DOCUMENT_ROOT"]."page.php" ?>
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
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/page.css">
    <link rel="stylesheet" href="css/search.css">
    <!-- favicon 오류 처리 -->
    <link rel="shortcut icon" href="#">

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
            <h2>자료실</h2>
        </div>
    </div>

    <section>
        <div class="section01">
            <h1>자료실</h1>
        </div>
        <form id="search_form">
            <input type="text" maxlength="20" id="s_keywords" placeholder="제목을 입력하세요">&nbsp;
            <input type="hidden" id="s_type" value="pds">
            <input type="button" id="btn_search" value="검색">
        </form>
        <div class="section02">
            <div class="notice">
                <div class="title1">번호</div>
                <div class="title2">제목</div>
                <div class="title3">첨부파일</div>
                <div class="title4">작성자</div>
                <div class="title5">등록일</div>
            </div>
        </div>
        <div class="section03">
        <?php
            include $_SERVER['DOCUMENT_ROOT'].'db.php';
            $sql="select * from pds order by b_idx desc limit $offset, $list_num";
            $result=mysqli_query($conn, $sql);
            while($row=mysqli_fetch_array($result)){
                $b_idx=$row['b_idx'];
                $b_title=$row['b_title'];
                $b_writer=$row['b_writer'];
                $b_date=$row['b_date'];
                $b_file=$row['b_file'];
          ?>
                    
                 
                    <div class='table'>
                    <div class='col1'><?= $row['b_idx'] ?></div>
                    <div class='col2'><a href='view2.php?b_idx=<?= $row['b_idx'] ?>'><?= $row['b_title'] ?></a></div>
                    <div class='col3'><a  href='file/<?= $row['b_file'] ?>' download><img src='./img/sub04/file-regular1.png' alt='파일로고'></a></div>
                    <div class='col4'><?= $row['b_writer'] ?></div>
                    <div class='col5'><?= $row['b_date'] ?></div>
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
            <a href='sub05.php?page=1' id='prev' class="page">
                이전
            </a>
            <?php
                }
            if($page > 1) {
            $go_page=$page-1;
            ?>
                <a href='sub05.php?page=<?=$go_page?>' class="page">
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
            <a href='sub05.php?page=<?=$page_link?>' class="page">
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
                <a href='sub05.php?page=<?=$next_page?>' class="page">
                        이전
                </a>
        <?php
                }
                if ($last = $total_page) {
        ?>
        <a href='sub05.php?page=<?=$total_page?>' class="page">
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