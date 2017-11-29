<?php

define('IMG_DIR', dirname(__FILE__));

$pic = addslashes($_POST['pic']);

$pic = str_replace('data:image/jpeg;base64', '', $pic);
$pic = str_replace(' ', '+', $pic);
$data = base64_decode($pic);  // 解码

// 如果目录不存在，则创建目录
$dir = './pic';
if (!file_exists(IMG_DIR . $dir)) {
    mkdir(IMG_DIR . $dir, 0755, true);
}
$fileName = md5(uniqid(microtime(true), true));   // 获得唯一文件名
$file = IMG_DIR . $dir . '/' . $fileName . '.jpeg';
$bOk = file_put_contents($file, $data);     // 将数据保存在目标路径的文件里
if ($bOk) {	
    $pic = $dir . '/' . $fileName . '.jpeg';

} else {
    $pic = '';
}
$ret = array('pic' => $pic);
echo json_encode($ret);