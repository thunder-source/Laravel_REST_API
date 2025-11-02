# Laravel Product API - Setup Guide

## Prerequisites Installation

Before you can run this Laravel project, you need to install the following:

### 1. Install PHP (8.1 or higher)

**Windows:**
- Download PHP from: https://windows.php.net/download/
- Or use XAMPP/WAMP which includes PHP
- Add PHP to your system PATH

**Verify installation:**
```bash
php -v
```

### 2. Install Composer

**Windows:**
- Download from: https://getcomposer.org/download/
- Run the installer
- Restart your terminal

**Verify installation:**
```bash
composer --version
```

### 3. Install Database

**Option A: MySQL**
- Download from: https://dev.mysql.com/downloads/installer/
- Or install via XAMPP/WAMP
- Default port: 3306

**Option B: PostgreSQL**
- Download from: https://www.postgresql.org/download/
- Default port: 5432

## Project Setup Steps

### Step 1: Install Laravel Dependencies

Open terminal in the project directory and run:

```bash
composer install
```

This will install all required PHP packages defined in `composer.json`.

### Step 2: Create Environment File

```bash
copy .env.example .env
```

### Step 3: Generate Application Key

```bash
php artisan key:generate
```

This creates a unique encryption key for your application.

### Step 4: Configure Database

1. Create a new database named `product_api` in MySQL/PostgreSQL

**MySQL:**
```sql
CREATE DATABASE product_api;
```

**PostgreSQL:**
```sql
CREATE DATABASE product_api;
```

2. Edit `.env` file with your database credentials:

**For MySQL:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=product_api
DB_USERNAME=root
DB_PASSWORD=your_password_here
```

**For PostgreSQL:**
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=product_api
DB_USERNAME=postgres
DB_PASSWORD=your_password_here
```

### Step 5: Run Database Migrations

```bash
php artisan migrate
```

This creates the `products` table in your database.

### Step 6: Start the Development Server

```bash
php artisan serve
```

The API will be available at: `http://localhost:8000`

## Testing the API

### Using cURL

**Get all products:**
```bash
curl http://localhost:8000/api/products
```

**Create a product:**
```bash
curl -X POST http://localhost:8000/api/products ^
  -H "Content-Type: application/json" ^
  -d "{\"name\":\"Test Product\",\"description\":\"A test product\",\"price\":99.99,\"quantity\":10,\"sku\":\"TEST-001\"}"
```

### Using Postman

1. Download Postman: https://www.postman.com/downloads/
2. Create a new request
3. Set method to POST
4. URL: `http://localhost:8000/api/products`
5. Headers: `Content-Type: application/json`
6. Body (raw JSON):
```json
{
  "name": "Laptop",
  "description": "High-performance laptop",
  "price": 999.99,
  "quantity": 50,
  "sku": "LAP-001"
}
```

## Common Issues and Solutions

### Issue: "composer: command not found"
**Solution:** Install Composer from https://getcomposer.org/

### Issue: "php: command not found"
**Solution:** Install PHP and add it to your system PATH

### Issue: Database connection error
**Solution:** 
- Check if MySQL/PostgreSQL is running
- Verify credentials in `.env` file
- Ensure database `product_api` exists

### Issue: "Class not found" errors
**Solution:** Run `composer dump-autoload`

### Issue: Migration errors
**Solution:** 
- Check database connection
- Run `php artisan migrate:fresh` to reset

### Issue: Port 8000 already in use
**Solution:** Use a different port:
```bash
php artisan serve --port=8001
```

## Useful Artisan Commands

```bash
# View all routes
php artisan route:list

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Reset database
php artisan migrate:fresh

# Create new migration
php artisan make:migration create_table_name

# Create new controller
php artisan make:controller ControllerName

# Create new model
php artisan make:model ModelName
```

## Next Steps

1. Test all CRUD endpoints
2. Add authentication (Laravel Sanctum)
3. Add pagination to product listing
4. Add search and filtering
5. Write unit tests
6. Deploy to production

## Additional Resources

- Laravel Documentation: https://laravel.com/docs
- Laravel API Resources: https://laravel.com/docs/eloquent-resources
- REST API Best Practices: https://restfulapi.net/

## Support

If you encounter any issues, please check:
1. PHP version (must be 8.1+)
2. Composer is installed
3. Database is running
4. `.env` file is configured correctly
5. Migrations have been run
