<?php
$tableEncours = $_GET['tableEncours'];
$idExist = $_GET['id'];
$folder = $_GET['folder'];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Page upload captures</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../../public/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
</head>
    <body>
        <div class="container">
            <form enctype="multipart/form-data" >
                <div class="form-group">
                    <input id="input-img" name="images[]" type="file" multiple=true class="file-loading">
                </div>
            </form>
        </div>
    </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../../public/js/fileinput.js" type="text/javascript"></script>
<script>
        $("#input-img").fileinput({
            uploadAsync: false,
            uploadUrl: "../../Table/ImageScriptUpload.php?Ntable=<?=$tableEncours?>&folder=<?=$folder?>&id=<?=$idExist?>" // your upload server url
        });
</script>