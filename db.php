<?php

$conn = mysqli_connect("localhost", "root",);
if(!$conn){
    echo 'db에 연결하지 못했습니다.'. mysqli_connect_error();
    exit();
  }

  ?>