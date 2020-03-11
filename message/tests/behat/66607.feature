@core @core_message @javascript @arn
Feature: 66607-1
  In order to communicate with fellow users
  As a user
  I need to be able to delete conversations

  Scenario: Check a deleted starred conversation is still starred
    Given the following "users" exist:
      | username | firstname | lastname | email                |
      | student1 | Student   | 1        | student1@example.com |
      | student2 | Student   | 2        | student2@example.com |
    And the following "courses" exist:
      | name | shortname |
      | course1 | C1 |
    And the following "course enrolments" exist:
      | user | course | role |
      | student1 | C1 | student |
      | student2 | C1 | student |
    And the following config values are set as admin:
      | messaging         | 1 |
      | messagingallusers | 1 |
      | messagingminpoll  | 1 |
    And the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |

    Given the following "favourite conversations" exist:
      | user     | contact  |
      | student1 | student2 |
    When I log in as "student1"

    And I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    And I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    And I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    And I go back in "view-conversation" message drawer
    And I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"

    Given the following "private messages" exist:
      | user     | contact  | message               |
      | student1 | student2 | Hi!                   |
      | student2 | student1 | What do you need?     |
    And I am on site homepage
    When I open messaging
    And I select "Student 2" conversation in the "favourites" conversations list
    And I open contact menu
    And I click on "Delete conversation" "link" in the "//div[@data-region='header-container']" "xpath_element"
    Then I should see "Delete"
    When I click on "//button[@data-action='confirm-delete-conversation']" "xpath_element"
    Then I should not see "Delete"
    And I should not see "Hi!" in the "Student 2" "core_message > Message conversation"
    When I go back in "view-conversation" message drawer
    Then I should not see "Student 2" in the "favourites" "core_message > Message list area"
