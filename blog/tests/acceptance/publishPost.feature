Feature:  creating blog posts
  As a blogger using the blog service
  In order to be able to share information with the world
  I need to be able to create blog posts containing information I want to share
  Background:
    Given The application is configured

  Scenario: Blog is valid and can be created
    Given
    Given I want to create a blog post containing the following information
      | id      | 3d5fe339-0107-48bc-b9c7-7d97f2b605af  |
      | title   | title 1                               |
      | content | bla bla bla                           |
      | author  | paco.umbral@voiceworks.com            |
      | tags    | nice,awesome                          |
    When I request the blog service to create the blog post
    Then the post with id "3d5fe339-0107-48bc-b9c7-7d97f2b605af" should be stored

  Scenario: Blog post contains no title
    Given I want to create a blog post containing the following information
      | id      | 3d5fe339-0107-48bc-b9c7-7d97f2b605af  |
      | title   |                                       |
      | content | bla bla bla                           |
      | author  | paco.umbral@voiceworks.com            |
      | tags    | nice,awesome                          |
    When I request the blog service to create the blog post
    Then I should be presented with an error explaining that blog posts should contain a title

  Scenario: Blog post requires one or more tags
    Given I want to create a blog post containing the following information
      | id      | 3d5fe339-0107-48bc-b9c7-7d97f2b605af  |
      | title   | title 1                               |
      | content | bla bla bla                           |
      | author  | paco.umbral@voiceworks.com            |
      | tags    |                                       |
    When I request the blog service to create the blog post
    Then I should be presented with an error explaining that blog posts should contain at least one tag

  Scenario: Blog post contains no author
    Given I want to create a blog post containing the following information
      | id      | 3d5fe339-0107-48bc-b9c7-7d97f2b605af  |
      | title   | title 1                               |
      | content | bla bla bla                           |
      | author  |                                       |
      | tags    | nice,awesome                          |
    When I request the blog service to create the blog post
    Then I should be presented with an error explaining that blog posts should contain an author

  Scenario: Blog post contains an invalid author
    Given I want to create a blog post containing the following information
      | id      | 3d5fe339-0107-48bc-b9c7-7d97f2b605af  |
      | title   | title 1                               |
      | content | bla bla bla                           |
      | author  | paco.umbral-voiceworks.com            |
      | tags    | nice,awesome                          |
    When I request the blog service to create the blog post
    Then I should be presented with an error explaining that blog posts should contain an author in form of an email address
#
#  Scenario: Create a blog post containing a not unique title
#    Given the following blog posts exist
#      | id      | 3d5fe339-0107-48bc-b9c7-7d97f2b605af  |
#      | title   | title 1                               |
#      | content | bla bla bla                           |
#      | author  | paco.umbral@voiceworks.com            |
#      | tags    | nice,awesome                          |
#    And I want to create a blog post containing the following information
#      | id      | 3d5fe339-0107-48bc-b9c7-7d97f2b605af  |
#      | title   | title 1                               |
#      | content | bla bla bla                           |
#      | author  | paco.umbral@voiceworks.com            |
#      | tags    | nice,awesome                          |
#    When I request the blog service to create the blog post
#    Then I should be presented with an error explaining that a blog post with the title "super cars" already exists
