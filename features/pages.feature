Feature:
    En tant que visiteur
    Je dois pouvoir accéder à la page d'accueil
    Et à la page "Nouvel Album"
    Et à la page "Gestion des albums"
    Et à la page d'"Aide"

Scenario: Accéder à la liste des albums
    Given I am on the homepage
    Then I should see "Les derniers Albums enregistrés"
    Then I should see "Liste de tous les Albums"

Scenario: Accéder à la page Nouvel Album
    Given I am on the homepage
    When I follow "Nouvel Album"
    Then I should see "Ajouter un album"

Scenario: Accéder à la page "Gestion des albums"
    Given I am on the homepage
    When I follow "Gestion des albums"
    Then I should see "Module d'administration des Albums"

Scenario: Accéder à la page d'aide
    Given I am on the homepage
    When I follow "Aide"
    Then I should see "Principe de ce site"
    Then I should see "Ajout d'un album"
