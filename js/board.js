
$(document).on('click', '#btn_write', function () {
    // TODO : 입력값 체크 하기 구현

    // 값 전송
    if (!(confirm('등록하시겠습니까?'))) {
        return false;
    }

    var params = {};

    params.title =$("#title").val();
    params.contents = $("#contents").val();
    params.cmd = "write";
    params.tablename = "board";

    $.ajax({
        type: "POST",
        url: "js/board.php",
        dataType: 'json',
        async: false,
        data: params,
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

});


$(document).on('click', '#btn_load', function () {
    // TODO : 입력값 체크 하기 구현

    // 값 전송
    if (!(confirm('등록하시겠습니까?'))) {
        return false;
    }

    var params = {};

    params.title =$("#title").val();
    params.contents = $("#contents").val();
    params.cmd = "write";

    $.ajax({
        type: "POST",
        url: "js/notice.php",
        dataType: 'json',
        async: false,
        data: params,
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

});


$(document).on('click', '#btn_modify', function () {
    // TODO : 입력값 체크 하기 구현

    // 값 전송
    if (!(confirm('등록하시겠습니까?'))) {
        return false;
    }

    var params = {};

    params.title =$("#title").val();
    params.contents = $("#contents").val();
    params.cmd = "write";

    $.ajax({
        type: "POST",
        url: "js/notice.php",
        dataType: 'json',
        async: false,
        data: params,
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

});


