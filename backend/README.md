# DecodeLabs Internship Projects Overview

Welcome to my Full Stack Development training repository for DecodeLabs. This repository contains all three projects assigned during the internship. They are organized step-by-step to demonstrate the progression from building a basic frontend interface to developing a fully functional, secure backend API with database persistence.

## 📁 Project Structure & Roadmap

### 1. Project 1: Frontend Development
This section contains the initial user interface (UI) design and layout. The focus of this project was to build a clean, responsive foundation for the application using core web technologies (HTML, CSS, JavaScript).

### 2. Project 2: API Logic & Routing
This phase introduces the backend server logic. It includes setting up the PHP environment, defining HTTP methods (such as GET and POST), and creating a basic routing system to handle client requests accurately.

### 3. Project 3: Database Persistence & CRUD Operations
This is the final phase, which connects the application logic to a MySQL database to ensure data longevity. It fully implements secure CRUD (Create, Read, Update, Delete) operations and error resilience.

---

## ⚙️ Project 3 Technical Documentation

Below are the technical details for the fully integrated backend system developed in Project 3.

### Gateway Anatomy
- **Local Server URL:** `http://localhost:8000`
- **API Base URL:** `http://localhost:8000/index.php`
- **Architecture:** RESTful (Treating nouns as resources)

### API Endpoints
| Method | Endpoint | Description | Status Codes |
| :--- | :--- | :--- | :--- |
| **GET** | `/users` | Fetch persistent data from the database | 200, 503 |
| **POST** | `/users` | Create and save a new user entry | 201, 400 |
| **PUT** | `/users` | Update an existing user's data | 200, 400 |
| **DELETE**| `/users` | Remove a specific user entry | 200, 400 |

### Resilience Protocol
- **Circuit Breaker Pattern:** The system is protected using PDO exception handling.
- **Fail-Safe Mechanism:** If the database connection drops or fails, the API will not crash. Instead, it securely responds with a `503 Service Unavailable` error to maintain overall system integrity.

### Implementation Details
- **Security First:** The backend is built using PHP and PDO. It strictly uses parameterized queries to neutralize any risk of SQL injection attacks.
- **Data Integrity:** The database schema is designed with strict `UNIQUE` and `NOT NULL` constraints to guarantee that the stored data is always accurate and reliable.

---

## 📸 Project Screenshots

To visually demonstrate the complete functionality, error handling, and architecture of the system, a comprehensive set of testing screenshots has been provided. 

Please navigate to the `screenshots/` directory in this repository to view detailed visual logs, which include:
- Successful execution of all CRUD operations (POST, GET, PUT, DELETE).
- Real-time database state verifications.
- The Resilience Protocol in action (securely handling 503 Service Unavailable errors).
- API routing and terminal server logs.