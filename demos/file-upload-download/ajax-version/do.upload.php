<?php

header('content-type:text/html;charset=utf-8');
require_once './upload.class.php';

$uploadObject = new Upload('uploadfile', 'test');
$return = $uploadObject->uploadFile();

echo json_encode($return);


