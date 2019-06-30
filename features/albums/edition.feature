Feature:
    Pour éditer un album
    En tant que visiteur
    J'ai besoin d'accéder au formulaire d'édition
    Et après avoir complété les informations
    Je dois pouvoir accéder à l'album mis à jour

Scenario: Mise à jour d'un album
    Given I am on the homepage
    And I follow "Nouvel Album"
    And I fill in "title" with "Truck Stop"
    And I fill in "author" with "Blue Dot Sessions"
    And I attach the file "img/album_cover.jpg" to "file"
    And I press "Ajouter"
    And I follow "Gestion des albums"
    When I follow "Modifier"
    Then I should see "Modifier un album"
    And I fill in "title" with "Truck Stop 2"
    And I fill in "author" with "Blue Dot Sessions 2"
    Then I press "Modifier"
    Then I should see "Modifications enregistrées"
    Then I should see "Truck Stop 2"
    Then I should see "Blue Dot Sessions 2"
