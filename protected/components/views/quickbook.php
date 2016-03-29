<?php
/**
 * $faculty_id
 * $booking_target
 */
$query = array();
if (isset($type)) {
    $query['type'] = $type;
}
if (isset($fid)) {
    $query['fid'] = $fid;
}
if (isset($did)) {
    $query['did'] = $did;
}
if (isset($tid)) {
    $query['tid'] = $tid;
}
if (isset($hid)) {
    $query['hid'] = $hid;
}
if (isset($dept)) {
    $query['dept'] = $dept;
}
?>
<iframe id="quickbook-frame" width="302px" height="630px" name="quickbook-form" class="block" frameborder="0" scrolling="no" seamless src="<?php echo Yii::app()->createUrl('booking/quickbook', $query); ?>"></iframe>