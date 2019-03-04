<?php
    $album = $parameters['album'];
    $title = $album->getTitle();
    $author = $album->getAuthor();
    $fileSource = DATA_URL . 'tb_' . $album->getFile();
    $id = $album->getId();
    $updateUrl = ADMIN_URL . 'index.php?a=modifier&amp;id='.$id;
    $uploadUrl = ADMIN_URL . 'index.php?a=uploader&amp;id='.$id;
?>

<tr>
    <td><?php echo $title; ?></td>
    <td><?php echo $author; ?></td>
    <td>
        <img
            src="<?php echo $fileSource; ?>"
            alt="<?php echo $title; ?>" 
        />
    </td>
    <td>
        <ul class="nav nav-tabs nav-stacked">
            <li>
                <a href="<?php echo $updateUrl ?>">Modifier</a>
            </li>
            <li>
                <a href="<?php echo $uploadUrl ?>">Uploader Pistes</a>
            </li>
            <li>
                <a href="#deleteModal" data-toggle="modal">Supprimer</a>
            </li>   
        </ul>
    </td>
</tr>
