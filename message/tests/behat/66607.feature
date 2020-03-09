@core @core_message @javascript @arn
Feature: Delete messages from conversations
  In order to manage a course group in a course
  As a user
  I need to be able to delete messages from conversations

  Background:
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
    And the following "groups" exist:
      | name    | course | idnumber | enablemessaging |
      | Group 1 | C1     | G1       | 1               |
    And the following "group members" exist:
      | user     | group |
      | student1 | G1 |
      | student2 | G1 |
    And the following "group messages" exist:
      | user     | group  | message                   |
      | student1 | G1     | Hi!                       |
      | student2 | G1     | How are you?              |
      | student1 | G1     | Can somebody help me?     |
    And the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following config values are set as admin:
      | messaging        | 1 |
      | messagingminpoll | 1 |

  Scenario: Check an empty favourite conversation is still favourite
    Given the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I log in as "student1"
    And I open messaging
    And I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I should see "Delete"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"

    Given the following "private messages" exist:
      | user     | contact  | message       |
      | student1 | student2 | Hi!           |
      | student2 | student1 | Hello!        |
      | student1 | student2 | Are you free? |
    And the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    And I am on site homepage
    And I open messaging
    Then I should see "Student 2"
    And I select "Student 2" conversation in the "favourites" conversations list
    And I click on "Hi!" "core_message > Message content"
    And I click on "Hello!" "core_message > Message content"
    And I click on "Are you free?" "core_message > Message content"
    And "Delete selected messages" "button" should exist
    When I click on "Delete selected messages" "button"
    And I click on "//button[@data-action='confirm-delete-selected-messages']" "xpath_element"
    And I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "//*[@data-region='message-drawer']//div[@data-region='view-overview-favourites']" "xpath_element"
