<?php
    $album = $parameters['album'];
    $id = $this->album->getId();
    $deleteUrl = ADMIN_URL . 'index.php?a=supprimer&amp;id=' . $id;
?>
<div id="deleteModal" class="modal hide fade in" >
    <div class="modal-header">
        <a class="close" data-dismiss="modal">×</a>
        <h3>Confirmation de Suppression</h3>
    </div>
    <div class="modal-body">
        <p> Attention: Opération irréversible </p>
    </div>

    <div class="modal-footer">
        <a class="btn" data-dismiss="modal" href="#">Annuler</a>
        <a class="btn btn-primary" href="<?php echo $deleteUrl; ?>">Confirmer</a>
    </div>
</div>