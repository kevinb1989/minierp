# Mini Erp

## Installation Guide
- create an empty mysql testing database
- configure the .env file
- then you are ready to run all the test cases. They currently all pass.

## What I have done so far
- All the business logic is included in app/MiniErp folder
- create repositories classes to operate the database (stored in app/MiniErp/Repositories)
- create separated classes to process the order
	- The MiniErp\OrderProcessing\OrderProcessor class persist a new order record
	and access the MiniErp\OrderProcessing\UpdateOrGenerateOrderItems class
	- The MiniErp\OrderProcessing\UpdateOrGenerateOrderItems will update or generate items
	for a newly created order.
- TDD is used all the way. I write unit tests and integration tests with continuous refactoring for almost everything. Check out the tests folder for all the test classes.

## What I am gonna do next
I reckon I have solve the hardest part of this technical test, which is order processing. The rest may take time, but it may be not that challenging. For the rest of the project, I am gonna do pretty 'the Laravel way'.

- add mailing to the business logic
- create events and event listener classes for mailing and changing order statuses.
- create jobs to group relevant commands and raise events.
- add controllers, inject jobs & write user interfaces
- use Behat for acceptance testing and make more complex scenarios for order processing
- continue to refactor the order processing logic

I welcome all the feedback and recommendations that you suggest.
