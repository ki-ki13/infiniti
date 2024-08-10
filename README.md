# Infiniti Inventory Management System

## Overview
This system manages the inbound and outbound processes of inventory items using Laravel, MySQL, and Swagger. It integrates with an external API for certain operations and provides its own API for data management.

## Database Structure
Database Name: infiniti

Table: stock
- id (primary key)
- barcode (string)
- item_name (string)
- sku (string)
- qty (integer)
- storage_location (string)
- status (enum: 'inbound'/'outbound')

## API Documentation
API documentation can be accessed at: `localhost/infiniti/documentation`

Authentication: 
- Username and password are required for API access
- Using the same credentials as provided for the quiz API

## System Flow

### Inbound Process
1. Scan barcode
2. Request inbound API to get storage location
3. Save the data using the create API

### Outbound Process
1. Display data using the get API
2. Request outbound API for a specific item by clicking the outbound button
3. Update the data using the update API

## API Endpoints

### 1. Get Parts Detail
- **Endpoint:** `/api/parts/getDetail`
- **Method:** POST
- **Description:** Retrieves detail of a part based on barcode
- **Request Body:**
  ```json
  {
    "username": "string",
    "password": "string",
    "barcode": "string"
  }
  ```
  Response: Part details

### 2. Send Outbound Task

- **Endpoint**: /api/robots/sendOutboundTask
- **Method**: POST
- **Description**: Initiates an outbound task for a specific storage location
- **Request Body**:
```json
{
  "username": "string",
  "password": "string",
  "storage_location": "string"
}
```

### 3. Create Stock Item

- **Endpoint**: /api/stock
- **Method**: POST
- **Description**: Creates a new stock item
- **Request Body**: Stock item details
- **Response**: Created stock item

### 4. Update Stock Item

- **Endpoint**: /api/stock/{id}
- **Method**: PUT
- **Description**: Updates an existing stock item
- **Request Body**: Updated stock item details
- **Response**: Updated stock item

### 5. Get All Stock Items

- **Endpoint**: /api/stock
- **Method**: GET
- **Description**: Retrieves all stock items
- **Response**: List of all stock items

## Frontend Integration

The frontend is integrated with both the external quiz API and the custom Laravel API.
It handles user interactions for inbound and outbound processes.
Communicates with the backend to perform CRUD operations on the stock items.

## Setup and Installation

- Clone the Laravel project
- Set up the MySQL database named 'infiniti'
- Run database migrations
- Install and configure Swagger for API documentation
- Ensure proper configuration for connecting to the external quiz API

## Testing
To test the API documentation:

Access localhost/infiniti/documentation
Use the provided username and password (same as quiz API credentials)

## Security Considerations

API credentials are handled securely
CORS issues are managed through proper backend configuration
Data validation is implemented for all API endpoints

## Development Progress
- Make frontend
- Integrate frontend and API from quiz
- Initiate Laravel project
- Initiate db
- Migrate db
- Initiate swagger
- Make API to save data
- Make API to insert data
- Make API to get all the data
- Integrate frontend and my own API

