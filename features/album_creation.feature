Feature:
    In order to add new album
    As a visitor
    I need to be able to access the creation form
    And to fill it with information
    And to access the newly created album

Scenario: Album creation
    Given I am on the homepage
    When I follow "Nouvel Album"
    And I fill in "title" with "Mon nouvel album"
    And I fill in "author" with "Zozor"
    When I attach the file "img/album_1.jpg" to "file"
    Then I press "ajouter"
    Then I should see "Album enregistré"
    Then I should see "Mon nouvel album"
    Then I should see "Zozor"
