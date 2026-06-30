# DecodeLabs API Documentation

## 1. Gateway Anatomy
- Base URL: `http://localhost:8000/index.php`
- [cite_start]Protocol: RESTful (Nouns as resources) [cite: 152]

## 2. Endpoints
| Method | Endpoint | Description | Status Codes |
| :--- | :--- | :--- | :--- |
| GET | `/users` | Fetch persistent data | 200, 503 |
| POST | `/users` | Create new entry | 201, 400 |
| PUT | `/users` | Update existing data | 200, 400 |
| DELETE | `/users` | Remove data entry | 200, 400 |

## 3. Resilience Protocol
- The system employs a **Circuit Breaker** pattern via PDO exception handling.
- If the Database connection fails, the API responds with `503 Service Unavailable` to maintain system integrity.

## 4. Implementation Details
- [cite_start]Backend built with PHP and PDO for secure, parameterized queries[cite: 162].
- [cite_start]System enforces strict data integrity using `UNIQUE` and `NOT NULL` constraints [cite: 134-137].