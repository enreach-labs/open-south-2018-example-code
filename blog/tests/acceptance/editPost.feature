Feature: editing blog posts
  As a blogger using the blog service
  In order to correct, amend or remove information contained in a blog post
  I need to be able to modify a single blog post
  Background:
    Given The application is configured

  Scenario: Edit blog post that exists
    Given the following blog post exist
      | id      | 13378a5b-e039-4333-9213-d1a10fa0dadd     |
      | title   | super cars 1/5                           |
      | content | first fancy blog post content about cars |
      | author  | paco.umbral@voiceworks.com               |
      | tags    | cars                                     |

    And I want to change the blog post with id "13378a5b-e039-4333-9213-d1a10fa0dadd" to contain the following data:
      | title   | fancy super cars                         |
      | content | blog post content about fancy super cars |
      | tags    | cars                                     |

    When I request the blog service to modify the blog post
    Then the blog post with id "13378a5b-e039-4333-9213-d1a10fa0dadd" should have changed and containe the following information:
      | id      | 13378a5b-e039-4333-9213-d1a10fa0dadd     |
      | title   | fancy super cars                         |
      | content | blog post content about fancy super cars |
      | author  | paco.umbral@voiceworks.com               |
      | tags    | cars                                     |


  Scenario: Edit a title to a title that already exists
    Given the following blog posts exist
      | id                                   | title        | content                                   | author                   | tags |
      | 13378a5b-e039-4333-9213-d1a10fa0dadd | super cars   | first fancy blog post content about cars  | great-dev@voiceworks.com | cars |
      | a5b4d0c7-2da1-4d1e-aaf4-e81a1ac32055 | super cars 2 | second fancy blog post content about cars | great-dev@voiceworks.com | cars |
    And I want to change the blog post with id "13378a5b-e039-4333-9213-d1a10fa0dadd" to contain the following data:
      | title   | super cars 2                             |
      | content | blog post content about fancy super cars |
      | tags    | cars                                     |

    When I request the blog service to modify the blog post
    Then I should be presented with an error explaining that a blog post with the title "super cars 2" already exists