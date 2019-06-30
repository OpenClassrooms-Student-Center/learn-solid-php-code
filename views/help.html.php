<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="icon" href="../ui/img/favicon.ico" />
        <title>We Play Music ! - Aide</title>
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

    <h3>Principe de ce site</h3>
    <p>
        WePlayMusic.fr est un outil de gestion d'albums de musique en ligne.
    </p>

    <h4>Ajout d'un album</h4>
    <p>
        Pour ajouter un album, il faut remplir le formulaire correspondant
        en accédant à la page <a href="../admin/index.php?a=ajouter">Nouvel Album</a>. On associe une image à l'album,
        aux formats (jpg/png), un titre et un auteur. En cas d'échec, des messages 
        d'erreurs expliciteront la raison de l'échec.
    </p>

    <h4>Upload des musiques</h4>
    <p>
        L'album créé, vous pouvez soit uploader directement des pistes,
        soit par accès à la page <a href="../admin/index.php">Gestion des Albums</a>. Actuellement, l'application
        ne gère que le format mp3, mais il est prévu que le format ogg soit également géré.
        Une musique contient donc un fichier mp3, on doit également lui associer un titre.
    </p>
    <p>
        <span class="label label-info">En cas d'échec, lisez les messages d'erreur avant de contacter un administrateur</span>
    </p>

    <h4>Gestion générale</h4>
    <p>
        Toutes les actions d'administration de vos albums se fait au niveau de la page
        <a href="../admin/index.php">Gestion des albums</a>, que ce soit la modification ou la suppression des albums.
        L'administration des pistes d'un album se fait au sein de cet album (ajout/modification/suppression).
        Une fenêtre de confirmation pour les opérations de suppression a été mise en place, pour pallier aux erreurs de manipulation.
    </p>

    <h4>Affichage des albums</h4>
    <p>
        En page d'accueil, on peut accéder à l'ensemble des albums.
        Il y a actuellement 2 modes de visualisation de votre <a href="../public/index.php">Musithèque</a>:
    </p>
        <ul>
            <li>Un Mode découverte: Liste des derniers albums ajoutés sous forme de slider</li>
            <li>Un Mode classique: Liste de tous les albums ajoutés sous forme de tableau</li>
        </ul>
    <p>
        <span class="label label-info">En mode découverte, on accède à la lecture des albums en cliquant sur la vignette.</span>
    </p>

    <script type="text/javascript">
        $('.nav li:eq(2)').attr('class','active');
    </script>

    <!-- Footer -->
    <?php include_once '../ui/fragments/footer.frg.html'; ?>
    </body>
</html>