<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title><?= App::getInstance()->title; ?></title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
    <link href="css/jquery.fancybox.css" rel="stylesheet">
    <link rel="stylesheet" href="css/datepicker.css">
    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <link href="css/fileinput.css" media="all" rel="stylesheet" type="text/css" />

    <![endif]-->
</head>
<body>

    <?php if (isset($_SESSION['auth'])) {?>
        <div id="wrapper">
            <?php
            require ROOT . '/app/Views/templates/INC/INC_menu.php';
            require ROOT . '/app/Views/templates/INC/INC_loader.php';
            ?>
            <div id="page-wrapper">
                <div id="contenu" class="container-fluid">
                    <?= $content; ?>
                </div><!-- /.container-fluid -->
            </div><!-- /#page-wrapper -->
        </div><!-- /.wrapper-->
    <?php }else{
       echo $content;
    } ?>

    <script src="js/jquery.js"></script>
    <script src="js/pageloader.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/min/jquery.form.min.js"></script>
    <script src="js/fileinput.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.fancybox.js?v=2.1.5"></script>
    <script src="js/lib/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="js/jquery.sticky.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script>
        $(window).load(function(){
            $("#menu_save").sticky({ topSpacing: 55 });
        });
    </script>

        <script>
            // Le DOM est pret
            $(document).ready(function() {
                $.pageLoader();
                $('.fancybox').fancybox();
            });
        </script>
    <?php if (isset($idExist)){ ?>
        <script>
            $(document).ready(function() {
                <?php
                if ($tableEncours == "games"){
                     echo "CKEDITOR.replace( 'CKeditor_description_game' );";

                }elseif($tableEncours == "news"){
                    echo "CKEDITOR.replace( 'CKeditor_resum_news' );";
                    echo "CKEDITOR.replace( 'CKeditor_description_news' );";
                    echo "$('#datepicker').datepicker({ format: 'dd-mm-yyyy' });";
                    //echo "var TimeZoned = new Date(e.date.setTime(e.date.getTime() + (e.date.getTimezoneOffset() * 60000)));";
                    //echo "$('#datepicker').datepicker('setDate', TimeZoned);";
                }elseif($tableEncours == "pages"){
                    echo "CKEDITOR.replace( 'CKeditor_resum_page' );";
                    echo "CKEDITOR.replace( 'CKeditor_description_page' );";
                }elseif($tableEncours == "demos"){
                    echo "$('#datepicker').datepicker({ format: 'dd-mm-yyyy' });";
                    echo "var TimeZoned = new Date(e.date.setTime(e.date.getTime() + (e.date.getTimezoneOffset() * 60000)));";
                    echo "$('#datepicker').datepicker('setDate', TimeZoned);";
                }

                ?>

                $('.fancyboxiframe').fancybox({
                    fitToView:false,
                    autoSize:false,
                    'width':parseInt($(window).width() * 0.7),
                    //'height':parseInt($(window).height() * 0.7),
                    'height':600,
                    'autoScale':true,
                    'type': 'iframe',
                    'afterClose':function () {
                        $('#myFrame1').attr('src', $('#myFrame1').attr('src'));
                        $('#myFrame').attr('src', $('#myFrame').attr('src'));
                        <?php if ($tableEncours == 'games'){
                            echo "$('#myFrame4').attr('src', $('#myFrame4').attr('src'));";
                        } ?>
                    }
                });

            });
        </script>
        <script src="js/script.js"></script>

    <?php } ?>
</body>
</html>
