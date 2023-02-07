// AJAX JS

function load_board(pParams, pTarget){

    var dataHTML = "";

    // var tailHTML = `</div>
    //             <div class="pager">
    //             </div>
    //             <div class="btn">
    //                 <a href="/writer0.html">글쓰기</a>
    //             <div>  
    //         </div>
    //         </section>`;

    // var headHTML = ` <section>
    //             <div class="section01">
    //                 <h1>boardTitile</h1>
    //             </div>
    //             <div class="section02">
    //                 <div class="notice">
    //                     <div class="title1">번호</div>
    //                     <div class="title2">제목</div>
    //                     <div class="title4">작성자</div>
    //                     <div class="title5">등록일</div>
    //                 </div>
    //             </div><div class="section03">
    //             <div class='table'>`;
    // headHTML = headHTML.replace('boardTitile', pParams.title);

    if (pParams)
    $.ajax({
        type: "POST",
        url: "../js/server_api.php",
        dataType: 'json',
        async: false,
        data: pParams,
        success: function (result) {
            if (result != null) {
                try {
                    JsonData = JSON.parse(JSON.stringify(result));
                    $.each(JsonData, function (key, Items) {
                        if (key == "tabledata") {
                            tblJSON = JSON.parse(JSON.stringify(JsonData.tabledata));
                            $.each(tblJSON, function (skey, sItems) {
                                if(pParams.title=="자료실"){
                                    dataHTML = "<tr>";
                                    dataHTML = "<td class='col1'><input type='checkbox'></td>";
                                    dataHTML = dataHTML + "<td class='col2'>" + sItems.b_idx + "</td>";
                                    dataHTML = dataHTML + "<td class='col3' id='title'>" + sItems.b_title + "</td>";
                                    dataHTML = dataHTML + "<td class='col4'>" + sItems.b_date + "</td>";
                                    dataHTML = dataHTML + "<td class='col5'><div class='adminBtn'>관리</div><div class='deleteBtn'>삭제</div></td>";
                                    dataHTML = dataHTML + "</tr>";
                                }
                            });
                        }
                    });
                    $(pTarget).html(dataHTML);
                } catch (e) {
                    console.log("loaddata(parser) : " + e.message);
                }

            } else {
                alert('요청 처리 실패 : result null');
                return;
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("요청 처리 실패(ajax): " + xhr.status + "\n" + thrownError);
        }
    });
}

function load_board_notice(pParams, pTarget){

    var dataHTML = "";

    // var tailHTML = `</div>
    //             <div class="pager">
    //             </div>
    //             <div class="btn">
    //                 <a href="/writer0.html">글쓰기</a>
    //             <div>  
    //         </div>
    //         </section>`;

    // var headHTML = ` <section>
    //             <div class="section01">
    //                 <h1>boardTitile</h1>
    //             </div>
    //             <div class="section02">
    //                 <div class="notice">
    //                     <div class="title1">번호</div>
    //                     <div class="title2">제목</div>
    //                     <div class="title4">작성자</div>
    //                     <div class="title5">등록일</div>
    //                 </div>
    //             </div><div class="section03">
    //             <div class='table'>`;
    // headHTML = headHTML.replace('boardTitile', pParams.title);

    if (pParams)
    $.ajax({
        type: "POST",
        url: "../js/server_api.php",
        dataType: 'json',
        async: false,
        data: pParams,
        success: function (result) {
            if (result != null) {
                try {
                    JsonData = JSON.parse(JSON.stringify(result));
                    $.each(JsonData, function (key, Items) {
                        if (key == "tabledata") {
                            tblJSON = JSON.parse(JSON.stringify(JsonData.tabledata));
                            $.each(tblJSON, function (skey, sItems) {
                                if(pParams.title=="공지사항"){
                                    dataHTML = "<tr>";
                                    dataHTML = "<td class='col1'><input type='checkbox'></td>";
                                    dataHTML = dataHTML + "<td class='col2'>" + sItems.b_idx + "</td>";
                                    dataHTML = dataHTML + "<td class='col3' id='title'>" + sItems.b_title + "</td>";
                                    dataHTML = dataHTML + "<td class='col4'>" + sItems.b_date + "</td>";
                                    dataHTML = dataHTML + "<td class='col5'><div class='adminBtn'>관리</div><div class='deleteBtn'>삭제</div></td>";
                                    dataHTML = dataHTML + "</tr>";
                                }
                            });
                        }
                    });
                    $(pTarget).html(dataHTML);
                } catch (e) {
                    console.log("loaddata(parser) : " + e.message);
                }

            } else {
                alert('요청 처리 실패 : result null');
                return;
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("요청 처리 실패(ajax): " + xhr.status + "\n" + thrownError);
        }
    });
}

function load_board_contact(pParams, pTarget){

    var dataHTML = "";

    // var tailHTML = `</div>
    //             <div class="pager">
    //             </div>
    //             <div class="btn">
    //                 <a href="/writer0.html">글쓰기</a>
    //             <div>  
    //         </div>
    //         </section>`;


    
    // var headHTML = ` <section>
    //             <div class="section01">
    //                 <h1>boardTitile</h1>
    //             </div>
    //             <div class="section02">
    //                 <div class="notice">
    //                     <div class="title1">번호</div>
    //                     <div class="title2">제목</div>
    //                     <div class="title4">작성자</div>
    //                     <div class="title5">등록일</div>
    //                 </div>
    //             </div><div class="section03">
    //             <div class='table'>`;
    // headHTML = headHTML.replace('boardTitile', pParams.title);

    if (pParams)
    $.ajax({
        type: "POST",
        url: "../js/server_api.php",
        dataType: 'json',
        async: false,
        data: pParams,
        success: function (result) {
            if (result != null) {
                try {
                    JsonData = JSON.parse(JSON.stringify(result));
                    $.each(JsonData, function (key, Items) {
                        if (key == "tabledata") {
                            tblJSON = JSON.parse(JSON.stringify(JsonData.tabledata));
                            $.each(tblJSON, function (skey, sItems) {
                                if(pParams.title=="CONTACT"){
                                    dataHTML = "<tr>";
                                    dataHTML = "<td class='col1'><input type='checkbox'></td>";
                                    dataHTML = dataHTML + "<td class='col2'>" + sItems.b_idx + "</td>";
                                    dataHTML = dataHTML + "<td class='col3' id='title'>" + sItems.b_name + "</td>";
                                    dataHTML = dataHTML + "<td class='col4'>" + sItems.b_date + "</td>";
                                    dataHTML = dataHTML + "<td class='col5'><div class='adminBtn'>관리</div><div class='deleteBtn' id='btn_contact_delete'>삭제</div></td>";
                                    dataHTML = dataHTML + "</tr>";
                                }
                            });
                        }
                    });
                    $(pTarget).html(dataHTML);
                } catch (e) {
                    console.log("loaddata(parser) : " + e.message);
                }

            } else {
                alert('요청 처리 실패 : result null');
                return;
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("요청 처리 실패(ajax): " + xhr.status + "\n" + thrownError);
        }
    });
}

// contact 정보를 서버로 전송
function send_contact(pParams){
    $.ajax({
        type: "POST",
        url: "js/server_api.php",
        dataType: 'json',
        async: false,
        data: pParams,
        success: function (result) {
            if (result != null) {
                try {
                    var JsonData = JSON.parse(JSON.stringify(result));
                    var desc = JsonData.desc;
                    if (JsonData.value == 'ok') {
                        alert("등록했습니다.");
                        //opener.location.href = window.opener.document.location.origin + window.opener.document.location.pathname + "?" + param;
                        return;
                    } else {
                        alert("등록 실패\n" + desc);
                    }
                } catch (e) {
                    alert(e.message);
                    return;
                }
            } else {
                alert('등록 실패 : result null');
                return;
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("등록 실패(ajax): " + xhr.status + "\n" + thrownError);
        }
    });
}

function send_pds(pParams){

    $.ajax({
        type: "POST",
        url: "js/server_api.php",
        dataType: 'json',
        async: false,
        data: pParams,
        enctype: "multipart/form-data", //form data 설정,
        processData: false, //프로세스 데이터 설정 : false 값을 해야 form data로 인식합니다
        contentType: false, //헤더의 Content-Type을 설정 : false 값을 해야 form data로 인식합니다
        success: function (result) {
            if (result != null) {
                try {
                    var JsonData = JSON.parse(JSON.stringify(result));
                    var desc = JsonData.desc;
                    if (JsonData.value == 'ok') {
                        alert("등록했습니다.");
                        //opener.location.href = window.opener.document.location.origin + window.opener.document.location.pathname + "?" + param;
                        return;
                    } else {
                        alert("등록 실패\n" + desc);
                    }
                } catch (e) {
                    alert(e.message);
                    return;
                }
            } else {
                alert('등록 실패 : result null');
                return;
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert("등록 실패(ajax): " + xhr.status + "\n" + thrownError);
        }
    });
}
