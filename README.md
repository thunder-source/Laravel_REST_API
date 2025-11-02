# Laravel Product REST API

A RESTful API built with Laravel for managing products with full CRUD operations, validation, and error handling.

## Features

- ✅ Complete CRUD operations for Product model
- ✅ Input validation with detailed error messages
- ✅ Proper error handling and HTTP status codes
- ✅ MySQL and PostgreSQL support
- ✅ RESTful API design
- ✅ JSON responses

## Requirements

- PHP >= 8.1
- Composer
- MySQL 5.7+ or PostgreSQL 12+
- Laravel 10.x

## Installation

### 1. Install Dependencies

```bash
composer install
```

### 2. Environment Configuration

Copy the example environment file:

```bash
copy .env.example .env
```

### 3. Configure Database

Edit `.env` file with your database credentials:

**For MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_api
DB_USERNAME=root
DB_PASSWORD=your_password
```

**For PostgreSQL:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=product_api
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Create Database

Create a database named `product_api` in your MySQL/PostgreSQL server.

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Start Development Server

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Endpoints

### Base URL
```
http://localhost:8000/api
```

### Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/products` | Get all products |
| GET | `/api/products/{id}` | Get a specific product |
| POST | `/api/products` | Create a new product |
| PUT | `/api/products/{id}` | Update a product |
| DELETE | `/api/products/{id}` | Delete a product |

### Product Schema

```json
{
  "id": "integer",
  "name": "string (required, max: 255)",
  "description": "string (optional)",
  "price": "decimal (required, min: 0)",
  "quantity": "integer (required, min: 0)",
  "sku": "string (required, unique, max: 100)",
  "created_at": "timestamp",
  "updated_at": "timestamp"
}
```

## API Usage Examples

### 1. Get All Products

```bash
curl -X GET http://localhost:8000/api/products
```

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Product Name",
      "description": "Product Description",
      "price": "99.99",
      "quantity": 10,
      "sku": "PROD-001",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ],
  "message": "Products retrieved successfully"
}
```

### 2. Get Single Product

```bash
curl -X GET http://localhost:8000/api/products/1
```

### 3. Create Product

```bash
curl -X POST http://localhost:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Laptop",
    "description": "High-performance laptop",
    "price": 999.99,
    "quantity": 50,
    "sku": "LAP-001"
  }'
```

**Response:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Laptop",
    "description": "High-performance laptop",
    "price": "999.99",
    "quantity": 50,
    "sku": "LAP-001",
    "created_at": "2024-01-01T00:00:00.000000Z",
    "updated_at": "2024-01-01T00:00:00.000000Z"
  },
  "message": "Product created successfully"
}
```

### 4. Update Product

```bash
curl -X PUT http://localhost:8000/api/products/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Laptop",
    "price": 899.99,
    "quantity": 45
  }'
```

### 5. Delete Product

```bash
curl -X DELETE http://localhost:8000/api/products/1
```

**Response:**
```json
{
  "success": true,
  "message": "Product deleted successfully"
}
```

## Validation Rules

### Create Product (POST)
- `name`: required, string, max 255 characters
- `description`: optional, string
- `price`: required, numeric, minimum 0
- `quantity`: required, integer, minimum 0
- `sku`: required, string, unique, max 100 characters

### Update Product (PUT)
- All fields are optional
- Same validation rules apply when field is provided
- `sku` must be unique (excluding current product)

## Error Responses

### Validation Error (422)
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "name": ["The name field is required."],
    "price": ["The price must be at least 0."]
  }
}
```

### Not Found (404)
```json
{
  "success": false,
  "message": "Product not found",
  "error": "Product with ID 999 does not exist"
}
```

### Server Error (500)
```json
{
  "success": false,
  "message": "Error creating product",
  "error": "Detailed error message"
}
```

## Testing with Postman

1. Import the API endpoints into Postman
2. Set base URL: `http://localhost:8000/api`
3. Set headers: `Content-Type: application/json`
4. Test each endpoint with sample data

## Project Structure

```
Laravel_REST_API/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── ProductController.php
│   ├── Models/
│   │   └── Product.php
│   └── Providers/
│       └── AppServiceProvider.php
├── database/
│   └── migrations/
│       └── 2024_01_01_000000_create_products_table.php
├── routes/
│   ├── api.php
│   ├── web.php
│   └── console.php
├── config/
│   ├── app.php
│   └── database.php
├── .env.example
├── composer.json
└── README.md
```

## Troubleshooting

### Database Connection Error
- Verify database credentials in `.env`
- Ensure database server is running
- Check if database exists

### Migration Error
- Run `php artisan migrate:fresh` to reset migrations
- Check database user permissions

### 404 on API Routes
- Clear route cache: `php artisan route:clear`
- Verify routes: `php artisan route:list`

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues or questions, please create an issue in the repository.
