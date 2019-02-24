Feature:
    In order to list the latest albums
    As a visitor
    I need to be able to show the list of albums
    And to access to "New album" page
    And to access to "Admin part" page
    And to access to "Help" page

Scenario: Access the list of latest albums
    Given I am on the homepage
    Then I should see "Les derniers Albums enregistrés"
    Then I should see "Liste de tous les Albums"

Scenario: Access the "New album" page
    Given I am on the homepage
    When I follow "Nouvel Album"
    Then I should see "Ajouter un album"

Scenario: Access the "Admin part" page
    Given I am on the homepage
    When I follow "Gestion des albums"
    Then I should see "Module d'administration des Albums"

Scenario: Access the "Help" page
    Given I am on the homepage
    When I follow "Aide"
    Then I should see "Principe de ce site"
    Then I should see "Ajout d'un album"
