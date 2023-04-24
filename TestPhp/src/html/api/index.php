<?php

const uploads_dir = '/var/www/uploads';

$dir = isset($_GET['dir']) ? trim($_GET['dir'], '/') : '';
$file = isset($_GET['file']) ? trim($_GET['file']) : '';
$method = $_SERVER['REQUEST_METHOD'];

//echo 'uploads = ' . uploads_dir . '; dir = ' . $dir . ';';
//exit();

if ($method === 'GET') {
	if(empty($file)) GetFilesOnDirectory($dir);
	else DownloadFile($dir, $file);
 
} elseif ($method === 'POST') {
    // Загрузка файла
    UploadFile($dir);
} else {
    // Неверный метод запроса
    http_response_code(405);
    exit();
}
function CheckForbiddenDirectory($targetPath){
    if (strpos($targetPath, uploads_dir) !== 0 ) {
	    header('HTTP/1.0 403 Forbidden');
	    exit();
	}
}
function CheckFindDirrectory($targetPath){
	if (!is_dir($targetPath)) {
        header('HTTP/1.0 404 Not Found');
        exit();
    }
}
function CheckHiddenFile(){
    if ($file[0] === '.') {
	   	header('HTTP/1.0 403 Forbidden');
	    exit();
	}
}
function CheckFindFile($targetPath){
    if (!is_file($targetPath)) {
	    header('HTTP/1.0 404 Not Found');
	    exit();
	}
}
function GetFilesOnDirectory($dir){

	$target_dir = realpath(uploads_dir . '/' . $dir);
	CheckForbiddenDirectory($target_dir);
    $files = scandir($target_dir);
    $result = array();
    foreach ($files as $f) {
        if ($f[0] === '.') continue;
        $filepath = $target_dir . '/' . $f;
        if (is_dir($filepath)) {
            $result[] = array('name' => $f, 'type' => 'folder');
        } else {
            $result[] = array('name' => $f, 'type' => 'file');
        }
    }
    header('Content-type: application/json');
    echo json_encode($result);
}
function DownloadFile($dir, $file){
	$target_path = realpath(uploads_dir . '/' . $dir . '/' . $file);
	CheckForbiddenDirectory($target_path);
	CheckHiddenFile();
	CheckFindFile($target_path);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($target_path) . '"');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($target_path));
    readfile($target_path);
}
function UploadFile($dir){
	$target_dir = realpath(uploads_dir . '/' . $dir);
	$fileName = basename($_FILES['file']['name']);
	$target_path = $target_dir . '/' . $fileName;
	CheckForbiddenDirectory($target_dir);
    if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        exit();
    }
    if (strpos($target_path, $target_dir) !== 0) {
        header('HTTP/1.0 403 Forbidden');
        exit();
    }
    if (move_uploaded_file($_FILES['file']['tmp_name'], $target_path)) {
        http_response_code(201);
        exit();
    } else {
        http_response_code(500);
        exit();
    }
}
?>