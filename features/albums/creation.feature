Feature:
    Pour ajouter un album
    En tant que visiteur
    J'ai besoin d'accéder au formulaire de création
    Et de le compléter
    Et d'accéder à l'album créé

Scenario: Création d'un Album
    Given I am on the homepage
    And I follow "Nouvel Album"
    And I fill in "title" with "Truck Stop"
    And I fill in "author" with "Blue Dot Sessions"
    And I attach the file "img/album_cover.jpg" to "file"
    And I press "Ajouter"
    Then I should see "Album enregistré"
    Then I should see "Truck Stop"
    Then I should see "Blue Dot Sessions"
