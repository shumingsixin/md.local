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

/*构造formdata*/
function structure_formdata(formName, data) {
    //array('user'=>array('name'=>'15212789819','paw'=>'123456'))
    var dataArray = '{"' + formName + '":{';
    for (var i = 0; i < data.length; i++) {
        var name = data[i].name.substring((data[i].name.indexOf('[') + 1), data[i].name.indexOf(']'));
        dataArray += '"' + name + '":"' + encodeURIComponent(data[i].value) + '",';
    }
    dataArray = dataArray.substring(0, dataArray.length - 1);
    dataArray += '}}';
    return dataArray;
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
        context = base64_encode(context);
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

//
function base64_encode(str) {
    var c1, c2, c3;
    var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
    var i = 0, len = str.length, string = '';

    while (i < len) {
        c1 = str.charCodeAt(i++) & 0xff;
        if (i == len) {
            string += base64EncodeChars.charAt(c1 >> 2);
            string += base64EncodeChars.charAt((c1 & 0x3) << 4);
            string += "==";
            break;
        }
        c2 = str.charCodeAt(i++);
        if (i == len) {
            string += base64EncodeChars.charAt(c1 >> 2);
            string += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
            string += base64EncodeChars.charAt((c2 & 0xF) << 2);
            string += "=";
            break;
        }
        c3 = str.charCodeAt(i++);
        string += base64EncodeChars.charAt(c1 >> 2);
        string += base64EncodeChars.charAt(((c1 & 0x3) << 4) | ((c2 & 0xF0) >> 4));
        string += base64EncodeChars.charAt(((c2 & 0xF) << 2) | ((c3 & 0xC0) >> 6));
        string += base64EncodeChars.charAt(c3 & 0x3F);
    }
    return string;
}
function base64_decode(str) {
    var c1, c2, c3, c4;
    var base64DecodeChars = new Array(
            -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
            -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63, 52, 53, 54, 55, 56, 57,
            58, 59, 60, 61, -1, -1, -1, -1, -1, -1, -1, 0, 1, 2, 3, 4, 5, 6,
            7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24,
            25, -1, -1, -1, -1, -1, -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36,
            37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1,
            -1, -1
            );
    var i = 0, len = str.length, string = '';

    while (i < len) {
        do {
            c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff]
        } while (
                i < len && c1 == -1
                );

        if (c1 == -1)
            break;

        do {
            c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff]
        } while (
                i < len && c2 == -1
                );

        if (c2 == -1)
            break;

        string += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));

        do {
            c3 = str.charCodeAt(i++) & 0xff;
            if (c3 == 61)
                return string;

            c3 = base64DecodeChars[c3]
        } while (
                i < len && c3 == -1
                );

        if (c3 == -1)
            break;

        string += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));

        do {
            c4 = str.charCodeAt(i++) & 0xff;
            if (c4 == 61)
                return string;
            c4 = base64DecodeChars[c4]
        } while (
                i < len && c4 == -1
                );

        if (c4 == -1)
            break;

        string += String.fromCharCode(((c3 & 0x03) << 6) | c4)
    }
    return string;
}