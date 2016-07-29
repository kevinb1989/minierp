# Mini Erp

## Installation Guide
- create an empty mysql database
- configure database info in the .env file, please set the MAIL_DRIVER to log
- run migration and seed the database, the products table will be seeded
- If you are interested in running all the test cases, please create an
app/database/testing_minierp.sqlite file.

## Create a new order

In order to create a new order via a json request, you may use Chrome Advanced REST client.
Please send a POST application/json request to 'orders' route.

Unfortunately, I have a problem validating the body of the request against a json schema.
So the pattern of a request body has to match exactly the schema given in the technical test specs.

## What I have done
I reckon the project is pretty completed. I have completed all features.

- All the business logic is included and divided in app/MiniErp folder
- TDD is used all the way. I write unit tests and integration tests with continuous refactoring for almost everything. Check out the tests folder for all the test classes.
- events to update order status and send emails (emails are simply logged)
- controllers with injected dependencies
- UIs using bootstrap and datatables

## What I can do more to perfect it
- continue to refactor the business logic
- BDD with Codeception and Behat
- Testing email with MailThief and mailtrap.io
- validate the json request against a json schema.

I welcome all the feedback and recommendations that you guys suggest.
