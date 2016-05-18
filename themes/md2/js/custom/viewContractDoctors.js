$('#stateSelect').tap(function () {
    var deptName = $('#deptTitle').html();
    var deptId = $('#deptTitle').attr('data-dept');
    var stateName = $('#stateTitle').html();
    var stateId = $('#stateTitle').attr('data-state');
    var innerPage = '<div id="findDoc_section">' +
            '<header class="bg-green">' +
            '<h1 class="title">签约专家</h1>' +
            '</header>' +
            '<nav id="contractDoctors_nav" class="header-secondary bg-white">' +
            '<div class="grid w100 color-black font-s16 color-black6">' +
            '<div id="stateSelect" data-target="closePopup" class="col-1 w50 br-gray bb-gray grid middle grayImg">' +
            '<span id="stateTitle" data-state="' + stateId + '">' + stateName + '</span><img src="../../themes/md2/images/gray.png">' +
            '</div>' +
            '<div id="deptSelect" data-target="closePopup" class="col-1 w50 bb-gray grid middle grayImg">' +
            '<span id="deptTitle" data-dept="' + deptId + '">' + deptName + '</span><img src="../../themes/md2/images/gray.png">' +
            '</div>' +
            '</div>' +
            '</nav>' +
            '<article id="contractDoctors_article" class="active" style="position:static;">' + $stateHtml +
            '</article>' +
            '</div>';

    J.popup({
        html: innerPage,
        pos: 'top',
        showCloseBtn: false
    });

    $('.state').click(function (e) {
        e.preventDefault();
        $deptId = $('#deptTitle').attr('data-dept');
        $deptName = $('#deptTitle').html();
        $stateId = $(this).attr('data-state');
        $stateName = $(this).html();
        $condition["disease_sub_category"] = '';
        $condition["state"] = $stateId;
        $condition["page"] = 1;
        J.closePopup();
        var requestUrl = $requestDoc + '?' + setUrlCondition() + '&getcount=1';
        //console.log(requestUrl);
        //alert(requestUrl);
        J.showMask();
        $.ajax({
            url: requestUrl,
            success: function (data) {
                readyDoc(data);
                $('#stateTitle').html($stateName);
                $('#stateTitle').attr('data-state', $stateId);
                $('#deptTitle').html('科室');
                $('#deptTitle').attr('data-dept', '');
                setLocationUrl();
                $('#contractDoctors_article').scrollTop(0);
            }
        });
    });
});
$('#deptSelect').tap(function () {
    deptSelect();
});
function deptSelect() {
    var deptName = $('#deptTitle').html();
    var deptId = $('#deptTitle').attr('data-dept');
    var stateName = $('#stateTitle').html();
    var stateId = $('#stateTitle').attr('data-state');
    var innerPage = '<div id="findDoc_section">' +
            '<header class="bg-green">' +
            '<h1 class="title">签约专家</h1>' +
            '</header>' +
            '<nav id="contractDoctors_nav" class="header-secondary bg-white">' +
            '<div class="grid w100 color-black font-s16 color-black6">' +
            '<div id="stateSelect" data-target="closePopup" class="col-1 w50 br-gray bb-gray grid middle grayImg">' +
            '<span id="stateTitle" data-state="' + stateId + '">' + stateName + '</span><img src="../../themes/md2/images/gray.png">' +
            '</div>' +
            '<div id="deptSelect" data-target="closePopup" class="col-1 w50 bb-gray grid middle grayImg">' +
            '<span id="deptTitle" data-dept="' + deptId + '">' + deptName + '</span><img src="../../themes/md2/images/gray.png">' +
            '</div>' +
            '</div>' +
            '</nav>' +
            '<article id="contractDoctors_article" class="active" style="position:static;">' + $deptHtml +
            '</article>' +
            '</div>';

    J.popup({
        html: innerPage,
        pos: 'top',
        showCloseBtn: false
    });

    $('.aDept').click(function (e) {
        e.preventDefault();
        var dataDept = $(this).attr('data-dept');
        $('.aDept').each(function () {
            if (dataDept == $(this).attr('data-dept')) {
                $(this).addClass('bg-white');
            } else {
                $(this).removeClass('bg-white');
            }
        });
        $('.bDept').each(function () {
            if (dataDept == $(this).attr('data-dept')) {
                $(this).removeClass('hide');
            } else {
                $(this).addClass('hide');
            }
        });
    });

    $('.cDept').click(function (e) {
        e.preventDefault();
        $deptId = $(this).attr('data-dept');
        $deptName = $(this).html();
        $condition["disease_sub_category"] = $deptId;
        $condition["state"] = stateId;
        $condition["page"] = 1;
        J.closePopup();
        var requestUrl = $requestDoc + '?' + setUrlCondition() + '&getcount=1';
        //alert(requestUrl);
        J.showMask();
        $.ajax({
            url: requestUrl,
            success: function (data) {
                readyDoc(data);
                $deptName = $deptName.length > 4 ? $deptName.substr(0, 3) + '...' : $deptName;
                $('#deptTitle').html($deptName);
                $('#deptTitle').attr('data-dept', $deptId);
                setLocationUrl();
                $('#contractDoctors_article').scrollTop(0);
            }
        });
    });
}
//医生页面
function readyDoc(data) {
    var results = data.results;
    var innerHtml = '<div class="pt50"></div>';
    if (results) {
        if (results.length > 0) {
            for (var i = 0; i < results.length; i++) {
                var btGray = i == 0 ? '' : 'bt-gray2';
                var hp_dept_desc = (results[i].desc == '' || results[i].desc == null) ? '暂无信息' : results[i].desc;
                hp_dept_desc = hp_dept_desc.length > 40 ? hp_dept_desc.substr(0, 40) + '...' : hp_dept_desc;
                innerHtml += '<div>' +
                        '<a href="' + $requestDoctorView + '/' + results[i].id + '/addBackBtn/1" data-target="link">' +
                        '<div class="grid pl15 pr15 pt10 pb10 bb-gray3 ' + btGray + '">' +
                        '<div class="col-1 w25">' +
                        '<div class="w60p h60p" style="overflow:hidden;border-radius:5px;"><img class="imgDoc" src="' + results[i].imageUrl + '"></div>';
                if (results[i].isContracted == 1) {
                    innerHtml += '<div class="sign w60p">签约专家</div>'
                }
                var doctorAtitle = '';
                if (results[i].aTitle != '无') {
                    doctorAtitle = results[i].aTitle;
                }
                innerHtml += '</div>' +
                        '<div class="ml10 col-1 w75">' +
                        '<div class="mt10 color-black2 font-s16">' + results[i].name + '<span class="ml5">' + doctorAtitle + '</span></div>';
                //科室为空，则不显示
                if (results[i].hpDeptName == "" || results[i].hpDeptName == null) {
                    if (results[i].mTitle == "" || results[i].mTitle == null) {
                        innerHtml += '';
                    } else {
                        innerHtml += '<div class="mt5 color-black6">' + results[i].mTitle + '</div>';
                    }
                } else {
                    if (results[i].mTitle == "" || results[i].mTitle == null) {
                        innerHtml += '<div class="mt5 color-black6">' + results[i].hpDeptName + '</div>';
                    } else {
                        innerHtml += '<div class="mt5 color-black6">' + results[i].hpDeptName + '<span class="ml5">' + results[i].mTitle + '</span></div>';
                    }
                }
                if (results[i].hpName != "" && results[i].hpName != null) {
                    innerHtml += '<div class="mt5 color-black6">' + results[i].hpName + '</div>';
                }
                innerHtml += '</div>' +
                        '</div>' +
                        '</a>';
                if (results[i].reasons.length == 0) {
                    innerHtml += '<div class="pl15 pr15 pt5 pb10 font-s12 color-black bb-gray2">' +
                            '擅长:' + hp_dept_desc +
                            '</div>' +
                            '<div class="bb10-gray "></div>' +
                            '</div>';
                } else {
                    innerHtml += '<div class="pl15 bb-gray2">' +
                            '<div class="pt10 pb10 pr15 font-s12 color-black bb-gray3">' +
                            '擅长:' + hp_dept_desc +
                            '</div>' +
                            '<div class="pt10 pb10 pr15 font-s12 color-black">' +
                            '推荐理由:' + results[i].reasons[0] +
                            '</div>' +
                            '</div>' +
                            '<div class="bb10-gray "></div>' +
                            '</div>';
                }

            }
        }
    } else {
        innerHtml += '<div class="grid pl15 pr15 pt10 pb10 bb-gray2">暂无信息</div>';
    }
    if (data.dataNum != null) {
        var dataPage = Math.ceil(data.dataNum / 12);
        if (dataPage > 1) {
            innerHtml += '<div class="grid pl15 pr15 pt10 bb-gray3 bt-gray2"><div class="grid w100">' +
                    '<div class="col-1 w40">' +
                    '<button id="previousPage" type="button" class="button btn-yellow">上一页</button>' +
                    '</div><div class="col-1 w20">' +
                    '<select id="selectPage" onchange="changePage()">';
            var nowPage = $condition["page"];
            for (var i = 1; i <= dataPage; i++) {
                if (nowPage == i) {
                    innerHtml += '<option id="quickPage" value="' + i + '" selected = "selected">' + i + '</option>';
                } else {
                    innerHtml += '<option id="quickPage" value="' + i + '">' + i + '</option>';
                }
            }
            innerHtml += '</select>' +
                    '</div>' +
                    '<div class="col-1 w40">' +
                    '<button id="nextPage" type="button" class="button btn-yellow">下一页</button>' +
                    '</div>' +
                    '</div></div>';
        }
    }
    $('#docPage').html(innerHtml);
    initPage(dataPage);
    J.hideMask();
}
//分页
function initPage(dataPage) {
    $('#previousPage').tap(function () {
        if ($condition["page"] > 1) {
            $condition["page"] = parseInt($condition["page"]) - 1;
            J.showMask();
            $.ajax({
                url: $requestDoc + '?' + setUrlCondition() + '&getcount=1',
                success: function (data) {
                    readyDoc(data);
                    setLocationUrl();
                    $('#contractDoctors_article').scrollTop(0);
                }
            });
        } else {
            J.showToast('已是第一页', '', '1000');
        }
    });
    $('#nextPage').tap(function () {
        if ($condition["page"] < dataPage) {
            $condition["page"] = parseInt($condition["page"]) + 1;
            J.showMask();
            $.ajax({
                url: $requestDoc + '?' + setUrlCondition() + '&getcount=1',
                success: function (data) {
                    readyDoc(data);
                    setLocationUrl();
                    $('#contractDoctors_article').scrollTop(0);
                }
            });
        } else {
            J.showToast('已是最后一页', '', '1000');
        }
    });
}

//跳页
function changePage() {
    $condition["page"] = $('#selectPage').val();
    J.showMask();
    $.ajax({
        url: $requestDoc + '?' + setUrlCondition() + '&getcount=1',
        success: function (data) {
            readyDoc(data);
            setLocationUrl();
            $('#contractDoctors_article').scrollTop(0);
        }
    });
}
function setUrlCondition() {
    var urlCondition = "";
    for ($key in $condition) {
        if ($condition[$key] && $condition[$key] !== "") {
            urlCondition += "&" + $key + "=" + $condition[$key];
        }
    }
    return urlCondition.substring(1);
}
//更新url
function setLocationUrl() {
    var stateObject = {};
    var title = "";
    var urlCondition = '';
    for ($key in $condition) {
        if ($condition[$key] && $condition[$key] !== "") {
            urlCondition += "&" + $key + "=" + $condition[$key];
        }
    }
    urlCondition = urlCondition.substring(1);
    urlCondition = "?" + urlCondition;
    var newUrl = $requestViewContractDoctors + urlCondition;
    history.pushState(stateObject, title, newUrl);
}