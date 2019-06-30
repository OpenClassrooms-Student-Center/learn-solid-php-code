Feature:
    Pour ajouter une nouvelle musique
    En tant que visiteur
    J'ai besoin d'accéder au formulaire de mise à jour d'un album
    Et d'accéder au formulaire d'ajout de musique
    Et de soumettre le fichier au format mp3
    Et d'accéder à la musique créée

Scenario: Upload d'une musique
    Given I am on the homepage
    And I follow "Nouvel Album"
    And I fill in "title" with "Truck Stop"
    And I fill in "author" with "Blue Dot Sessions"
    And I attach the file "img/album_cover.jpg" to "Fichier"
    And I press "Ajouter"
    And I follow "Gestion des albums"
    When I follow "Uploader Pistes"
    Then I should see "Upload d'un titre"
    Then I should see "Fichier"
    Then I should see "Titre"
    When I fill in "Titre" with "Iowana"
    When I attach the file "mp3/Iowana.mp3" to "Fichier"
    When I press "Ajouter une piste"
    Then I should see "Piste enregistrée"
    Then I should see "Iowana"
    Then I should see "Modifier"
    Then I should see "Supprimer"
    Then I should see "Ajouter une piste"
