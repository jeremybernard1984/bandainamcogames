<?php
$Ntable = $_GET['Ntable'];
$id_table = $_GET['id'];
$folder = $_GET['folder'];
try{
    $PDO = new PDO('mysql:host=db601175712.db.1and1.com;dbname=db601175712','dbo601175712','Sdk56six');
    $PDO->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
    $PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
}catch(PDOException $e){
    echo 'Connexion impossible';
}
// selon si game ou article ou news...
if ($Ntable == "games"){
    $pathfiles = "../../public/images/".$Ntable."/".$folder."/";
    // Préparation des requêtes
    if ($folder == "videoslinks"){
        $insertImage = $PDO->prepare("INSERT INTO videoslinks (id, image_videolink, ip_address, Ntable, id_table) VALUES ('', :original_image, :ip_address, :Ntable, :id_table)");
        $insertJoint = $PDO->prepare('INSERT INTO games_videoslinks (id_game, id_videolink) VALUES (:id_article, last_insert_id())');
    }else if($folder == "captures"){
        $insertImage = $PDO->prepare("INSERT INTO captures (id, image_capture, ip_address, Ntable, id_table) VALUES ('', :original_image, :ip_address, :Ntable, :id_table)");
        $insertJoint = $PDO->prepare('INSERT INTO games_captures (id_game, id_capture) VALUES (:id_article, last_insert_id())');
    }else if ($folder == "downloads"){
        $insertImage = $PDO->prepare("INSERT INTO downloads (id, image_download, ip_address, Ntable, id_table) VALUES ('', :original_image, :ip_address, :Ntable, :id_table)");
        $insertJoint = $PDO->prepare('INSERT INTO games_downloads (id_game, id_download) VALUES (:id_article, last_insert_id())');
    }

}elseif($Ntable == "posts"){
    $pathfiles = "../../public/images/".$Ntable."/".$folder."/";
    // Préparation des requêtes
    $insertImage = $PDO->prepare("INSERT INTO images (id, original_image, ip_address, Ntable, id_table) VALUES ('', :original_image, :ip_address, :Ntable, :id_table)");
    $insertJoint = $PDO->prepare('INSERT INTO articles_images (id_article, id_image) VALUES (:id_article, last_insert_id())');
}elseif($Ntable == "news"){
    $pathfiles = "../../public/images/".$Ntable."/".$folder."/";
    // Préparation des requêtes
    if ($folder == "videoslinks"){
        $insertImage = $PDO->prepare("INSERT INTO videoslinks (id, image_videolink, ip_address, Ntable, id_table) VALUES ('', :original_image, :ip_address, :Ntable, :id_table)");
        $insertJoint = $PDO->prepare('INSERT INTO news_videoslinks (id_news, id_videolink) VALUES (:id_article, last_insert_id())');
    }else if($folder == "images"){
        $insertImage = $PDO->prepare("INSERT INTO images (id, image_image, ip_address, Ntable, id_table) VALUES ('', :original_image, :ip_address, :Ntable, :id_table)");
        $insertJoint = $PDO->prepare('INSERT INTO news_images (id_news, id_image) VALUES (:id_article, last_insert_id())');
    }
}elseif($Ntable == "pages"){
    $pathfiles = "../../public/images/".$Ntable."/".$folder."/";
    if($folder == "images"){
        $insertImage = $PDO->prepare("INSERT INTO images (id, image_image, ip_address, Ntable, id_table) VALUES ('', :original_image, :ip_address, :Ntable, :id_table)");
        $insertJoint = $PDO->prepare('INSERT INTO pages_images (id_page, id_image) VALUES (:id_article, last_insert_id())');
    }
}elseif($Ntable == "demos") {
    $pathfiles = "../../public/images/" . $Ntable . "/" . $folder . "/";
    if ($folder == "images") {
        $insertImage = $PDO->prepare("INSERT INTO images (id, image_image, ip_address, Ntable, id_table) VALUES ('', :original_image, :ip_address, :Ntable, :id_table)");
        $insertJoint = $PDO->prepare('INSERT INTO demos_images (id_demo, id_image) VALUES (:id_article, last_insert_id())');
    }
}else{
    $pathfiles = "../../public/images/";
    // Préparation des requêtes
    $insertImage = $PDO->prepare("INSERT INTO images (id, original_image, ip_address, Ntable, id_table) VALUES ('', :original_image, :ip_address, :Ntable, :id_table)");
    $insertJoint = $PDO->prepare('INSERT INTO articles_images (id_article, id_image) VALUES (:id_article, last_insert_id())');
}
array();
//get the structured array
$images = restructure_array(  $_FILES );
$allowedExts = array("gif", "jpeg", "jpg", "png");

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
// upload.php
// 'images' refers to your file input name attribute
/*if (empty($images)) {
    echo json_encode(['error'=>'No files found for upload.']);
// or you can throw an exception
    return; // terminate
}*/
// a flag to see if everything is ok
$success = null;
// get the files posted
//$images = $_FILES['images'];
foreach ( $images as $key => $value){
    $i = $key+1;
    //create directory if not exists
    if (!file_exists($pathfiles)) {
        var_dump($pathfiles);die;
        mkdir($pathfiles, 0777, true);
    }
    $image_name = $value['name'];
    //get image extension
    $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    //assign unique name to image
    $name = 'img'.$i*time().'_'.$Ntable.'_'.$id_table.'.'.$ext;
    //$name = $image_name;
    //image size calcuation in KB
    $image_size = $value["size"] / 1024;
    $image_size = $value["size"] / 10000;
    $image_flag = true;
    //max image size
    $max_size = 10000;
    if( in_array($ext, $allowedExts) && $image_size < $max_size ){
        $image_flag = true;
    } else {
        $image_flag = false;
        $data[$i]['error'] = 'Maybe '.$image_name. ' exceeds max '.$max_size.' KB size or incorrect file extension';
    }
    if( $value["error"] > 0 ){
        $image_flag = false;
        $data[$i]['error'] = '';
        $data[$i]['error'].= '<br/> '.$image_name.' Image contains error - Error Code : '.$value["error"];
    }
    if($image_flag){
        move_uploaded_file($value["tmp_name"], $pathfiles.$name);
        $src = $pathfiles.$name;

        $dist = $pathfiles."thumbnail_".$name;
        $data[$i]['success'] = $thumbnail = 'thumbnail_'.$name;
        thumbnail($src, $dist, 200);
        $success = true;
        if ($success === true) {
            $insertImage->execute(array(
                "original_image" => $name,
                "ip_address" => $ip,
                "Ntable" => $Ntable,
                "id_table" => $id_table
            ));
            $insertJoint->execute(array(
                "id_article" => $id_table
            ));
        }

    } else {
        $success = false;
        break;
    }
}
// check and process based on successful status
if ($success === true) {
// call the function to save all data to database
// code for the following function `save_data` is not
// mentioned in this example
//save_data($userid, $username, $paths);
// store a successful response (default at least an empty array). You
// could return any additional response info you need to the plugin for
// advanced implementations.
    $output = [];
// for example you can get the list of files uploaded this way
// $output = ['uploaded' => $paths];
} elseif ($success === false) {
    $output = ['error'=>'Error while uploading images. Contact the system administrator'];
// delete any uploaded files
    foreach ($paths as $file) {
        unlink($file);
    }
} else {
    $output = ['error'=>'No files were processed.'];
}
// return a json encoded response for plugin to process successfully
echo json_encode($output);
function restructure_array(array $images)
{
    $result = array();
    foreach ($images as $key => $value) {
        foreach ($value as $k => $val) {
            for ($i = 0; $i < count($val); $i++) {
                $result[$i][$k] = $val[$i];
            }
        }
    }
    return $result;
}
function thumbnail($src, $dist, $dis_width = 100 ){
    $img = '';
    $extension = strtolower(strrchr($src, '.'));
    switch($extension)
    {
        case '.jpg':
        case '.jpeg':
            $img = @imagecreatefromjpeg($src);
            break;
        case '.gif':
            $img = @imagecreatefromgif($src);
            break;
        case '.png':
            $img = @imagecreatefrompng($src);
            break;
    }
    $width = imagesx($img);
    $height = imagesy($img);
    $dis_height = $dis_width * ($height / $width);
    $new_image = imagecreatetruecolor($dis_width, $dis_height);
    imagecopyresampled($new_image, $img, 0, 0, 0, 0, $dis_width, $dis_height, $width, $height);
    $imageQuality = 100;
    switch($extension)
    {
        case '.jpg':
        case '.jpeg':
            if (imagetypes() & IMG_JPG) {
                imagejpeg($new_image, $dist, $imageQuality);
            }
            break;

        case '.gif':
            if (imagetypes() & IMG_GIF) {
                imagegif($new_image, $dist);
            }
            break;

        case '.png':
            $scaleQuality = round(($imageQuality/100) * 9);
            $invertScaleQuality = 9 - $scaleQuality;

            if (imagetypes() & IMG_PNG) {
                imagepng($new_image, $dist, $invertScaleQuality);
            }
            break;
    }
    imagedestroy($new_image);
}
?>