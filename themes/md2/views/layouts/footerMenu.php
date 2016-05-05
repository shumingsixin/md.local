<div id="browermode-menu" xdata-position="fixed" xdata-role="footer" class="row" xstyle="margin-top: -93px;">
    <div class="footerMenu">
        <a href="<?php echo Yii::app()->params['baseUrl']; ?>" class="pc mode-pc edition">浏览电脑版</a>
        <!--<a href="#" class="mobile mode-mobile edition">手机版</a>-->
        <span class="pull-right tel"><span class="phone-img"></span>400-6277-120</span>
    </div>
</div>
<script>
    $(document).ready(function () {
        var userAgent = getUrlVars()['agent'];
        if (userAgent && (userAgent == 'app' || userAgent == 'wechat' || userAgent == 'weixin' || userAgent == 'wx')) {
            $("#browermode-menu").hide();   // hide the browser mode switch if it's opened in app or weixin.
        }
        /*
         $("#browermode-menu a.mode-pc").click(function (e) {
         e.preventDefault();            
         setCookie("client.browsermode", "pc", 30);            
         //window.location = "http://mingyizhudao.com";
         });
         */
    });

    function getCookie(c_name) {
        if (document.cookie.length > 0) {
            c_start = document.cookie.indexOf(c_name + "=");
            if (c_start != -1) {
                c_start = c_start + c_name.length + 1;
                c_end = document.cookie.indexOf(";", c_start);
                if (c_end == -1)
                    c_end = document.cookie.length;
                return unescape(document.cookie.substring(c_start, c_end));
            }
        }
        return "";
    }

    function setCookie(c_name, value, expiredays) {
        var exdate = new Date();
        exdate.setDate(exdate.getDate() + expiredays);
        document.cookie = c_name + "=" + escape(value) +
                ((expiredays == null) ? "" : "; expires=" + exdate.toGMTString()) + "; path=/";
    }

// Read a page's GET URL variables and return them as an associative array.
    function getUrlVars()
    {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }
</script>