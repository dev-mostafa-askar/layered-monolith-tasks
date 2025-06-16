# **Laravel Task management Project**

This project implements a task management API using Laravel, following a monolith architecture with layered principles (Controller \-\> Service \-\> Repository) and Data Transfer Objects (DTOs) for data handling.

## **Table of Contents**

1. Features
2. Architectural Decisions
3. Installation
4. Running Reminders Cron Job
5. Contributing
6. License

## **Features**

-   **User Authentication:** Secure sign-up and sign-in with API token protection.
-   **Task Management:**
    -   CRUD (Create, Read, Update, Delete) operations for tasks.
    -   Soft Deletion for tasks.
    -   Listing tasks with **filters** and **full-text search**.
-   **Rate Limiting:** Protects the task creation endpoint (`/api/v1/tasks`) against abuse.
-   **Task Reminders:**
    -   Sends email reminders to users 24 hours before a task's due date.
    -   Utilizes Laravel's **queue jobs** for asynchronous email sending.
    -   Automated via a **cron job** to run every hour.

## **Architectural Decisions**

This project follows specific architectural patterns and data handling strategies for maintainability, scalability, and efficiency.

### **Layered Architecture (Controller \-\> Service \-\> Repository)**

The application adheres to a layered architecture, specifically:

-   **Controllers:** Handle incoming HTTP requests, validate input (using Form Requests), and delegate business logic to the Service layer. They are primarily responsible for request/response handling.
-   **Services:** Contain the core business logic. They orchestrate operations involving multiple repositories or complex data transformations, ensuring that controllers remain thin and focused on HTTP.
-   **Repositories:** Abstract the data persistence layer. They are responsible for interacting directly with the database (e.g., using Eloquent) and providing methods for data retrieval and storage, decoupling the business logic from the database implementation details.

**Why this approach?** This separation of concerns enhances:

-   **Maintainability:** Each layer has a single responsibility, making the codebase easier to understand, debug, and modify.
-   **Testability:** Individual layers can be tested in isolation (e.g., unit testing services without needing a database connection).
-   **Flexibility:** Database implementation can be changed (e.g., from MySQL to PostgreSQL) with minimal impact on the Service or Controller layers.
-   **Scalability:** Clear boundaries facilitate identifying performance bottlenecks and potentially scaling specific layers.

### **Monolith Architecture**

The project is structured as a monolith.

**Why this approach?**

-   **Simplicity:** Easier to develop, deploy, and manage for smaller to medium-sized applications.
-   **Unified Development:** All code resides in one codebase, simplifying dependency management and team coordination.
-   **Performance:** Direct function calls within the same process generally have lower latency compared to inter-service communication in microservices.
-   **Initial Velocity:** Faster to get a new project off the ground.

While microservices offer benefits for large-scale, distributed systems, a well-structured monolith like this provides a solid foundation that can be refactored into microservices later if complexity or scale demands it.

### **Data Transfer Objects (DTOs)**

DTOs are used to transfer data between the Controller, Service, and Repository layers.

**Why use DTOs?**

-   **Type Safety and Readability:** Provide a clear, type-hinted structure for data, improving code readability and reducing runtime errors.
-   **Reduced Over-fetching/Under-fetching:** Allow precise definition of the data required at each layer, preventing unnecessary data transfer.
-   **Decoupling:** Decouple internal domain models from external API representations or request structures, protecting the internal model from changes in external interfaces.
-   **Clarity:** Clearly define the input and output contracts for methods in services and repositories.

### **Usage of Enums**

Enums are utilized for fixed sets of values, such as task statuses (e.g., `pending`, `completed`).

**Why use Enums?**

-   **Improved Readability:** Self-documenting code as the purpose of values is explicit.
-   **Type Safety:** Prevents invalid values from being assigned, reducing bugs.
-   **Maintainability:** Easier to manage a predefined set of options in one place.

### **Storing Integers in Database for Enums (Minimizing Database Storage)**

Instead of storing raw string values for enums (e.g., 'completed', 'pending') directly in the database, their corresponding integer representations (e.g., 0 for 'pending', 1 for 'completed') are stored.

**Why this approach?**

-   **Database Storage Efficiency:** Integers consume significantly less storage space than strings, especially for frequently occurring values, leading to smaller database files and potentially faster backups/restores.
-   **Performance:** Indexing and querying integer columns are generally faster than string columns.
-   **Consistency:** Ensures data consistency and avoids typos that can occur with string-based enum values.

The mapping between integers and their string representations is handled in the application layer (e.g., using Laravel's native Enum casting or custom accessors/mutators), keeping the database optimized while providing human-readable values in the application.

## **Contributing**

Feel free to contribute by opening issues or submitting pull requests.

## **License**

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
