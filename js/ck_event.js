// 클릭 및 효과 이벤트 JS

$(document).ready(function(){
    // header load
    $(".common-header").load("common/header.html");
    // footer load
    $(".footer").load("common/footer.html");
})

function fileUpload(){
    var fileInput = $("#f_uploadfile[]");

    for( var i=0; i<fileInput.length; i++ ){
        if( fileInput[i].files.length > 0 ){
            for( var j = 0; j < fileInput[i].files.length; j++ ){
                $("#filelist").append(fileInput[i].files[j].name);
            }
        }
    }    
}

// contact us 버튼 클릭
$(document).on("click", '#btn_contact_insert', function(){
    // 입력값 체크
    var b_writer = TrimData("#txt_writer");
    var b_email = TrimData("#txt_email");
    var b_contents = TrimData("#txt_contents");

    if (isEmptyToFocus(b_writer, "이름을 입력하세요.", "#txt_writer")){ return }
    if (isEmptyToFocus(b_email, "이메일을 입력하세요.", "#txt_email")){ return }
    if (isEmptyToFocus(b_contents, "메시지를 입력하세요.", "#txt_email")){ return }

    if (!ValidateEmail(b_email)){
        alert("올바른 이메일 형식이 아닙니다.");
        $("#txt_email").val("");
        $("#txt_email").focus();
        return;
    }

    // 서버 전송 파라미터 설정
    params = {};

    params.b_writer = b_writer;
    params.b_title = b_email;
    params.b_contents = b_contents;
    params.board_type = "contact";
    params.cmd = "write";

    // 서버 전송
    send_contact(params);

    $('#txt_writer').val("");
    $('#txt_email').val("");
    $('#txt_contents').val("");
})    

// 문의 사항 삭제
$(document).on("click", '#btn_contact_delete', function(){
    // 서버 전송 파라미터 설정
    params = {};

    params.cmd = "btn_contact_delete";

    // 서버 전송
    send_contact(params);
})    


// 등록
$(document).on('click', '#btn_write', function () {
    // TODO : 입력값 체크 하기 구현
    var uploadFile =  $('#b_upload')[0].files[0];
    var b_title = $("#b_title").val();
    var b_contents = cEditor.instances.editor.getData();   

    if (CheckBlankText(b_title, "제목을 입력하세요.", $("b_title"))){
        return;
    }
    if (CheckBlankText(b_contents, "내용을 입력하세요.", $("b_contents"))){
        return;
    }
    if (CheckBlankText(uploadFile.name, "파일은 선택해주세요", $("b_title"))){
        return;
    }

    // 값 전송
    if (!(confirm('등록하시겠습니까?'))) {
        return false;
    }

    var formData = new FormData();
    formData.append("b_title", b_title);
    formData.append("b_contents", b_contents);
    formData.append("b_upload", $('#b_upload')[0].files[0]);
    formData.append("cmd", "pds_write");

    send_pds(formData);

});
// 수정
$(document).on('click', '#btn_modify', function () {
    // TODO : 입력값 체크 하기 구현
    var uploadFile =  $('#b_upload')[0].files[0];
    var b_title = $("#b_title").val();
    var b_contents = $("#b_contents").val();


    if (CheckBlankText(uploadFile.name, "파일은 선택해주세요", $("b_title"))){
        return;
    }

    // 값 전송
    if (!(confirm('등록하시겠습니까?'))) {
        return false;
    }

    var formData = new FormData();
    formData.append("b_title", b_title);
    formData.append("b_contents", b_contents);
    formData.append("b_upload", $('#b_upload')[0].files[0]);
    formData.append("cmd", "pds_write");

    modify_pds(formData);
});

// 검색 버튼
// s_type : pds, notice, news
$(document).on('click', '#btn_search', function () {
});

$(document).on('click', '#btn_list_pds', function () {
    alert("자료실 리스트");

    var params = {};
/*    
    params.tidx = tIdx;
    params.no = tDataNo;
    params.npage = tNowPage;
    params.count = LoadMax_Data_10;
    params.scase = tSearchCase;
    params.sdata = tSearchData;
*/    
    params.cmd = "pds_load";
    params.title = "자료실";
    load_board(params, '#board_list')
});

$(document).on('click', '#btn_list_news', function () {
    params.cmd = "news_load";
    params.title = "뉴스";
    load_board(params, '#board_list')
});

$(document).on('click', '#btn_list_news', function () {
    alert("뉴스 리스트");
});

$(document).on('click', '#btn_list_notice', function () {
    alert("공지사항 리스트");

    var params = {};
    /*    
        params.tidx = tIdx;
        params.no = tDataNo;
        params.npage = tNowPage;
        params.count = LoadMax_Data_10;
        params.scase = tSearchCase;
        params.sdata = tSearchData;
    */    
    g_board_type = "notice"
    params.board_type = g_board_type;
    params.cmd = "load";
    params.title = "공지사항";
    load_board_notice(params, '#board_list_notice');
});

$(document).on('click', '#btn_list_contact', function () {
    alert("ContactUS 리스트");
    var params = {};
    /*    
        params.tidx = tIdx;
        params.no = tDataNo;
        params.npage = tNowPage;
        params.count = LoadMax_Data_10;
        params.scase = tSearchCase;
        params.sdata = tSearchData;
    */    
        params.cmd = "contact_list";
        params.title = "공지사항";
        load_board_contact(params, '#board_list_contact')
});


/*
            <section>
                <div class="section01">
                    <h1>자료실</h1>
                </div>
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
                    <div class='table'>
                        <div class='col1'>aaaa</div>
                        <div class='col2'><a href=''>test</a></div>
                        <div class='col3'><a  href='test'><img src='../img/sub04/file-regular1.png' alt='파일로고'></a></div>
                        <div class='col4'>aaa</div>
                        <div class='col5'>bbb</div>
                    </div>
                    <div class="pager">
                    </div>
                    <div class="btn">
                        <a href="/writer0.html">글쓰기</a>
                    <div>  
                </div>
            </section>
*/        


        
$("#signUp").click(function(){
            let usingId = $("#usingId").val();
            let usingPw = $("#usingPw").val();
            let checkPw = $("#checkPw").val();
            let usingName = $("#usingName").val();
            let usingNick = $("#usingNick").val();
            let usingEmail = $("#usingEmail").val();
            // let agreed = $("#agreed").is(":checked");/

            if(usingId === ""){
                alert("아이디를 입력하세요.")
                return
            }else if(usingPw === ""){
                alert("비밀번호를 입력하세요")
                return
            }else if(checkPw === ""){
                alert("비밀번호확인을 입력하세요")
                return
            }else if(usingName === ""){
                alert("이름을 입력하세요")
                return
            }else if(usingNick === ""){
                alert("닉네임을 입력하세요")
                return
            }else if(usingEmail === ""){
                alert("이메일을 입력하세요")
                return
            }else if($("#agreed").is(":checked") == false){
                alert("개인정보이용 동의에 체크하세요")
                return
            }

            alert("회원가입 완료")
        });

