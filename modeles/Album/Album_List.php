<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Album_List
 *
 * @author mickael.andrieu
 */
class Album_List
{
    private $list_of_albums;
    
    public function __construct($list_of_albums)
    {
        $this->list_of_albums = $list_of_albums;
    }
    
    public function viewHtml()
    {
        $html ='<section class="list_carousel">
                    <ul id="carousel">';
        foreach ($this->list_of_albums as $album) {
            $album_ui = new Album_Ui($album);
            $html .= '<li>'. $album_ui->makeHtml() .'</li>';
        }
        $html .= '</ul>
                                <div class="clearfix"></div>
                                <a id="prev" class="prev" href="#"></a>
                                <a id="next" class="next" href="#"></a>
                                </section>';
        
        return $html;
    }
    
    public function viewTable()
    {
        $html ='<h2>Liste de tous les Albums</h2>
            <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Titre</th><th>Auteur</th><th>&nbsp;</th>
                      </tr>
                      </thead>
                      <tbody>';
        foreach ($this->list_of_albums as $album) {
            $album_ui = new Album_Ui($album);
            $html .= $album_ui->makeRowView();
        }
        $html .= '</tbody></table>';
        
        return $html;
    }
}
