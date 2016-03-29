document.addEventListener('deviceready', onDeviceReady, false);
function onDeviceReady() {
    navigator.splashscreen.hide();
    //注册后退按钮
    document.addEventListener("backbutton", function (e) {
        if (J.hasMenuOpen) {
            J.Menu.hide();
        } else if (J.hasPopupOpen) {
            J.closePopup();
        } else {
            var sectionId = $('section.active').attr('id');
            if (sectionId == 'index_section') {
                J.confirm('提示', '是否退出程序？', function () {
                    navigator.app.exitApp();
                });
            } else {
                window.history.go(-1);
            }
        }
    }, false);
}
var App = (function () {
    var pages = {};
    var run = function () {
        $.each(pages, function (k, v) {
            var sectionId = '#' + k + '_section';
            $('body').delegate(sectionId, 'pageinit', function () {
                v.init && v.init.call(v);
            });
            $('body').delegate(sectionId, 'pageshow', function (e, isBack) {
                //页面加载的时候都会执行
                v.show && v.show.call(v);
                //后退时不执行
                if (!isBack && v.load) {
                    v.load.call(v);
                }
            });
        });
        J.Transition.add('flip', 'slideLeftOut', 'flipOut', 'slideRightOut', 'flipIn');
        Jingle.launch({
        });
    };
    var page = function (id, factory) {
        return ((id && factory) ? _addPage : _getPage).call(this, id, factory);
    }
    var _addPage = function (id, factory) {
        pages[id] = new factory();
    };
    var _getPage = function (id) {
        return pages[id];
    }
    //动态计算chart canvas的高度，宽度，以适配终端界面
    var calcChartOffset = function () {
        return {
            height: $(document).height() - 44 - 30 - 60,
            width: $(document).width()
        }

    }
    return {
        run: run,
        page: page,
        calcChartOffset: calcChartOffset
    }
}());

$(function () {
    App.run();
})

