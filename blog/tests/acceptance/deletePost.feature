Feature: deleting blog posts
  As a blogger using the blog service
  In order to stop sharing information with the world
  I need to be able to remove a single blog post
  Background:
    Given The application is configured

  Scenario: delete blog post that exists
    Given the following blog post exist
      | id      | 13378a5b-e039-4333-9213-d1a10fa0dadd     |
      | title   | super cars 1/5                           |
      | content | first fancy blog post content about cars |
      | author  | paco.umbral@voiceworks.com               |
      | tags    | cars                                     |
    When I request the blog service to remove the blog post with post id "13378a5b-e039-4333-9213-d1a10fa0dadd"
    Then the blog post with id "13378a5b-e039-4333-9213-d1a10fa0dadd" should have been removed
  Scenario: delete blog post that does not exists
    Given the blog post with post id "13378a5b-e039-4333-9213-d1a10fa0dadd" does not exist
    When I request the blog service to remove the blog post with post id "13378a5b-e039-4333-9213-d1a10fa0dadd"
    Then I should be presented with an error explaining that blog post with post id "13378a5b-e039-4333-9213-d1a10fa0dadd" does not exist
