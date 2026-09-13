<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Store Billing — New Order</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #fff;
            font-family: Arial, sans-serif;
            color: #26364d;
        }

        .container {
            width: 930px;
            max-width: calc(100% - 40px);
            margin: 17px auto;
        }

        /* HEADER */

        .header {
            height: 53px;
            background: #1e2a3d;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 22px;
        }

        .header-title {
            font-size: 18px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .header-title span {
            margin: 0 10px;
        }

        .header-note {
            font-size: 10px;
            color: #8491a5;
        }

        /* MAIN */

        .main {
            padding: 30px 22px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 9px;
        }

        /* CUSTOMER */

        .customer {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
            margin-bottom: 30px;
        }

        .field label {
            display: block;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        input,
        select {
            width: 100%;
            height: 36px;
            border: 2px solid #a4b3c8;
            padding: 0 10px;
            color: #26364d;
            background: #fff;
            font-size: 12px;
            outline: none;
        }

        input::placeholder {
            color: #a9b7c9;
        }

        input:focus,
        select:focus {
            border-color: #367dbb;
        }

        /* PRODUCT + LOW STOCK */

        .products-area {
            display: grid;
            grid-template-columns: 580px 1fr;
            gap: 22px;
            align-items: start;
        }

        .product-table {
            border: 2px solid #a4b3c8;
        }

        .product-header,
        .product-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.25fr;
            min-height: 33px;
            align-items: center;
        }

        .product-header {
            background: #dfe7f1;
            font-weight: bold;
            font-size: 12px;
        }

        .product-row {
            border-top: 2px solid #a4b3c8;
            font-size: 12px;
        }

        .product-header > div,
        .product-row > div {
            padding: 7px 9px;
        }

        .product-row input,
        .product-row select {
            height: 27px;
            border: 0;
            padding: 0;
            font-size: 12px;
        }

        .line-total {
            font-weight: normal;
        }

        .add-product-row {
            height: 32px;
            border-top: 2px solid #a4b3c8;
            display: flex;
            align-items: center;
            padding: 0 9px;
            color: #9aacbf;
            font-size: 11px;
            cursor: pointer;
        }

        .add-button-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 9px;
        }

        .add-button {
            width: 140px;
            height: 33px;
            background: #367dbb;
            color: #fff;
            border: 0;
            font-weight: bold;
            font-size: 13px;
            cursor: pointer;
        }

        .remove-button {
            width: auto;
            height: 24px;
            padding: 0 7px;
            background: #b42318;
            color: white;
            border: 0;
            cursor: pointer;
            font-size: 10px;
        }

        /* LOW STOCK */

        .low-stock {
            border: 2px solid #ef8b00;
            background: #fffaf0;
            min-height: 207px;
            padding: 12px;
        }

        .low-stock-title {
            color: #a95d16;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 13px;
        }

        .low-stock-list {
            margin: 0;
            padding-left: 14px;
            color: #8a562b;
            font-size: 11px;
            line-height: 2.1;
        }

        /* PAYMENT */

        .payment-area {
            display: grid;
            grid-template-columns: 430px 1fr;
            gap: 27px;
            margin-top: 18px;
            align-items: start;
        }

        .payment-box {
            border: 2px solid #a4b3c8;
            background: #edf2f7;
            padding: 10px 13px 8px;
        }

        .payment-row {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .payment-row strong {
            font-size: 12px;
        }

        .amount-section {
            border-top: 2px dashed #a4b3c8;
            padding-top: 7px;
            margin-top: 3px;
        }

        .amount-section label {
            display: block;
            font-size: 11px;
            font-weight: bold;
            margin-bottom: 3px;
        }

        .amount-section input {
            height: 35px;
            background: #fff;
        }

        .balance {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 13px;
            font-size: 12px;
            font-weight: bold;
        }

        .balance-value {
            font-size: 10px;
            font-weight: normal;
        }

        /* BILL BUTTON */

        .bill-area {
            padding-top: 0;
        }

        .bill-button {
            width: 187px;
            height: 42px;
            background: #16823b;
            color: white;
            border: 0;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
        }

        .bill-note {
            font-size: 10px;
            line-height: 1.5;
            margin-top: 8px;
            color: #53647a;
        }

        /* MESSAGE */

        .message {
            display: none;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 12px;
        }

        .message.success {
            display: block;
            background: #e8f5e9;
            color: #1b5e20;
        }

        .message.error {
            display: block;
            background: #ffebee;
            color: #b71c1c;
        }

        @media (max-width: 850px) {
            .container {
                width: 100%;
            }

            .customer,
            .products-area,
            .payment-area {
                grid-template-columns: 1fr;
            }

            .products-area {
                gap: 20px;
            }

            .payment-area {
                gap: 20px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <header class="header">
        <div class="header-title">
            Store Billing <span>—</span> New Order
        </div>
    </header>


    <main class="main">

        <div id="message" class="message"></div>


        <!-- CUSTOMER -->

        <div class="section-title">Customer</div>

        <div class="customer">

            <div class="field">
                <label for="customerEmail">Email</label>

                <input
                    type="email"
                    id="customerEmail"
                    placeholder="e.g. thomas@example.com"
                    required
                >
            </div>

            <div class="field">
                <label for="customerName">Name</label>

                <input
                    type="text"
                    id="customerName"
                    required
                >
            </div>

        </div>


        <!-- PRODUCTS -->

        <div class="products-area">

            <div>

                <div class="section-title">Products</div>

                <div class="product-table">

                    <div class="product-header">
                        <div>Product</div>
                        <div>Qty</div>
                        <div>Price</div>
                        <div>Line Total</div>
                    </div>

                    <div id="orderItems"></div>

                    <div
                        class="add-product-row"
                        onclick="addOrderItem()"
                    >
                        + dropdown to add product row
                    </div>

                </div>

                <div class="add-button-wrapper">

                    <button
                        type="button"
                        class="add-button"
                        onclick="addOrderItem()"
                    >
                        + Add Product
                    </button>

                </div>

            </div>


            <!-- LOW STOCK -->

            <div class="low-stock">

                <div class="low-stock-title">
                    ⚠ Low Stock Alert
                </div>

                <ul
                    id="lowStockList"
                    class="low-stock-list"
                >
                    <li>Loading...</li>
                </ul>

            </div>

        </div>


        <!-- PAYMENT -->

        <div class="payment-area">

            <div>

                <div class="section-title">Payment</div>

                <div class="payment-box">

                    <div class="payment-row">
                        <span>Subtotal</span>
                        <strong id="subtotal">₹0.00</strong>
                    </div>

                    <div class="payment-row">
                        <span>Tax</span>
                        <strong id="tax">₹0.00</strong>
                    </div>

                    <div class="payment-row">
                        <span>Grand Total</span>
                        <strong id="grandTotal">₹0.00</strong>
                    </div>

                    <div class="amount-section" style="display: none;">

                        <label for="amountGiven">
                            Amount Given by Customer
                        </label>

                        <input
                            type="number"
                            id="amountGiven"
                            placeholder="₹250"
                            min="0"
                            step="0.01"
                            oninput="calculateBalance()"
                        >

                    </div>

                    <div class="balance" style="display: none;">

                        <span>Balance to Return:</span>

                        <span
                            id="balance"
                            class="balance-value"
                        >
                            ₹0.00
                        </span>

                    </div>

                </div>

            </div>


            <!-- GENERATE BILL -->

            <div class="bill-area">

                <button
                    type="button"
                    class="bill-button"
                    onclick="createOrder()"
                >
                    Generate Order
                </button>

                <div class="bill-note">
                    <!-- → shows bill on page +<br>
                    emails PDF to customer -->
                </div>

            </div>

        </div>

    </main>

</div>


<script>

    let products = [];
    let itemCounter = 0;


    document.addEventListener('DOMContentLoaded', function () {
        loadProducts();
        loadLowStockProducts();
        addOrderItem();
    });


    /* =========================
       MESSAGE
    ========================= */

    function showMessage(message, type) {

        const element = document.getElementById('message');

        element.textContent = message;
        element.className = 'message ' + type;
    }


    /* =========================
       PRODUCTS
    ========================= */

    function loadProducts() {

        fetch('/api/products_list', {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {

            products = Array.isArray(data) ? data : [];

            refreshProductSelects();

        })
        .catch(error => {

            console.error(error);

            showMessage(
                'Unable to load products.',
                'error'
            );

        });

    }


    function getProductOptions() {

        return products.map(product => `
            <option value="${product.product_id}">
                ${product.product_name}
            </option>
        `).join('');

    }


    function refreshProductSelects() {

        document
            .querySelectorAll('.product-select')
            .forEach(select => {

                const currentValue = select.value;

                select.innerHTML =
                    '<option value="">Select product</option>' +
                    getProductOptions();

                select.value = currentValue;

            });

    }


    /* =========================
       LOW STOCK
    ========================= */

    function loadLowStockProducts() {

        fetch('/api/low_stock_products', {
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {

            const list =
                document.getElementById('lowStockList');

            if (!Array.isArray(data) || data.length === 0) {

                list.innerHTML =
                    '<li>No low-stock products</li>';

                return;
            }

            list.innerHTML = data.map(product => `
                <li>
                    ${product.product_name}
                    — ${product.product_stock_on_hand} units left
                </li>
            `).join('');

        })
        .catch(error => {

            console.error(error);

            document.getElementById('lowStockList').innerHTML =
                '<li>Unable to load low-stock products.</li>';

        });

    }


    /* =========================
       ORDER ITEMS
    ========================= */

    function addOrderItem() {

        const container =
            document.getElementById('orderItems');

        const id = itemCounter++;

        const row = document.createElement('div');

        row.className = 'product-row';
        row.dataset.itemId = id;

        row.innerHTML = `

            <div>
                <select
                    class="product-select"
                    onchange="calculateTotals()"
                    required
                >
                    <option value="">
                        Select product
                    </option>

                    ${getProductOptions()}
                </select>
            </div>

            <div>
                <input
                    type="number"
                    class="quantity-input"
                    min="1"
                    value="1"
                    oninput="calculateTotals()"
                    required
                >
            </div>

            <div class="price">
                ₹0.00
            </div>

            <div>
                <span class="line-total">
                    ₹0.00
                </span>

                <button
                    type="button"
                    class="remove-button"
                    onclick="removeOrderItem(${id})"
                >
                    ×
                </button>
            </div>
        `;

        container.appendChild(row);

        calculateTotals();

    }


    function removeOrderItem(id) {

        const row = document.querySelector(
            `.product-row[data-item-id="${id}"]`
        );

        if (row) {
            row.remove();
        }

        calculateTotals();

    }


    /* =========================
       TOTALS
    ========================= */

    function calculateTotals() {

        let subtotal = 0;
        let tax = 0;

        document
            .querySelectorAll('#orderItems .product-row')
            .forEach(row => {

                const productId =
                    row.querySelector('.product-select').value;

                const quantity =
                    Number(
                        row.querySelector('.quantity-input').value
                    );

                const product = products.find(
                    product =>
                        String(product.product_id) ===
                        String(productId)
                );

                if (!product || !quantity) {
                    return;
                }

                const lineSubtotal =
                    Number(product.product_price) * quantity;

                const lineTax =
                    lineSubtotal *
                    Number(product.product_tax_percent) / 100;

                const lineTotal =
                    lineSubtotal + lineTax;

                subtotal += lineSubtotal;
                tax += lineTax;

                row.querySelector('.price').textContent =
                    '₹' + Number(product.product_price).toFixed(2);

                row.querySelector('.line-total').textContent =
                    '₹' + lineTotal.toFixed(2);

            });

        const grandTotal = subtotal + tax;

        document.getElementById('subtotal').textContent =
            '₹' + subtotal.toFixed(2);

        document.getElementById('tax').textContent =
            '₹' + tax.toFixed(2);

        document.getElementById('grandTotal').textContent =
            '₹' + grandTotal.toFixed(2);

        calculateBalance();

    }


    /* =========================
       BALANCE
    ========================= */

    function calculateBalance() {

        const totalText =
            document.getElementById('grandTotal').textContent
                .replace('₹', '');

        const total = Number(totalText);

        const amount =
            Number(
                document.getElementById('amountGiven').value
            );

        const balance = amount - total;

        document.getElementById('balance').textContent =
            '₹' + Math.max(balance, 0).toFixed(2);

    }


    /* =========================
       CREATE ORDER
    ========================= */

    function createOrder() {

        const items = [];

        document
            .querySelectorAll('#orderItems .product-row')
            .forEach(row => {

                const productId =
                    row.querySelector('.product-select').value;

                const quantity =
                    Number(
                        row.querySelector('.quantity-input').value
                    );

                if (productId && quantity) {

                    items.push({
                        product_id: Number(productId),
                        quantity: quantity
                    });

                }

            });

        if (!items.length) {

            showMessage(
                'Please add at least one product.',
                'error'
            );

            return;
        }


        const payload = {

            customer_name:
                document.getElementById('customerName').value,

            email:
                document.getElementById('customerEmail').value,

            items: items

        };


        fetch('/api/order', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },

            body: JSON.stringify(payload)

        })
        .then(async response => {

            const data = await response.json();

            if (!response.ok) {
                throw data;
            }

            return data;

        })
        .then(data => {

            showMessage(
                'Order created successfully.',
                'success'
            );

            document.getElementById('orderForm')?.reset();

            document.getElementById('amountGiven').value = '';

            document.getElementById('orderItems').innerHTML = '';

            itemCounter = 0;

            addOrderItem();

            loadProducts();
            loadLowStockProducts();

        })
        .catch(error => {

            let message =
                error.message ||
                'Unable to create order.';

            if (error.errors) {

                const firstError =
                    Object.values(error.errors)[0];

                if (Array.isArray(firstError)) {
                    message = firstError[0];
                }

            }

            showMessage(message, 'error');

        });

        loadLowStockProducts();

    }

</script>

</body>
</html>