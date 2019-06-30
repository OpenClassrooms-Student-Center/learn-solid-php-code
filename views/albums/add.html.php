<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="../ui/img/favicon.ico" />
        <title>We Play Music ! - Ajouter un album</title>
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
    <?php include_once '../ui/fragments/header.frg.html'; ?>
    <!-- Main content -->
    <h2>
        <?php echo $parameters['title']; ?>
    </h2>

    <form action="<?php echo $parameters['submitUrl']; ?>" method="post" enctype="multipart/form-data">
        <div class="controls">
            <label for="file">Fichier:</label>
            <input type="file" id="file" onchange="filesInputHandler(this.files,'title')" name="file">
        </div>
        <div class="controls">
            <label for="title">Titre :</label>
            <input type="text" id="title"  name="title">
        </div>
        <div class="controls">
            <label for="author">Auteur :</label>
            <input type="text" id="author" name="author">
        </div>
        <div class="submit form-actions">
            <input type="hidden" name="id" value="<?php echo $parameters['albumId']; ?>">
            <button class="btn btn-primary" type="submit" name="go">Ajouter</button>
        </div>
    </form>

    <script type="text/javascript">
        $('.nav li:eq(0)').attr('class','active');
    </script>

    <!-- Footer -->
    <?php include_once '../ui/fragments/footer.frg.html'; ?>
    </body>
</html>
