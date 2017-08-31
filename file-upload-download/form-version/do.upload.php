<?php

header('content-type:text/html;charset=utf-8');
require_once './upload.class.php';

$uploadObject = new Upload('uploadfile', 'test');
$dest = $uploadObject->uploadFile();
echo($dest);


