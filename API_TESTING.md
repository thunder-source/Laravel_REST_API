# API Testing Guide

Complete guide for testing the Product REST API endpoints.

## Base URL
```
http://localhost:8000/api
```

## Test Data

Use this sample product data for testing:

```json
{
  "name": "Wireless Mouse",
  "description": "Ergonomic wireless mouse with USB receiver",
  "price": 29.99,
  "quantity": 100,
  "sku": "MOUSE-001"
}
```

## 1. CREATE Product (POST)

### Request
```bash
curl -X POST http://localhost:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Wireless Mouse",
    "description": "Ergonomic wireless mouse with USB receiver",
    "price": 29.99,
    "quantity": 100,
    "sku": "MOUSE-001"
  }'
```

### Expected Response (201 Created)
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Wireless Mouse",
    "description": "Ergonomic wireless mouse with USB receiver",
    "price": "29.99",
    "quantity": 100,
    "sku": "MOUSE-001",
    "created_at": "2024-01-01T12:00:00.000000Z",
    "updated_at": "2024-01-01T12:00:00.000000Z"
  },
  "message": "Product created successfully"
}
```

### Test Cases

#### Valid Product
```json
{
  "name": "Keyboard",
  "description": "Mechanical keyboard",
  "price": 79.99,
  "quantity": 50,
  "sku": "KEY-001"
}
```
**Expected:** 201 Created

#### Missing Required Field
```json
{
  "description": "Test product",
  "price": 10.00,
  "quantity": 5
}
```
**Expected:** 422 Validation Error

#### Duplicate SKU
```json
{
  "name": "Another Mouse",
  "price": 25.00,
  "quantity": 10,
  "sku": "MOUSE-001"
}
```
**Expected:** 422 Validation Error

#### Negative Price
```json
{
  "name": "Invalid Product",
  "price": -10.00,
  "quantity": 5,
  "sku": "INV-001"
}
```
**Expected:** 422 Validation Error

## 2. READ All Products (GET)

### Request
```bash
curl -X GET http://localhost:8000/api/products
```

### Expected Response (200 OK)
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Wireless Mouse",
      "description": "Ergonomic wireless mouse with USB receiver",
      "price": "29.99",
      "quantity": 100,
      "sku": "MOUSE-001",
      "created_at": "2024-01-01T12:00:00.000000Z",
      "updated_at": "2024-01-01T12:00:00.000000Z"
    }
  ],
  "message": "Products retrieved successfully"
}
```

## 3. READ Single Product (GET)

### Request
```bash
curl -X GET http://localhost:8000/api/products/1
```

### Expected Response (200 OK)
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Wireless Mouse",
    "description": "Ergonomic wireless mouse with USB receiver",
    "price": "29.99",
    "quantity": 100,
    "sku": "MOUSE-001",
    "created_at": "2024-01-01T12:00:00.000000Z",
    "updated_at": "2024-01-01T12:00:00.000000Z"
  },
  "message": "Product retrieved successfully"
}
```

### Test Cases

#### Valid Product ID
```bash
curl -X GET http://localhost:8000/api/products/1
```
**Expected:** 200 OK

#### Non-existent Product ID
```bash
curl -X GET http://localhost:8000/api/products/999
```
**Expected:** 404 Not Found
```json
{
  "success": false,
  "message": "Product not found",
  "error": "Product with ID 999 does not exist"
}
```

## 4. UPDATE Product (PUT)

### Request
```bash
curl -X PUT http://localhost:8000/api/products/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Wireless Mouse",
    "price": 24.99,
    "quantity": 150
  }'
```

### Expected Response (200 OK)
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Updated Wireless Mouse",
    "description": "Ergonomic wireless mouse with USB receiver",
    "price": "24.99",
    "quantity": 150,
    "sku": "MOUSE-001",
    "created_at": "2024-01-01T12:00:00.000000Z",
    "updated_at": "2024-01-01T12:05:00.000000Z"
  },
  "message": "Product updated successfully"
}
```

### Test Cases

#### Update Single Field
```json
{
  "price": 19.99
}
```
**Expected:** 200 OK

#### Update Multiple Fields
```json
{
  "name": "Premium Mouse",
  "price": 39.99,
  "quantity": 75
}
```
**Expected:** 200 OK

#### Update with Invalid Data
```json
{
  "price": -5.00
}
```
**Expected:** 422 Validation Error

#### Update Non-existent Product
```bash
curl -X PUT http://localhost:8000/api/products/999 \
  -H "Content-Type: application/json" \
  -d '{"name": "Test"}'
```
**Expected:** 404 Not Found

## 5. DELETE Product (DELETE)

### Request
```bash
curl -X DELETE http://localhost:8000/api/products/1
```

### Expected Response (200 OK)
```json
{
  "success": true,
  "message": "Product deleted successfully"
}
```

### Test Cases

#### Delete Existing Product
```bash
curl -X DELETE http://localhost:8000/api/products/1
```
**Expected:** 200 OK

#### Delete Non-existent Product
```bash
curl -X DELETE http://localhost:8000/api/products/999
```
**Expected:** 404 Not Found

## Postman Collection

### Import these requests into Postman:

1. **GET All Products**
   - Method: GET
   - URL: `{{base_url}}/products`

2. **GET Single Product**
   - Method: GET
   - URL: `{{base_url}}/products/1`

3. **POST Create Product**
   - Method: POST
   - URL: `{{base_url}}/products`
   - Body: raw JSON
   ```json
   {
     "name": "Test Product",
     "description": "Test Description",
     "price": 99.99,
     "quantity": 10,
     "sku": "TEST-001"
   }
   ```

4. **PUT Update Product**
   - Method: PUT
   - URL: `{{base_url}}/products/1`
   - Body: raw JSON
   ```json
   {
     "name": "Updated Product",
     "price": 89.99
   }
   ```

5. **DELETE Product**
   - Method: DELETE
   - URL: `{{base_url}}/products/1`

### Postman Environment Variables
```
base_url: http://localhost:8000/api
```

## Testing Checklist

- [ ] Create product with valid data
- [ ] Create product with missing required fields
- [ ] Create product with duplicate SKU
- [ ] Create product with negative price
- [ ] Get all products (empty list)
- [ ] Get all products (with data)
- [ ] Get single product by valid ID
- [ ] Get single product by invalid ID
- [ ] Update product with valid data
- [ ] Update product with invalid data
- [ ] Update non-existent product
- [ ] Delete existing product
- [ ] Delete non-existent product
- [ ] Verify product is deleted (GET after DELETE)

## Validation Error Examples

### Missing Name
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "name": ["The name field is required."]
  }
}
```

### Invalid Price
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "price": ["The price must be at least 0."]
  }
}
```

### Duplicate SKU
```json
{
  "success": false,
  "message": "Validation error",
  "errors": {
    "sku": ["The sku has already been taken."]
  }
}
```

## HTTP Status Codes

- **200 OK**: Successful GET, PUT, DELETE
- **201 Created**: Successful POST
- **404 Not Found**: Resource doesn't exist
- **422 Unprocessable Entity**: Validation error
- **500 Internal Server Error**: Server error

## Tips

1. Always set `Content-Type: application/json` header for POST/PUT requests
2. Check response status codes
3. Verify response structure matches documentation
4. Test edge cases (empty strings, very large numbers, etc.)
5. Test with both MySQL and PostgreSQL if possible
