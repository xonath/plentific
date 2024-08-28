# Tech Test - Plentific

**Consider how you will communicate API errors to other developers using this package.**

**How will you make a generic exception thrown by an API/third party package more specific to your domain**

When reviewing the code you will see all calls are within a try catch block. I have generated an Exception "ApiException" for this domain, which gives my error message explaining the fail. This can be caught by the developer using the package and handled further.

**How can you make this code testable?**
Unit tests are to test the code not the third party. Unit tests should also test both happy and sad paths, to ensure they are fault tolerant. As you can see with my unit tests I havce included some example tests for failure.

**Do not re-invent the wheel**
I have used guzzle to aid in the handling of requests and PHP Unit for unit testing. The unit testing of course is set to require-dev so it is not included in production.


