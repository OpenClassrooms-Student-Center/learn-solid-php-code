<?php

namespace App\Classes\Album;

class Collection
{
    private $albumCollection;

    public function __construct($albumCollection)
    {
        $this->albumCollection = $albumCollection;
    }

    public function viewHtml()
    {
        $html = '<section class="list_carousel">
                    <ul id="carousel">';
        foreach ($this->albumCollection as $album) {
            $ui = new Ui($album);
            $html .= '<li>' . $ui->makeHtml() . '</li>';
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
        $html = '<h2>Liste de tous les Albums</h2>
            <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Titre</th><th>Auteur</th><th>&nbsp;</th>
                      </tr>
                      </thead>
                      <tbody>';
        foreach ($this->albumCollection as $album) {
            $ui = new Ui($album);
            $html .= $ui->makeRowView();
        }
        $html .= '</tbody></table>';

        return $html;
    }
}
