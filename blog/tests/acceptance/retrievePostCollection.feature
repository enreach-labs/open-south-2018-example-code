Feature: Retrieving blog posts
  As a consumer of the blog
  In order to stay up to date with information shared by bloggers
  I need to be able to retrieve multiple blog posts at once
  Background:
    Given The application is configured

  Scenario: Retrieving blog posts wit a limit starting from 1
    Given the following blog posts exist
      | id                                   | title               | content                                   | author                   | tags |
      | 13378a5b-e039-4333-9213-d1a10fa0dadd | super cars part 1/5      | first fancy blog post content about cars  | great-dev@voiceworks.com | cars |
      | a5b4d0c7-2da1-4d1e-aaf4-e81a1ac32055 | super cars part 2/5 | second fancy blog post content about cars | great-dev@voiceworks.com | cars |
      | 645cf2d7-e871-4c09-b19b-b80bbb89a555 | super cars part 3/5 | third fancy blog post content about cars  | great-dev@voiceworks.com | cars |
      | 8bd52614-cbd7-46f0-9214-783b331edc31 | super cars part 4/5 | fourth fancy blog post content about cars | great-dev@voiceworks.com | cars |
      | 9312a2be-901a-47c9-a53c-e896046377c2 | super cars part 5/5 | fifth fancy blog post content about cars  | great-dev@voiceworks.com | cars |

    When I request the blog service to retrieve 3 blog posts starting from blog post 1
    Then I should be presented with the following blog posts
      | id                                   | title               | content                                   | author                   | tags |
      | 13378a5b-e039-4333-9213-d1a10fa0dadd | super cars part 1/5      | first fancy blog post content about cars  | great-dev@voiceworks.com | cars |
      | a5b4d0c7-2da1-4d1e-aaf4-e81a1ac32055 | super cars part 2/5 | second fancy blog post content about cars | great-dev@voiceworks.com | cars |
      | 645cf2d7-e871-4c09-b19b-b80bbb89a555 | super cars part 3/5 | third fancy blog post content about cars  | great-dev@voiceworks.com | cars |


  Scenario: Retrieving blog posts wit a limit starting from 3
    Given the following blog posts exist
      | id                                   | title               | content                                   | author                   | tags |
      | 13378a5b-e039-4333-9213-d1a10fa0dadd | super cars part 1/5      | first fancy blog post content about cars  | great-dev@voiceworks.com | cars |
      | a5b4d0c7-2da1-4d1e-aaf4-e81a1ac32055 | super cars part 2/5 | second fancy blog post content about cars | great-dev@voiceworks.com | cars |
      | 645cf2d7-e871-4c09-b19b-b80bbb89a555 | super cars part 3/5 | third fancy blog post content about cars  | great-dev@voiceworks.com | cars |
      | 8bd52614-cbd7-46f0-9214-783b331edc31 | super cars part 4/5 | fourth fancy blog post content about cars | great-dev@voiceworks.com | cars |
      | 9312a2be-901a-47c9-a53c-e896046377c2 | super cars part 5/5 | fifth fancy blog post content about cars  | great-dev@voiceworks.com | cars |

    When I request the blog service to retrieve 3 blog posts starting from blog post 3
    Then I should be presented with the following blog posts
      | id                                   | title               | content                                   | author                   | tags |
      | 645cf2d7-e871-4c09-b19b-b80bbb89a555 | super cars part 3/5 | third fancy blog post content about cars  | great-dev@voiceworks.com | cars |
      | 8bd52614-cbd7-46f0-9214-783b331edc31 | super cars part 4/5 | fourth fancy blog post content about cars | great-dev@voiceworks.com | cars |
      | 9312a2be-901a-47c9-a53c-e896046377c2 | super cars part 5/5 | fifth fancy blog post content about cars  | great-dev@voiceworks.com | cars |
