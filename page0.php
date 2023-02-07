<?php
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $list_num = 5;
    $page_num = 5; 
    $offset = $list_num*($page-1); 

    //전체 글 수
    include $_SERVER['DOCUMENT_ROOT'].'db.php';
    $query = "SELECT * FROM notice";
    $data = mysqli_query($conn, $query);
    $total_no = mysqli_num_rows($data);
   
    //전체 페이지 수와 현재 글 번호를 구합니다.
    $total_page=ceil($total_no/$list_num); 
    // 전체글수를 페이지당글수로 나눈 값의 올림 값을 구합니다. 
    $cur_num=$total_no - $list_num*($page-1); 

    // 여기부터 페이지
    //먼저, 한 화면에 보이는 블록($page_num 기본값 이상일 때 블록으로 나뉘어짐 )
    $total_block=ceil($total_page/$page_num);
    // 1블록 = 5개의 페이지 / 10개의 페이징 넘버
    $block=ceil($page/$page_num); //현재 블록
    // 1블록 =  2페이지 / 10개의 페이징 넘버

    $first=($block-1)*$page_num; 
    // 페이지 블록이 시작하는 첫 페이지

    $last=$block*$page_num; 
    //페이지 블록의 끝 페이지
    
    if($block >= $total_block) {
            $last=$total_page;
    }
?>