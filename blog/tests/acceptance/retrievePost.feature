Feature: Retrieving single blog post
  As a consumer of the blog service
  In order to stay up to date with information shared by a specific blogger
  I need to be able to retrieve a single blog post
  Background:
    Given The application is configured

  Scenario: retrieve a single blog post by post id
    Given the following blog post exist
      | id      | 13378a5b-e039-4333-9213-d1a10fa0dadd     |
      | title   | super cars 1/5                           |
      | content | first fancy blog post content about cars |
      | author  | paco.umbral@voiceworks.com               |
      | tags    | cars                                     |
    When I request the blog service to retrieve a single blog with post id "13378a5b-e039-4333-9213-d1a10fa0dadd"
    Then I shold be presented with the following blog post
      | id      | 13378a5b-e039-4333-9213-d1a10fa0dadd     |
      | title   | super cars 1/5                           |
      | content | first fancy blog post content about cars |
      | author  | paco.umbral@voiceworks.com               |
      | tags    | cars                                     |
  Scenario: retrieve a blog post that does not exist
    When I request the blog service to retrieve a single blog with post id "13378a5b-e039-4333-9213-d1a10fa0dadd"
    Then I should be presented with an error explaining that the blog post could not be found
