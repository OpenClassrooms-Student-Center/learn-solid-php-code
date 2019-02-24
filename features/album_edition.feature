Feature:
    In order to update an album
    As a visitor
    I need to be able to access the update form
    And to fill it with information
    And to access the newly update album

Scenario: Album update
    Given I am on the homepage
    When I follow "Gestion des albums"
    When I follow "Modifier"
    Then I should see "Modifier un album"
    And I fill in "title" with "Mon nouvel album 2"
    And I fill in "author" with "Zozor 3"
    Then I press "Modifier"
    Then I should see "Modifications enregistrées"
    Then I should see "Mon nouvel album 2"
    Then I should see "Zozor 3"
