<?php

/**
 * Description of Musique_List
 *
 * @author mickael.andrieu
 */
class Musique_List {
    
    private $list_of_musics;
    
    public function __construct($list_of_musics) {
        $this->list_of_musics = $list_of_musics;
    }
    
    public function viewHtml(){
        $html ='<h3>Liste des Pistes</h3>
            <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Titre</th><th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>';
                    foreach($this->list_of_musics as $music){
                        $Musique_ui = Musique_Ui::factory($music);
                        $html .=  $Musique_ui->makeAdminRowHtml() . $Musique_ui->displayModal();
                    }
                    $html .= '</tbody></table>';
        return $html;
    }
}

?>
