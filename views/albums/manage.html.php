<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="../ui/img/favicon.ico" />
        <title>We Play Music !</title>
        <link rel="stylesheet" type="text/css" media="all" href="../ui/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="../ui/css/base.css"/>
        <script src="../ui/js/jquery.min.js"></script>
        <script src="../ui/js/bootstrap.js"></script>
        <script src="../ui/helpers/kolber-audiojs/audiojs/audio.min.js"></script>
        <script src="../ui/helpers/carouFredSel-5.5.0/jquery.carouFredSel-5.5.0-packed.js"></script>
        <script src="../ui/js/myscript.js"></script>
    </head>
    <body>
        <!-- Header -->
        <?php include_once('../ui/fragments/header.frg.html'); ?>
        <!-- Main content -->
        <h2>
            <?php echo $parameters['title']; ?>
        </h2>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Auteur</th>
                    <th>Vignette</th>
                    <th>Actions</th>
            </tr>
            </thead>
            <?php echo $parameters['content']; ?>
            
        </table>
        <script type="text/javascript">
            $('.nav li:eq(1)').attr('class','active');
        </script>
        <!-- Footer -->
        <?php include_once('../ui/fragments/footer.frg.html'); ?>
    </body>
</html>