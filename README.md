This repository contains APIs developed for the candidate assessment by **Phantasm Solutions Ltd Pvt.**  

The APIs include:

1. **JWT Authentication** for user signup and login  
2. **Add Product to Cart** endpoint

---

## **1. Setup Instructions**

### **Clone the Repository**
```bash
git clone https://github.com/Phantasm-Solutions-Ltd-Pvt/php-f2f-for-candidate.git
cd php-f2f-for-candidate
Install Dependencies
composer install
Configure Environment
Copy .env.example to .env:

change the database credentials 

cp .env.example .env
Generate the application key:


php artisan key:generate
Run database migrations:

php artisan migrate
Generate JWT secret key:


php artisan jwt:secret
Copy the generated key and add it to .env:

env
JWT_SECRET=your_generated_jwt_key
Add a random 64-character API key to .env:

env
API_KEY=f7c9a84e3b1d42fa6c5e97d3ab82f4e0c1b7d96f54a3e29cd8f2b617a4c0e9d1
Run the Server
php artisan serve
The server will run at: http://127.0.0.1:8000

2. API Endpoints
Signup
POST http://127.0.0.1:8000/api/signup?name=YourName&email=youremail@example.com&password=YourPassword
Replace with your own credentials

Login
POST http://127.0.0.1:8000/api/login?email=youremail@example.com&password=YourPassword&apikey=your_api_key
Use the API_KEY from .env

Response will return a JWT token. Copy it for authentication

Add Product to Cart
POST http://127.0.0.1:8000/api/add-to-cart?product_id=1&quantity=10
In Postman, set Authorization → Bearer Token and paste the JWT token from login

This endpoint requires authentication

3. Notes
Replace product_id and quantity with desired values

Make sure to use your own credentials for signup and login

The API_KEY must match the value in your .env file
