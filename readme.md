# Tech Test - Plentific

### Handling API Errors:

To effectively communicate API errors to developers using this package, I’ve wrapped all API calls within try-catch blocks. I have created a custom ApiException that is thrown when an error occurs. This exception provides a clear, domain-specific error message that developers can catch and handle appropriately in their own applications.

### Customizing API Exceptions:

When an API or third-party package throws a generic exception, it can be challenging to understand the specific context or cause within the domain. To address this, I’ve introduced the ApiException class, which translates these generic errors into more meaningful, domain-specific exceptions. This approach ensures that the errors are easier to debug and handle.

### Making the Code Testable:

To make the code testable, I've ensured that unit tests focus solely on the package's logic rather than the behavior of third-party services. This is achieved by mocking external API calls in the tests. The unit tests cover both successful (happy paths) and unsuccessful (sad paths) scenarios, ensuring the code is robust and fault-tolerant. For example, I've included tests that simulate API failures to verify that the package correctly handles these situations.

### Leveraging Established Tools:

Rather than reinventing the wheel, I have utilized Guzzle for handling HTTP requests and PHPUnit for unit testing. PHPUnit is included as a require-dev dependency, ensuring that its only used in the development environment and not included in production.
