$(function () {

    //图片上传板块
    var btnSubmit = $(".uploadBtn"),
            domForm = $("#patient-form"),
            $wrap = $('#uploader'),
            //全部成功 返回地址
            uploadReturnUrl = domForm.attr("data-url-return"),
            patientBookingId = domForm.attr('data-aptientBookingId'),
            patientAjaxTask = domForm.attr('data-patientAjaxTask'),
            //请求路径
            //actionUrl = '';
            //data-url-uploadFile
            urlUploadFile = domForm.attr('data-url-uploadfile'),
            //图片上传时所需要的参数
            fileParam = {},
            // 图片容器
            $queue = $('<ul class="filelist"></ul>')
            .appendTo($wrap.find('.queueList')),
            // 状态栏，包括进度和控制按钮
            $statusBar = $wrap.find('.statusBar'),
            // 文件总体选择信息。
            $info = $statusBar.find('.info'),
            // 上传按钮
            $upload = btnSubmit,
            // 没选择文件之前的内容。
            $placeHolder = $wrap.find('.placeholder'),
            // 总体进度条
            $progress = $statusBar.find('.progress').hide(),
            // 添加的文件数量
            fileCount = 0,
            // 添加的文件总大小
            fileSize = 0,
            // 优化retina, 在retina下这个值是2
            ratio = window.devicePixelRatio || 1,
            // 缩略图大小
            thumbnailWidth = 110 * ratio,
            thumbnailHeight = 110 * ratio,
            // 可能有pedding, ready, uploading, confirm, done.
            state = 'pedding',
            // 所有文件的进度信息，key为file id
            percentages = {},
            supportTransition = (function () {
                var s = document.createElement('p').style,
                        r = 'transition' in s ||
                        'WebkitTransition' in s ||
                        'MozTransition' in s ||
                        'msTransition' in s ||
                        'OTransition' in s;
                s = null;
                return r;
            })(),
            // WebUploader实例
            uploader;

    if (!WebUploader.Uploader.support()) {
        alert('Web Uploader 不支持您的浏览器！如果你使用的是IE浏览器，请尝试升级 flash 播放器');
        throw new Error('WebUploader does not support the browser you are using.');
    }

    // 实例化
    uploader = WebUploader.create({
        pick: {
            id: '#filePicker',
            innerHTML: '&nbsp;选择影像资料'
        },
        dnd: '#uploader .queueList',
        paste: document.body,
        accept: {
            title: 'Images',
            extensions: 'jpg,jpeg,png,gif',
            mimeTypes: 'image/*',
        },
        // swf文件路径
        swf: 'webuploader/Uploader.swf',
        disableGlobalDnd: true,
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        //compress: true,
        chunked: true,
        formData: {'patient[id]': domForm.find("input#patientId").val(), 'patient[report_type]': domForm.find("input#reportType").val()},
        // server: 'http://webuploader.duapp.com/server/fileupload.php',
        server: urlUploadFile,
        fileNumLimit: 10,
        fileSizeLimit: 10 * 1024 * 1024, // 200 M
        fileSingleSizeLimit: 100 * 1024 * 1024    // 50 M
    });

//    uploader.option('thumb',{
//        width: 1600,
//        height: 1600,
//
//        // 图片质量，只有type为`image/jpeg`的时候才有效。
//        quality: 90,
//
//        // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
//        allowMagnify: true,
//
//        // 是否允许裁剪。
//        crop: true,
//        // 为空的话则保留原有图片格式。
//        // 否则强制转换成指定的类型。
//        type: 'image/jpeg'
//    });
// 
//    // 修改后图片上传前，尝试将图片压缩到1600 * 1600
//    uploader.option( 'compress', {
//        width: 1600,
//        height: 1600,
//          // 图片质量，只有type为`image/jpeg`的时候才有效。
//        quality: 90,
//        // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
//        allowMagnify: false,
//
//        // 是否允许裁剪。
//        crop: false,
//
//        // 是否保留头部meta信息。
//        preserveHeaders: true,
//
//        // 如果发现压缩后文件大小比原来还大，则使用原来图片
//        // 此属性可能会影响图片自动纠正功能
//        noCompressIfLarger: false,
//
//        // 单位字节，如果图片大小小于此值，不会采用压缩。
//        compressSize: 1 * 1024 * 1024
//    });


    // 添加“添加文件”的按钮，
    uploader.addButton({
        id: '#filePicker2',
        label: '&nbsp;继续添加'
    });


    // 当有文件添加进来时执行，负责view的创建
    function addFile(file) {
        var $li = $('<li id="' + file.id + '">' +
                '<p class="title">' + file.name + '</p>' +
                '<p class="imgWrap"></p>' +
                '<p class="progress"><span></span></p>' +
                '</li>'),
                $btns = $('<div class="file-panel">' +
                        '<span class="cancel">删除</span>' +
                        '<span class="rotateRight">向右旋转</span>' +
                        '<span class="rotateLeft">向左旋转</span></div>').appendTo($li),
                $prgress = $li.find('p.progress span'),
                $wrap = $li.find('p.imgWrap'),
                $info = $('<p class="error"></p>'),
                showError = function (code) {
                    switch (code) {
                        case 'exceed_size':
                            text = '文件大小超出';
                            break;

                        case 'interrupt':
                            text = '上传暂停';
                            break;

                        default:
                            text = '上传失败，请重试';
                            break;
                    }

                    $info.text(text).appendTo($li);
                };

        if (file.getStatus() === 'invalid') {
            showError(file.statusText);
        } else {
            // @todo lazyload
            $wrap.text('预览中');
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $wrap.text('不能预览');
                    return;
                }
                var img = $('<img src="' + src + '">');
                $wrap.empty().append(img);
            }, thumbnailWidth, thumbnailHeight);

            percentages[ file.id ] = [file.size, 0];
            file.rotation = 0;
        }

        file.on('statuschange', function (cur, prev) {
            if (prev === 'progress') {
                $prgress.hide().width(0);
            } else if (prev === 'queued') {
                $li.off('mouseenter mouseleave');
                $btns.remove();
            }

            // 成功
            if (cur === 'error' || cur === 'invalid') {
                console.log(file.statusText);
                showError(file.statusText);
                percentages[ file.id ][ 1 ] = 1;
            } else if (cur === 'interrupt') {
                showError('interrupt');
            } else if (cur === 'queued') {
                percentages[ file.id ][ 1 ] = 0;
            } else if (cur === 'progress') {
                $info.remove();
                $prgress.css('display', 'block');
            } else if (cur === 'complete') {
                $li.append('<span class="success"></span>');
            }

            $li.removeClass('state-' + prev).addClass('state-' + cur);
        });

        $li.on('mouseenter', function () {
            $btns.stop().animate({height: 30});
        });

        $li.on('mouseleave', function () {
            $btns.stop().animate({height: 0});
        });

        $btns.on('click', 'span', function () {
            var index = $(this).index(),
                    deg;

            switch (index) {
                case 0:
                    uploader.removeFile(file);
                    return;

                case 1:
                    file.rotation += 90;
                    break;

                case 2:
                    file.rotation -= 90;
                    break;
            }

            if (supportTransition) {
                deg = 'rotate(' + file.rotation + 'deg)';
                $wrap.css({
                    '-webkit-transform': deg,
                    '-mos-transform': deg,
                    '-o-transform': deg,
                    'transform': deg
                });
            } else {
                $wrap.css('filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation=' + (~~((file.rotation / 90) % 4 + 4) % 4) + ')');
            }
        });

        $li.appendTo($queue);
    }

    // 负责view的销毁
    function removeFile(file) {
        var $li = $('#' + file.id);

        delete percentages[ file.id ];
        updateTotalProgress();
        $li.off().find('.file-panel').off().end().remove();
    }

    function updateTotalProgress() {
        var loaded = 0,
                total = 0,
                spans = $progress.children(),
                percent;

        $.each(percentages, function (k, v) {
            total += v[ 0 ];
            loaded += v[ 0 ] * v[ 1 ];
        });

        percent = total ? loaded / total : 0;

        spans.eq(0).text(Math.round(percent * 100) + '%');
        spans.eq(1).css('width', Math.round(percent * 100) + '%');
        updateStatus();
    }

    function updateStatus() {
        var text = '', stats;

        if (state === 'ready') {
            text = '选中' + fileCount + '张图片，共' +
                    WebUploader.formatSize(fileSize) + '。';
        } else if (state === 'confirm') {
            stats = uploader.getStats();
            if (stats.uploadFailNum) {
                text = '已成功上传' + stats.successNum + '张图片，' +
                        stats.uploadFailNum + '张图片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'
            }

        } else {
            stats = uploader.getStats();
            text = '共' + fileCount + '张（' +
                    WebUploader.formatSize(fileSize) +
                    '），已上传' + stats.successNum + '张';

            if (stats.uploadFailNum) {
                text += '，失败' + stats.uploadFailNum + '张';
            }
        }

        $info.html(text);
    }

    function setState(val) {
        var file, stats;

        if (val === state) {
            return;
        }

        $upload.removeClass('state-' + state);
        $upload.addClass('state-' + val);
        state = val;

        switch (state) {
            case 'pedding':
                $placeHolder.removeClass('element-invisible');
                $queue.parent().removeClass('filled');
                $queue.hide();
                $statusBar.addClass('element-invisible');
                uploader.refresh();
                break;

            case 'ready':
                $placeHolder.addClass('element-invisible');
                $('#filePicker2').removeClass('element-invisible');
                $queue.parent().addClass('filled');
                $queue.show();
                $statusBar.removeClass('element-invisible');
                uploader.refresh();
                break;

//            case 'uploading':
//                $( '#filePicker2' ).addClass( 'element-invisible' );
//                $progress.show();
//                $upload.text( '暂停上传' );
//                break;
//
//            case 'paused':
//                $progress.show();
//                $upload.text( '继续上传' );
//                break;

            case 'confirm':
                $progress.hide();
                $upload.addClass('disabled');
                $('#filePicker2').addClass('element-invisible');
                stats = uploader.getStats();
                if (stats.successNum && !stats.uploadFailNum) {
                    setState('finish');
                    return;
                }
                break;
            case 'finish':
                stats = uploader.getStats();
                if (stats.successNum) {
                    //console.log(stats);
                    enableBtn(btnSubmit);
                    //电邮提醒
                    if (patientBookingId != '') {
                        $.ajax({
                            type: 'get',
                            url: patientAjaxTask,
                            success: function (data) {
                                //console.log(data);
                            }
                        });
                    }
                    location.href = uploadReturnUrl;
                    //location.hash = uploadReturnUrl;
                } else {
                    // 没有成功的图片，重设
                    //state = 'done';
                    location.reload();
                }
                break;
        }
        updateStatus();
    }

    uploader.onUploadProgress = function (file, percentage) {
        var $li = $('#' + file.id),
                $percent = $li.find('.progress span');

        $percent.css('width', percentage * 100 + '%');
        percentages[ file.id ][ 1 ] = percentage;
        updateTotalProgress();
    };

    uploader.onFileQueued = function (file) {
        fileCount++;
        fileSize += file.size;

        if (fileCount === 1) {
            $placeHolder.addClass('element-invisible');
            $statusBar.show();
        }
        addFile(file);
        setState('ready');
        updateTotalProgress();
    };

    uploader.onFileDequeued = function (file) {
        fileCount--;
        fileSize -= file.size;
        if (!fileCount) {
            setState('pedding');
        }
        removeFile(file);
        updateTotalProgress();

    };

    uploader.on('all', function (type) {
        var stats;
        switch (type) {
            case 'uploadFinished':
                setState('confirm');
                break;

            case 'startUpload':
                setState('uploading');
                break;

//            case 'stopUpload':
//                setState( 'paused' );
//                break;

        }
    });
    //图片上传前的错误验证
    uploader.onError = function (code) {
        var errorinfo;
        switch (code) {
            case 'F_DUPLICATE':
                errorinfo = "文件名重复!";
                break;
            case 'F_EXCEED_SIZE':
                errorinfo = "图片过大!";
                break;
            case 'Q_EXCEED_SIZE_LIMIT':
                errorinfo = "图片队列总大小过大!";
                break;
            case 'Q_EXCEED_NUM_LIMIT':
                errorinfo = "文件数量过多!";
                break;
            case 'Q_TYPE_DENIED':
                errorinfo = "请选择jpg/jpeg/png或gif格式的图片!";
                break;
        }
        J.showToast(errorinfo, '', 3000);
//        $("#errorConfirm .confirmcontent .errorinfo").html(errorinfo);
//        $("#errorConfirm").show();
//        $("#tipPage .tipcontent p").html(errorinfo);
//        $("#toTip").trigger("click");
        //console.log(errorinfo);
        //alert('错误信息: ' + errorinfo);
    };

    //当所有文件上传结束时触发
    uploader.on("uploadFinished", function (file, data) {

    });
    //单个文件上传成功触发的事件
    uploader.on("uploadSuccess", function (file, data) {
        //console.log(data);
    });
//单个文件上传失败触发的事件
    uploader.on("uploadError", function (file, data) {
        console.log(data);
    });
//单个文件上传服务器时的事件
    uploader.on("uploadAccept", function (file, data) {
        //判断该文件上传由后台返回的状态 返回false则会表示文件上传失败 
        if (data.status == 'no') {
            return false;
        }
    });
//提交按钮点击时间
    $upload.on('click', function () {
        disabledBtn(btnSubmit);
        if ($(this).hasClass('disabled') || $(this).hasClass("ui-state-disabled")) {
            return false;
        }
        if (state === 'ready') {
            uploader.upload();
        }
    });

    $info.on('click', '.retry', function () {
        uploader.retry();
    });

    $info.on('click', '.ignore', function () {
        //忽略的操作 错误图片不再上传 直接页面跳转
        enableBtn(btnSubmit);
        location.href = uploadReturnUrl;
    });

    $upload.addClass('state-' + state);
    updateTotalProgress();


    //jQuery(".webuploader-pick").addClass("ui-btn ui-icon-plus ui-btn-icon-left ui-btn-inline nobg");
});