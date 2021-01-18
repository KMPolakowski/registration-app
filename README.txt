1. Describe possible performance optimizations for your Code.

    * Use OP Cache.

    * Use Lumen.
    
2. Which things could be done better, than you’ve done it?

    * Create custom Client for registering payment data.

    * Create seperate provider for the services.

    * Validate all input properly in a seperate service/class and throw appropriate exceptions, written as seperate classes,
    mapped to custom error response classes.

    * Create custom Response classes.

    * Fill form data into model classes and pass then to UserRegistratorService::register(), instead of passing the form array.

    * Add logging.

    * Document extensively.

    * Write Integration tests.    

How to deploy:
    * make sure port 80 is free
    * cp .env.example .env 
    * ./vendor/bin/sail up
    * apply database-structre.sql to the mysql server
    * deploy fe 