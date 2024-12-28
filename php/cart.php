<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" image="image/x-icon" href="./assets/favicon.ico">
    <title>Cart</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <header>
        <?php include("../layout/navbar/navbar.html") ?>
    </header>
    <main class="p-6">
        <h1 class="text-2xl font-bold mb-6">Cart</h1>
        <div id="cart" class="border border-gray-200 rounded-md p-4 mt-[70px] max-h-[500px] overflow-y-auto">
            <p class="text-center text-gray-500">Loading cart...</p>
        </div>
        <div class="mt-6">
            <h3 class="text-lg font-bold mb-4">Payment Method</h3>
            <form id="payment-form">
                <div class="mb-4">
                    <input type="radio" id="credit-card" name="payment_method" value="Debit" class="mr-2">
                    <label for="credit-card" class="text-gray-700">Debit</label>
                </div>
                <div class="mb-4">
                    <input type="radio" id="paypal" name="payment_method" value="QRIS" class="mr-2">
                    <label for="paypal" class="text-gray-700">QRIS</label>
                </div>
                <div class="mb-4">
                    <input type="radio" id="bank-transfer" name="payment_method" value="Cash" class="mr-2">
                    <label for="bank-transfer" class="text-gray-700">Cash</label>
                </div>
            </form>
        </div>
        <button onclick="checkout()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 mt-6">
            Checkout
        </button>
        <a href="/seblaktasti/php/userpage.php">Shop Again</a>
    </main>

    <script>
        // Declare 'cart' once globally
       

        function updateCart() {
            const cartContainer = document.getElementById('cart');
            cartContainer.innerHTML = ''; // Clear the cart content

            if (cart.length === 0) {
                cartContainer.innerHTML = '<p class="text-center text-gray-500 mt-[]">Your cart is empty.</p>';
                return;
            }

            cart.forEach(product => {
                const cartItem = document.createElement('div');
                cartItem.classList.add('flex', 'justify-between', 'items-center', 'mb-4', 'border-b', 'pb-4');
                
                cartItem.innerHTML = `
                    <div>
                        <p class="font-bold">${product.name}</p>
                        <p class="text-gray-500">Qty: ${product.quantity}</p>
                        <p class="text-gray-500">Category: ${product.category}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600 mb-2">Rp ${(product.price * product.quantity).toLocaleString('id-ID')}</p>
                        <div class="flex items-center space-x-2">
                            <button onclick="changeQuantity(${product.id}, -1)" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-600">−</button>
                            <button onclick="changeQuantity(${product.id}, 1)" class="bg-green-500 text-white px-2 py-1 rounded-md hover:bg-green-600">+</button>
                        </div>
                        <button onclick="removeFromCart(${product.id})" class="text-red-500 hover:underline mt-2">Remove</button>
                    </div>
                `;
                
                cartContainer.appendChild(cartItem);
            });
        }

        function removeFromCart(id) {
            cart = cart.filter(product => product.id !== id);
            localStorage.setItem('cart', JSON.stringify(cart)); // Save to localStorage
            updateCart();
        }

        function changeQuantity(id, delta) {
            const item = cart.find(product => product.id === id);
            if (item) {
                item.quantity += delta;
                if (item.quantity <= 0) {
                    removeFromCart(id);
                }
            }
            localStorage.setItem('cart', JSON.stringify(cart)); // Save to localStorage
            updateCart();
        }

        function checkout() {
    if (cart.length === 0) {
        alert('Your cart is empty!');
        return;
    }

    const paymentForm = document.getElementById('payment-form');
    const selectedPaymentMethod = paymentForm.querySelector('input[name="payment_method"]:checked');

    if (!selectedPaymentMethod) {
        alert('Please select a payment method.');
        return;
    }

    const checkoutData = {
        cart: JSON.stringify(cart),
        payment_method: selectedPaymentMethod.value
    };

    fetch('checkout.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams(checkoutData)
    })
    .then(response => response.text())
    .then(data => {
        if (data.includes('Cart is empty!')) {
            alert('Cart is empty!');
        } else {
            const orderId = data;
            alert('Order successfully placed!');
            
            // Clear cart from localStorage after successful checkout
            localStorage.removeItem('cart');
            
            // Optionally, you can also update the cart UI here if needed
            cart = []; // Clear the cart in memory
            updateCart(); // Re-render the cart as empty

            // Redirect to invoice page or any other page as needed
            window.location.href = `invoice.php?order_id=${orderId}`;
        }
    })
    .catch(error => {
        console.error('Error during checkout:', error);
        alert('An error occurred during checkout.');
    });
}


        window.addEventListener('DOMContentLoaded', updateCart); // Call updateCart on page load
    </script>
</body>
</html>
