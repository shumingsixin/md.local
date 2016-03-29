<?php
$refno=time();
$returnUrl = 'http://mingyizhudao.com/weixin/test.php?refno='.$refno; 
function isClientWeixin() {
    $ua = $_SERVER['HTTP_USER_AGENT'];
    $wxStr = 'micromessenger';
    return stripos($ua, $wxStr) > 0; // ignore case.
}
echo 'Redirect:<br>';
echo $returnUrl;
//$refno = $_GET['refno'];
// 有待优化。openid 应该从sessin获取。

if (isClientWeixin()) {
    //  $openid = $this->getSession("wx.openid");
    //if(isset($openid)){
    if (isset($_GET['openid'])) {
        $openid = $_GET['openid'];
         echo 'openid:<br>';
         echo $openid;
       //  exit;
    } else {        
        //$urlGetWxCode = 'http://mingyizhudao.com/weixin/getWxCodeTest';
        $urlGetWxCode = 'http://mingyizhudao.com/weixin/getopenid.php?returnUrl=' . urlencode($returnUrl);
        echo '<br><br>redirect to get wx code: <br>';
        echo $urlGetWxCode;
        //header('Location: ' . $urlGetWxCode);
        // echo $urlGetWxCode;exit;
    }
}
?>