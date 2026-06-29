# DecodeLabs API Documentation

## 1. Gateway Anatomy
- Base URL: `http://localhost:8000/index.php`
- [cite_start]Protocol: RESTful (Nouns as resources) [cite: 152]

## 2. Endpoints
| Method | Endpoint | Description | Status Codes |
| :--- | :--- | :--- | :--- |
| GET | `/users` | Fetch persistent data | 200, 503 |
| POST | `/users` | Create new entry | 201, 400 |

## 3. Resilience Protocol
- The system employs a **Circuit Breaker** pattern via PDO exception handling.
- [cite_start]If the Database connection fails, the API responds with `503 Service Unavailable` to maintain system integrity[cite: 224].