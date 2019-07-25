<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <link rel="icon" href="../ui/img/favicon.ico" />
    <title>We Play Music ! - <?php echo $parameters['title']; ?></title>
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

<table class='table table-striped'>
    <thead>
    <tr>
        <th>Titre</th><th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo $parameters['music_title']; ?></td>
        <td>
            <a class="btn" href="<?php echo $parameters['update_music']; ?>">Modifier <i class="icon-edit icon-white"></i></a>
            <a class="btn" href="<?php echo $parameters['delete_music']; ?>">Supprimer <i class="icon-trash icon-white"></i></a>
        </td>
    </tr>
    </tbody>
</table>
<div class="submit form-actions">
    <a class="btn btn-primary" href="<?php echo $parameters['submitUrl']; ?>">Ajouter une piste</a>
</div>

<script type="text/javascript">
    $('.nav li:eq(1)').attr('class','active');
</script>

<!-- Footer -->
<?php include_once '../ui/fragments/footer.frg.html'; ?>
</body>
</html>
