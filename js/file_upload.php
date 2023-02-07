<?php
header("content-type:text/html; charset=utf-8");

if (isset($_FILES['b_uploadfile']) && $_FILES['b_uploadfile']['tmp_name'] != ''){
    $cnt = count($_FILES['b_uploadfile']['name']);
    echo "파일개수 :" . $cnt;
    if (is_uploaded_file($_FILES['b_uploadfile']['tmp_name'])){
        echo "<h2>파일정보</h2>";
        echo "<p>업로드한 파일명 : " . $_FILES['b_uploadfile']['name'] . "</p>";
        echo "<p>업로드한 확장자 (mime type) : " . $_FILES['b_uploadfile']['type'] . "</p>";
        echo "<p>업로드한 파일크기 (byte) : " . $_FILES['b_uploadfile']['size'] . "</p>";
        echo "<p>임시 디렉토리에 저장된 파일 : " . $_FILES['b_uploadfile']['tmp_name'] . "</p>";
        echo "<p>업로드 과정에서 나타난 에러코드 : " . $_FILES['b_uploadfile']['error'] . "</p>";
        move_uploaded_file($_FILES['b_uploadfile']['tmp_name'], $_FILES['b_uploadfile']['name']);
    }
}

?>