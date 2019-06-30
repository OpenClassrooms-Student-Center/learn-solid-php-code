Feature:
    Pour supprimer un album
    En tant que visiteur
    Je dois pouvoir accéder au formulaire
    Et si je clique sur "Supprimer"
    Alors l'album doit être supprimé

Scenario: Suppression d'un album
    Given I am on the homepage
    And I follow "Nouvel Album"
    And I fill in "title" with "Truck Stop"
    And I fill in "author" with "Blue Dot Sessions"
    And I attach the file "img/album_cover.jpg" to "file"
    And I press "Ajouter"
    When I follow "Gestion des albums"
    Then I should see "Module d'administration des Albums"
    Then I should see "Supprimer"
    When I follow "Supprimer"
    When I follow "Confirmer"
    Then I should see "Album supprimé"

