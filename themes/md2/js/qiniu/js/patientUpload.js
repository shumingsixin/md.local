/*global Qiniu */
/*global plupload */
/*global FileProgress */
/*global hljs */


$(function () {
    var num = 0;
    var domForm = $('#booking-form'),
            submitBtn = $('#submitBtn'),
            returnUrl = domForm.attr('data-url-return'),
            patientBookingId = domForm.attr('data-patientBookingId'),
            patientAjaxTask = domForm.attr('data-patientAjaxTask'),
            returnResult = true;
    var uploader = Qiniu.uploader({
        runtimes: 'html5,flash,html4',
        browse_button: 'pickfiles',
        container: 'container',
        drop_element: 'container',
        max_file_size: '1000mb',
        flash_swf_url: 'bower_components/plupload/js/Moxie.swf',
        dragdrop: true,
        chunk_size: '4mb',
        uptoken_url: $('#uptoken_url').val(),
        domain: $('#domain').val(),
        get_new_uptoken: false,
        // downtoken_url: '/downtoken',
        // unique_names: true,
        // save_key: true,
        // x_vars: {
        //     'id': '1234',
        //     'time': function(up, file) {
        //         var time = (new Date()).getTime();
        //         // do something with 'time'
        //         return time;
        //     },
        // },
        auto_start: false,
        log_level: 5,
        init: {
            'FilesAdded': function (up, files) {
                $('#pickfiles').find('span').text('继续添加');
                $('#submitBtn').removeClass('hide');
                $('table').show();
                $('#success').hide();
                plupload.each(files, function (file) {
                    var progress = new FileProgress(file, 'fsUploadProgress');
                    progress.setStatus("等待...");
                    progress.bindUploadCancel(up);
                });
            },
            'BeforeUpload': function (up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                if (up.runtime === 'html5' && chunk_size) {
                    progress.setChunkProgess(chunk_size);
                }
            },
            'UploadProgress': function (up, file) {
                var progress = new FileProgress(file, 'fsUploadProgress');
                var chunk_size = plupload.parseSize(this.getOption('chunk_size'));
                progress.setProgress(file.percent + "%", file.speed, chunk_size);
            },
            'UploadComplete': function () {
                $('#success').show();
                if (returnResult) {
                    //电邮提醒
                    if (patientBookingId != '') {
                        $.ajax({
                            type: 'get',
                            url: patientAjaxTask + '/' + patientBookingId,
                            success: function (data) {
                                //console.log(data);
                            }
                        });
                    }
                    $("#jingle_toast").find('a').text('上传成功!');
                    $("#jingle_toast").show();
                    setTimeout(function () {
                        $("#jingle_toast").hide();
                    }, 2000);
                } else {
                    $("#jingle_toast").find('a').text('上传失败!');
                    $("#jingle_toast").show();
                    setTimeout(function () {
                        $("#jingle_toast").hide();
                    }, 2000);
                }
                submitBtn.find('button').attr('disabled', false);
                setTimeout(function () {
                    location.href = returnUrl;
                }, 2000);
            },
            'FileUploaded': function (up, file, info) {
                //单个文件上传成功所做的事情 
                // 其中 info 是文件上传成功后，服务端返回的json，形式如
                // {
                //    "hash": "Fh8xVqod2MQ1mocfI4S4KpRL6D98",
                //    "key": "gogopher.jpg"
                //  }
                // 参考http://developer.qiniu.com/docs/v6/api/overview/up/response/simple-response.html
                // var domain = up.getOption('domain');
                // var res = parseJSON(info);
                // var sourceLink = domain + res.key; 获取上传成功后的文件的Url

                var progress = new FileProgress(file, 'fsUploadProgress');
                var infoJson = eval('(' + info + ')');
                progress.setComplete(up, info);
                var fileExtension = file.name.substring(file.name.lastIndexOf('.') + 1);
                var formdata = '{"patient":{"patient_id":"' + domForm.find('#patientId').val() +
                        '","report_type":"' + domForm.find('#reportType').val() +
                        '","file_size":"' + file.size +
                        '","mime_type":"' + file.type +
                        '","file_name":"' + file.name +
                        '","file_url":"' + file.name +
                        '","file_ext":"' + fileExtension +
                        '","remote_domain":"' + domForm.find('#domain').val() +
                        '","remote_file_key":"' + infoJson.key +
                        '"}}';
                var encryptContext = do_encrypt(formdata);
                var param = {param: encryptContext};
                $.ajax({
                    url: domForm.attr('data-url-uploadfile'),
                    data: param,
                    type: 'post',
                    success: function (data) {
                        //console.log('保存信息返回数据:' + data);
                        if (data.status == 'ok') {
                            //alert('上传成功');
                        } else {
                            returnResult = false;
                            //alert('上传失败!');
                        }
                    },
                    error: function (data) {
                        //console.log(data);
                        returnResult = false;
                        //alert('上传失败!');
                    }
                });
            },
            'Error': function (up, err, errTip) {
                returnResult = false;
                console.log('错误信息' + errTip);
                $('table').show();
                var progress = new FileProgress(err.file, 'fsUploadProgress');
                progress.setError();
                progress.setStatus(errTip);
            }
            ,
            'Key': function (up, file) {
                var fileExtension = file.name.substring(file.name.lastIndexOf('.') + 1);
                var key = (new Date()).getTime() + '' + Math.floor(Math.random() * 100) + '.' + fileExtension;
                // do something with key
                return key;
            }
        }
    });

    uploader.bind('FileUploaded', function () {
        //console.log('hello man,a file is uploaded');
    });
    submitBtn.click(function () {
        submitBtn.find('button').attr('disabled', true);
        uploader.start();
    });
    $('#container').on(
            'dragenter',
            function (e) {
                e.preventDefault();
                $('#container').addClass('draging');
                e.stopPropagation();
            }
    ).on('drop', function (e) {
        e.preventDefault();
        $('#container').removeClass('draging');
        e.stopPropagation();
    }).on('dragleave', function (e) {
        e.preventDefault();
        $('#container').removeClass('draging');
        e.stopPropagation();
    }).on('dragover', function (e) {
        e.preventDefault();
        $('#container').addClass('draging');
        e.stopPropagation();
    });



    $('#show_code').on('click', function () {
        $('#myModal-code').modal();
        $('pre code').each(function (i, e) {
            hljs.highlightBlock(e);
        });
    });


    $('body').on('click', 'table button.btn', function () {
        $(this).parents('tr').next().toggle();
    });


    $('#up_load').on('click', function () {
        uploader.start();
    });


    var getRotate = function (url) {
        if (!url) {
            return 0;
        }
        var arr = url.split('/');
        for (var i = 0, len = arr.length; i < len; i++) {
            if (arr[i] === 'rotate') {
                return parseInt(arr[i + 1], 10);
            }
        }
        return 0;
    };

    $('#myModal-img .modal-body-footer').find('a').on('click', function () {
        var img = $('#myModal-img').find('.modal-body img');
        var key = img.data('key');
        var oldUrl = img.attr('src');
        var originHeight = parseInt(img.data('h'), 10);
        var fopArr = [];
        var rotate = getRotate(oldUrl);
        if (!$(this).hasClass('no-disable-click')) {
            $(this).addClass('disabled').siblings().removeClass('disabled');
            if ($(this).data('imagemogr') !== 'no-rotate') {
                fopArr.push({
                    'fop': 'imageMogr2',
                    'auto-orient': true,
                    'strip': true,
                    'rotate': rotate,
                    'format': 'png'
                });
            }
        } else {
            $(this).siblings().removeClass('disabled');
            var imageMogr = $(this).data('imagemogr');
            if (imageMogr === 'left') {
                rotate = rotate - 90 < 0 ? rotate + 270 : rotate - 90;
            } else if (imageMogr === 'right') {
                rotate = rotate + 90 > 360 ? rotate - 270 : rotate + 90;
            }
            fopArr.push({
                'fop': 'imageMogr2',
                'auto-orient': true,
                'strip': true,
                'rotate': rotate,
                'format': 'png'
            });
        }

        $('#myModal-img .modal-body-footer').find('a.disabled').each(function () {

            var watermark = $(this).data('watermark');
            var imageView = $(this).data('imageview');
            var imageMogr = $(this).data('imagemogr');

            if (watermark) {
                fopArr.push({
                    fop: 'watermark',
                    mode: 1,
                    image: 'http://www.b1.qiniudn.com/images/logo-2.png',
                    dissolve: 100,
                    gravity: watermark,
                    dx: 100,
                    dy: 100
                });
            }

            if (imageView) {
                var height;
                switch (imageView) {
                    case 'large':
                        height = originHeight;
                        break;
                    case 'middle':
                        height = originHeight * 0.5;
                        break;
                    case 'small':
                        height = originHeight * 0.1;
                        break;
                    default:
                        height = originHeight;
                        break;
                }
                fopArr.push({
                    fop: 'imageView2',
                    mode: 3,
                    h: parseInt(height, 10),
                    q: 100,
                    format: 'png'
                });
            }

            if (imageMogr === 'no-rotate') {
                fopArr.push({
                    'fop': 'imageMogr2',
                    'auto-orient': true,
                    'strip': true,
                    'rotate': 0,
                    'format': 'png'
                });
            }
        });

        var newUrl = Qiniu.pipeline(fopArr, key);

        var newImg = new Image();
        img.attr('src', 'images/loading.gif');
        newImg.onload = function () {
            img.attr('src', newUrl);
            img.parent('a').attr('href', newUrl);
        };
        newImg.src = newUrl;
        return false;
    });

});
