<?php

namespace App\Classes\Music;

class Collection
{
    private $musicCollection;

    public function __construct($musicCollection)
    {
        $this->musicCollection = $musicCollection;
    }

    public function viewHtml()
    {
        $html = '<h3>Liste des Pistes</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>'
        ;

        foreach ($this->musicCollection as $music) {
            $musicUi = Ui::factory($music);
            $html .= $musicUi->makeAdminRowHtml() . $musicUi->displayModal();
        }

        $html .= '</tbody></table>';

        return $html;
    }
}
