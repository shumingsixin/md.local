$(document).ready(function () {
    initHeaderBack();
    initShowLoading();
    //J.hideMask();
});
function initHeaderBack() {
    if ($("#section_container").attr("data-add-back-btn") == 'true') {
        $("header .left").show();
    } else {
        $("header .left").hide();
    }
}
function initShowLoading() {
    $("a").click(function () {
        if ($(this).attr("data-target") == 'link' || $(this).attr("data-target") == 'back') {
            J.showMask('加载中...');
        }
    });
}
//disabledBtn
function disabledBtn(btnSubmit) {
    J.showMask('加载中...');
    btnSubmit.attr("disabled", true);
}
//enableBtn
function enableBtn(btnSubmit) {
    J.hideMask();
    btnSubmit.attr("disabled", false);
}