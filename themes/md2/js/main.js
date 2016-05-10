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

/*构造数据*/
function structure_data(data) {
    var structureData = '[';
    for (var i = 0; i < data.length; i++) {
        structureData += '"' + data[i] + '",';
    }
    structureData = structureData.substring(0, structureData.length - 1);
    structureData += ']';
    return structureData;
}

/*数据解析*/
function analysis_data(data) {
    var returnData = unescape(data.replace(/\\u/g, "%u"));
    returnData = $.parseJSON(returnData);
    return returnData;
}

//加密
function do_encrypt(context) {
    var pubkey = '-----BEGIN PUBLIC KEY-----' +
            'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCfRTdcPIH10gT9f31rQuIInLwe' +
            '7fl2dtEJ93gTmjE9c2H+kLVENWgECiJVQ5sonQNfwToMKdO0b3Olf4pgBKeLThra' +
            'z/L3nYJYlbqjHC3jTjUnZc0luumpXGsox62+PuSGBlfb8zJO6hix4GV/vhyQVCpG' +
            '9aYqgE7zyTRZYX9byQIDAQABdfad' +
            '-----END PUBLIC KEY-----';
    var encrypt = new JSEncrypt();
    encrypt.setPublicKey(pubkey);//获得公钥
    if (JSON.parse(context)) {
        var num = parseInt(parseInt(context.length) / 117);
        var array = new Array();
        if (num > 0) {
            for (var i = 0; i <= num; i++) {
                var snum = parseInt(i) * 117;
                var str = context.substr(snum, 117);
                var encrypted = encrypt.encrypt(str);//加密文本内容
                array[i] = encrypted;
            }
            var json = JSON.stringify(array);
            return json;
        } else {
            var encrypt = new JSEncrypt();
            encrypt.setPublicKey(pubkey);//获得公钥
            var encrypted = encrypt.encrypt(context);//加密文本内容
            array['0'] = encrypted;
            var json = JSON.stringify(array);
            return json;
        }
    }
}

//解密
function do_decrypt(context) {
    var privkey = '-----BEGIN PRIVATE KEY-----' +
            'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAJ9FN1w8gfXSBP1/' +
            'fWtC4gicvB7t+XZ20Qn3eBOaMT1zYf6QtUQ1aAQKIlVDmyidA1/BOgwp07Rvc6V/' +
            'imAEp4tOGtrP8vedgliVuqMcLeNONSdlzSW66alcayjHrb4+5IYGV9vzMk7qGLHg' +
            'ZX++HJBUKkb1piqATvPJNFlhf1vJAgMBAAECgYA736xhG0oL3EkN9yhx8zG/5RP/' +
            'WJzoQOByq7pTPCr4m/Ch30qVerJAmoKvpPumN+h1zdEBk5PHiAJkm96sG/PTndEf' +
            'kZrAJ2hwSBqptcABYk6ED70gRTQ1S53tyQXIOSjRBcugY/21qeswS3nMyq3xDEPK' +
            'XpdyKPeaTyuK86AEkQJBAM1M7p1lfzEKjNw17SDMLnca/8pBcA0EEcyvtaQpRvaL' +
            'n61eQQnnPdpvHamkRBcOvgCAkfwa1uboru0QdXii/gUCQQDGmkP+KJPX9JVCrbRt' +
            '7wKyIemyNM+J6y1ZBZ2bVCf9jacCQaSkIWnIR1S9UM+1CFE30So2CA0CfCDmQy+y' +
            '7A31AkB8cGFB7j+GTkrLP7SX6KtRboAU7E0q1oijdO24r3xf/Imw4Cy0AAIx4KAu' +
            'L29GOp1YWJYkJXCVTfyZnRxXHxSxAkEAvO0zkSv4uI8rDmtAIPQllF8+eRBT/deD' +
            'JBR7ga/k+wctwK/Bd4Fxp9xzeETP0l8/I+IOTagK+Dos8d8oGQUFoQJBAI4Nwpfo' +
            'MFaLJXGY9ok45wXrcqkJgM+SN6i8hQeujXESVHYatAIL/1DgLi+u46EFD69fw0w+' +
            'c7o0HLlMsYPAzJw=' +
            '-----END PRIVATE KEY-----';
    var obj = JSON.parse(context);
    var decrypt = new JSEncrypt();
    decrypt.setPrivateKey(privkey);//获取私钥
    var uncrypted;
    for (var i = 0; i < obj.length; i++) {
        uncrypted += decrypt.decrypt(obj[i]);//私钥解密
    }
    uncrypted = uncrypted.replace("undefined", "");
    return uncrypted;
}