# Inventory Management System with RBAC & Doctrine ORM

Enterprise-grade Inventory Management System built using PHP 8.2, CodeIgniter 4, Doctrine ORM, Repository Pattern, Dependency Injection, Service Container, and Role-Based Access Control (RBAC).

The project demonstrates modern PHP application architecture and enterprise software development practices, focusing on scalability, maintainability, testability, and clean code principles.

---

## 🚀 Project Overview

This application simulates a real-world Inventory Management System commonly used in ERP, CRM, Warehouse Management, and Enterprise Resource Planning solutions.

The system provides inventory tracking, product management, warehouse management, user administration, authentication, authorization, and dynamic permission-based access control.

The primary objective of this project is to showcase enterprise architecture patterns and best practices using CodeIgniter 4 and Doctrine ORM.

---

## ✨ Key Features

### Authentication & Authorization

- User Login & Logout
- Session Management
- User Management
- Role-Based Access Control (RBAC)
- Permission-Based Authorization
- Route-Level Access Control
- Dynamic Role-Permission Assignment

### Inventory Management

- Product Management
- Category Management
- Warehouse Management
- Branch Management
- Inventory Tracking
- Stock Management

### Employee Management

- Employee Profiles
- User Role Assignment
- Permission Management

### Administration Dashboard

- AdminLTE 4 Dashboard Integration
- Responsive UI
- Role Management Interface
- Permission Configuration Screen

---

## 🏗️ Architecture & Design Principles

The application follows enterprise-grade software architecture patterns.

### SOLID Principles

- Single Responsibility Principle (SRP)
- Open/Closed Principle (OCP)
- Liskov Substitution Principle (LSP)
- Interface Segregation Principle (ISP)
- Dependency Inversion Principle (DIP)

### Design Patterns

- Repository Pattern
- Service Layer Pattern
- Dependency Injection (DI)
- Service Container
- Entity-Based Domain Model
- Separation of Concerns

---

## 📌 Repository Pattern

Repositories abstract data access logic from business logic.

Example:

```php
interface ProductRepositoryInterface
{
    public function find(int $id);
    public function findAll();
    public function save(Product $product);
    public function delete(Product $product);
}
```

Benefits:

- Loose Coupling
- Testability
- Maintainability
- Swappable Data Sources

---

## 📌 Service Layer Pattern

Business logic resides inside Services rather than Controllers.

Example:

```php
class ProductService
{
    public function createProduct(array $data)
    {
        // Business Rules
    }
}
```

Benefits:

- Thin Controllers
- Centralized Business Logic
- Better Reusability
- Easier Unit Testing

---

## 📌 Dependency Injection

Dependencies are injected through constructors.

```php
class ProductController extends BaseController
{
    public function __construct(
        ProductService $productService
    ) {
        $this->productService = $productService;
    }
}
```

Benefits:

- Reduced Coupling
- Improved Testability
- Better Maintainability

---

## 📌 Service Container

The Service Container manages application dependencies and object lifecycle.

Benefits:

- Centralized Dependency Resolution
- Cleaner Architecture
- Easier Service Management

---

## 🔐 Role-Based Access Control (RBAC)

The application implements a flexible RBAC system.

### Roles

- Super Admin
- Admin
- Employee
- User

### Sample Permissions

```text
products.index
products.create
products.edit
products.delete

categories.index
categories.create
categories.edit
categories.delete

warehouses.index
warehouses.create
warehouses.edit
warehouses.delete

roles.index
roles.edit
roles.update
```

### Permission Flow

```text
User
 ↓
Role
 ↓
Role Permissions
 ↓
Permission Validation
 ↓
Controller Access
```

### Features

- Dynamic Role Creation
- Dynamic Permission Assignment
- Permission-Based Menu Access
- Route-Level Authorization
- Centralized Permission Validation

---

## 🗄️ Doctrine ORM Integration

The project uses Doctrine ORM instead of Active Record to demonstrate enterprise-level data access architecture.

### Features

- Entity Mapping
- Entity Manager
- Repository Integration
- Lazy Loading
- Relationship Management
- Database Abstraction

### Example Entity

```php
#[ORM\Entity]
#[ORM\Table(name: "products")]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $name = null;
}
```

---

## 📂 Project Structure

```text
app/
│
├── Controllers/
├── Services/
├── Repositories/
├── Interfaces/
├── Entities/
├── Libraries/
├── Middleware/
├── Config/
│
└── Views/
```

### Layer Responsibilities

```text
Controller
    ↓
Service Layer
    ↓
Repository Layer
    ↓
Doctrine EntityManager
    ↓
Database
```

---

## 💻 Technology Stack

### Backend

- PHP 8.2
- CodeIgniter 4
- Doctrine ORM

### Database

- MySQL

### Frontend

- AdminLTE 4
- Bootstrap 5
- JavaScript
- jQuery

### Development Concepts

- SOLID Principles
- Dependency Injection
- Service Container
- Repository Pattern
- Service Layer Architecture
- RBAC & ACL
- Clean Code Practices

---

## 🎯 Learning Objectives

This project demonstrates practical implementation of:

- Enterprise PHP Architecture
- Doctrine ORM Integration
- Repository Pattern
- Service Layer Pattern
- Dependency Injection
- Service Container
- SOLID Principles
- RBAC & ACL Design
- Inventory Management Workflows
- Scalable Application Design
- Maintainable Code Structure

---

## 📈 Key Technical Highlights

- Integrated Doctrine ORM with CodeIgniter 4.
- Built custom Entity Manager bootstrap.
- Implemented Repository Pattern for data access abstraction.
- Applied Service Layer architecture for business logic isolation.
- Implemented Dependency Injection and Service Container.
- Developed dynamic RBAC and permission management module.
- Built inventory, warehouse, category, and user management modules.
- Followed SOLID principles throughout the application.
- Designed scalable and maintainable enterprise application architecture.

---

## 🔮 Screenshots
<img width="1349" height="644" alt="Roles" src="https://github.com/user-attachments/assets/60857a1d-9b42-4f64-9a93-01b6ba418395" />
<img width="1349" height="1430" alt="Edit Role Permissions ADMIN" src="https://github.com/user-attachments/assets/62297037-f8f8-4145-ad80-077923c914a9" />
<img width="1349" height="723" alt="Employee" src="https://github.com/user-attachments/assets/978b9c2e-fa3f-4440-aab7-6a5bde16bc26" />

--
## 🔮 Future Enhancements

- JWT Authentication
- Multi-Tenant Architecture
- Audit Logs
- Event-Driven Notifications
- Product Barcode Management
- Inventory Forecasting
- API Versioning
- Docker Deployment
- Kubernetes Deployment
- CI/CD Pipeline Integration

---

## 👨‍💻 Author

Shailendra Kumar

Senior PHP Technical Lead | Solution Architect

Specializations:

- PHP
- CodeIgniter
- Laravel
- Doctrine ORM
- React
- SaaS Applications
- ERP Solutions
- CRM Platforms
- Enterprise Architecture

---

## ⭐ Purpose of This Project

This project was developed as a learning and demonstration platform to showcase:

- Enterprise PHP Development
- Modern Application Architecture
- Doctrine ORM Integration
- SOLID Principles
- Repository Pattern
- Dependency Injection
- Service Containers
- RBAC & Authorization Frameworks

The goal is to provide a practical reference implementation of clean, scalable, and maintainable enterprise software development practices.
