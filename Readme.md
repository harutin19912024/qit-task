# Task Tracker API

## Architectural Overview

This project is a simple Task Tracker API built using PHP 8.2 to handle tasks, including creating, updating, assigning, and deleting tasks. It follows SOLID principles for maintainability and scalability, with clear separation of concerns between services, repositories, controllers, and validation.

### **Architecture Diagram**

Check the Diagram [here](https://www.google.com)

---

## Justification of Design Decisions and Patterns

### **SOLID Principles**:
- **Single Responsibility Principle (SRP)**: Each class has a single responsibility. For example, the `TaskController` handles user input, and the `TaskService` contains the core business logic.
- **Open/Closed Principle (OCP)**: New functionality (e.g., additional validation rules or services) can be added without modifying existing code. The `Validator` class, for example, can be extended by registering new custom validators.
- **Liskov Substitution Principle (LSP)**: Custom validators implement the `ValidatorInterface`, ensuring that they can be used interchangeably within the validation logic.
- **Interface Segregation Principle (ISP)**: Classes are kept small and focused, ensuring that interfaces are specific to their needs (e.g., the `ValidatorInterface` for custom validators).
- **Dependency Inversion Principle (DIP)**: High-level modules (like the `TaskController`) depend on abstractions (like the `TaskService` and `Validator`) rather than concrete implementations.

### **Design Decisions**:
- **Task Repository**: The repository currently stores tasks in-memory for simplicity. This can be easily replaced with a database-backed repository in the future.
- **Custom Validation**: A custom validation class mimics Laravel’s approach to validation. This allows easy addition of rules and error handling.
- **JSON Response Handling**: A dedicated `JsonResponse` class standardizes all responses, ensuring consistent format across different API endpoints.

---

## Instructions to Run or Understand the Code

### **1. Clone the Repository**

Start by cloning the repository to your local machine:

```bash
git clone https://github.com/harutin19912024/qit-task.git
cd qit-task
```
### **2. Run The Project**
```bash
php -S localhost:8000 -t public
```

## API Endpoints

You can use Postman or cURL to test the API endpoints.

### **POST /tasks**: Create a new task

**Request:**

```bash
curl -X POST http://localhost::8000/task \
-H "Content-Type: application/json" \
-d '{
    "title": "New Task",
    "description": "This is a new task",
    "assigneeId": "some-uuid"
}'
```
**Response:**
```bash
{
    "message": "Task created successfully",
    "task": {
        "id": "some-uuid",
        "title": "New Task",
        "description": "This is a new task",
        "status": "todo",
        "assigneeId": "some-uuid",
        "createdAt": "2025-04-19T12:00:00Z"
    }
}
```

### **GET /tasks**: List all tasks

**Request:**

```bash
curl -X GET http://localhost::8000/tasks

```
**Response:**
```bash
[{
        "id": "some-uuid",
        "title": "New Task",
        "description": "This is a new task",
        "status": "todo",
        "assigneeId": "some-uuid",
        "createdAt": "2025-04-19T12:00:00Z"
    },
    {
        "id": "another-uuid",
        "title": "Another Task",
        "description": "This is another task",
        "status": "in_progress",
        "assigneeId": "another-uuid",
        "createdAt": "2025-04-18T14:00:00Z"
    }
]
```
