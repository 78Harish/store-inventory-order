# Store Inventory & Order System

A Laravel API for managing customers, products, inventory, and orders.

## Features

*   Create orders
*   Automatically create/reuse customers by email
*   Calculate subtotal, tax, and grand total
*   Validate product availability and stock
*   Atomically deduct stock to prevent overselling
*   Roll back failed orders
*   Retrieve customer order history
*   Retrieve low-stock products
*   Queue order confirmation processing after transaction commit
*   Log order confirmation processing
*   Feature tests for the main order and inventory scenarios

## Requirements

*   PHP 8.3+
*   Composer
*   Git
*   SQLite

### Check installed versions:

*   `php -v`
*   `composer -V`
*   `git --version`

## 1. Clone the Repository

```bash
git clone <repository-url>
cd store-inventory-order
```

Replace `<repository-url>` with the actual repository URL.

## 2. Install Dependencies

```bash
composer install
```

This installs all PHP dependencies defined in `composer.json`.

## 3. Configure Environment

*   **Windows PowerShell:**

    ```powershell
    Copy-Item .env.example .env
    ```
*   **Linux/macOS:**

    ```bash
    cp .env.example .env
    ```

*   Generate the Laravel application key:

    ```bash
    php artisan key:generate
    ```

## 4. Configure SQLite

*   Open `.env` and configure:

    ```
    DB_CONNECTION=sqlite
    QUEUE_CONNECTION=database
    ```
*   Create the SQLite database file if it does not already exist:

    *   **Windows PowerShell:**

        ```powershell
        New-Item database/database.sqlite -ItemType File
        ```

    *   If the file already exists, skip this command.

## 5. Run Database Migrations

```bash
php artisan migrate
```

This creates the required database tables, including the tables required by the application and database queue.

## 6. Seed Sample Products

```bash
php artisan db:seed --class=ProductSeeder
```

To completely reset the database and seed it again:

```bash
php artisan migrate:fresh --seed
```

`migrate:fresh` deletes the existing tables and data.

## Running the Application

Start the Laravel development server:

```bash
php artisan serve
```

The API will normally be available at: `http://127.0.0.1:8000`

Keep this terminal running.

## Running the Queue

Open a second terminal in the project directory.

Start the queue worker:

```bash
php artisan queue:work
```

The application uses: `QUEUE_CONNECTION=database`

The `SendOrderConfirmation` job is dispatched after the order transaction commits.

The job currently logs the order confirmation instead of sending an actual email.

## API Endpoints

### 1. Create Order

*   **Request:** `POST /api/order`
*   **JSON Body:**

    ```json
    {
        "customer_name": "John",
        "email": "john@example.com",
        "items": [
            {
                "product_id": 1,
                "quantity": 2
            }
        ]
    }
    ```

*   **PowerShell cURL:**

    ```powershell
    curl.exe -X POST "http://127.0.0.1:8000/api/order" `
      -H "Accept: application/json" `
      -H "Content-Type: application/json" `
      -d '{"customer_name":"John","email":"john@example.com","items":[{"product_id":1,"quantity":2}]}'
    ```

*   **Successful order creation returns:** `201 Created`

### 2. Customer List

*   **Request:** `GET /api/customer_list`
*   **PowerShell cURL:**

    ```powershell
    curl.exe "http://127.0.0.1:8000/api/customer_list" `
      -H "Accept: application/json"
    ```

*   Returns the customers stored in the database.

### 3. Low Stock Products

*   **Request:** `GET /api/low_stock_products`
*   **PowerShell cURL:**

    ```powershell
    curl.exe "http://127.0.0.1:8000/api/low_stock_products" `
      -H "Accept: application/json"
    ```

*   Returns products where `product_stock_on_hand <= product_threshold`

### 4. Customer Order History

*   **Request:** `GET /api/order_history?email=john@example.com`
*   **PowerShell cURL:**

    ```powershell
    curl.exe "http://127.0.0.1:8000/api/order_history?email=john%40example.com" `
      -H "Accept: application/json"
    ```

*   The endpoint reads the email from the query parameter.
*   Finds the customer using the email.
*   Returns the customer's orders.

#### Responses

*   `200 OK`: Customer exists.
*   `400 Bad Request`: Email was not provided.
*   `404 Not Found`: Customer was not found.

## Order Processing

Order creation is wrapped inside a database transaction.

The processing flow is:

1.  Request ↓
2.  Find/Create Customer ↓
3.  Find Product ↓
4.  Atomically Deduct Stock ↓
5.  Calculate Subtotal & Tax ↓
6.  Create Order ↓
7.  Create Order Items ↓
8.  Commit Transaction ↓
9.  Dispatch Confirmation Job ↓

**Customer Creation:**

Customers are identified by email.

If the email already exists, the existing customer is reused.

If the email does not exist, a new customer is created.

```php
$customer = Customer::firstOrCreate(
    ['email' => $data['email']],
    ['customer_name' => $data['customer_name']]
);
```

## Stock Protection

Stock is deducted using a conditional atomic database update:

`product_stock_on_hand >= requested_quantity`

This prevents the application from deducting stock when there is not enough inventory.

## Order Calculations

*   `line subtotal = product price × quantity`
*   `line tax = line subtotal × tax percentage / 100`
*   `line total = line subtotal + line tax`
*   `order subtotal = sum of all line subtotals`
*   `order tax = sum of all line taxes`
*   `grand total = order subtotal + order tax`

## Queue Processing

The order confirmation job is dispatched using:

```php
DB::afterCommit(function () use ($ordered_details) {
    SendOrderConfirmation::dispatch($ordered_details);
});
```

This ensures the job is dispatched only after the order transaction successfully commits.

Start the worker with:

```bash
php artisan queue:work
```

The job currently logs:

`Order confirmation sent`

No external mail service is required.

## Testing

Run the complete test suite:

```bash
php artisan test
```

Run a specific test:

```bash
php artisan test --filter=test_order_can_be_created
```

Example:

```bash
php artisan test --filter=test_order_fails_when_stock_is_insufficient
```

## Useful Artisan Commands

*   `php artisan route:list`
*   `php artisan migrate`
*   `php artisan migrate:fresh`
*   `php artisan db:seed --class=ProductSeeder`
*   `php artisan serve`
*   `php artisan queue:work`
*   `php artisan test`
*   `php artisan tinker`

## Troubleshooting

*   **SQLite Database Does Not Exist:**

    ```bash
    New-Item database/database.sqlite -ItemType File
    ```

    Then run:

    ```bash
    php artisan migrate
    ```
*   **Products Are Missing:**

    Run:

    ```bash
    php artisan db:seed --class=ProductSeeder
    ```

    Or reset and seed:

    ```bash
    php artisan migrate:fresh --seed
    ```
*   **Queue Jobs Are Not Processing:**

    Check `.env`:

    ```
    QUEUE_CONNECTION=database
    ```

    Run:

    ```bash
    php artisan migrate
    ```

    Then start:

    ```bash
    php artisan queue:work
    ```
*   **Changes Are Not Reflected:**

    Stop the Laravel server:

    ```bash
    Ctrl + C
    ```

    Then restart:

    ```bash
    php artisan serve
    ```
*   **Project Structure**

    ```
    store-inventory-order/
    │
    ├── app/
    │   ├── Actions/
    │   │   └── CreateOrder.php
    │   │
    │   ├── Http/
    │   │   └── Controllers/
    │   │
    │   ├── Jobs/
    │   │   └── SendOrderConfirmation.php
    │   │
    │   └── Models/
    │
    ├── database/
    │   ├── migrations/
    │   ├── seeders/
    │   │   └── ProductSeeder.php
    │   └── database.sqlite
    │
    ├── routes/
    │   └── api.php
    │
    ├── tests/
    │   └── Feature/
    │       └── CreateOrderTest.php
    │
    ├── .env.example
    ├── composer.json
    └── README.md
    ```

## Quick Start

1.  `git clone <repository-url>`
2.  `cd store-inventory-order`
3.  `composer install`
4.  Windows PowerShell:

    ```powershell
    Copy-Item .env.example .env
    ```

    ```powershell
    New-Item database/database.sqlite -ItemType File
    ```
5.  Then:

    ```bash
    php artisan key:generate
    php artisan migrate
    php artisan db:seed --class=ProductSeeder
    php artisan serve
    ```

6.  Open another terminal:

    ```bash
    php artisan queue:work
    ```

7.  Finally, verify the project:

    ```bash
    php artisan test