@core @core_message @javascript @arn
Feature: 66607-2
  In order to communicate with fellow users
  As a user
  I need to be able to delete conversations

  Scenario: Check an empty favourite conversation is still favourite
    Given the following "courses" exist:
      | fullname | shortname | category | groupmode |
      | Course 1 | C1        | 0        | 1         |
    And the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Student   | 1        | student1@example.com |
      | student2 | Student   | 2        | student2@example.com |
    And the following "course enrolments" exist:
      | user     | course | role |
      | student1 | C1     | student |
      | student2 | C1     | student |
    And the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following config values are set as admin:
      | messaging        | 1 |
      | messagingminpoll | 1 |

    Given the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I log in as "student1"

    Given I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And I am on site homepage
    When I open messaging
    Then I should see "Student 2"
    When I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    Then "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"
