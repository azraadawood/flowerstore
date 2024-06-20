// Switches between Sign Up and Sign In forms
const signUpButton = document.getElementById('signUpButton');
const signInButton = document.getElementById('signInButton');
const signInForm = document.getElementById('signIn');
const signUpForm = document.getElementById('signup');

// Event listener for Sign Up button click
signUpButton.addEventListener('click', function() {
    // Hide Sign In form and display Sign Up form
    signInForm.style.display = "none";
    signUpForm.style.display = "block";
});

// Event listener for Sign In button click
signInButton.addEventListener('click', function() {
    // Hide Sign Up form and display Sign In form
    signInForm.style.display = "block";
    signUpForm.style.display = "none";
});

// Document Ready Function using jQuery
$(document).ready(function() {

    // Handle item quantity change in the cart
    $(".itemQty").on('change', function() {
        var $el = $(this).closest('tr');
        var pid = $el.find(".pid").val();        // Get product ID
        var pprice = $el.find(".pprice").val();  // Get product price
        var qty = $el.find(".itemQty").val();    // Get updated quantity

        // AJAX request to update item quantity in database
        $.ajax({
            url: 'action.php',
            method: 'post',
            cache: false,
            data: {
                qty: qty,
                pid: pid,
                pprice: pprice
            },
            success: function(response) {
                console.log(response); // Log the response from server
                location.reload(true); // Reload the page after successful update
            }
        });
    });

    // Function to load the number of items in the cart
    function load_cart_item_number() {
        $.ajax({
            url: 'action.php',
            method: 'get',
            data: {
                cartItem: "cart_item" // Parameter to fetch cart items count
            },
            success: function(response) {
                $("#cart-item").html(response); // Update the cart item count in HTML
            }
        });
    }

    // Call load_cart_item_number function to initially load cart item count
    load_cart_item_number();

    // Handle click event for adding items to the cart
    $(".addItemBtn").click(function(e) {
        e.preventDefault(); // Prevent default form submission behavior
        var $form = $(this).closest(".form-submit");
        var pid = $form.find(".pid").val();     // Get product ID
        var pname = $form.find(".pname").val(); // Get product name
        var pprice = $form.find(".pprice").val(); // Get product price
        var pimage = $form.find(".pimage").val(); // Get product image URL
        var pcode = $form.find(".pcode").val();   // Get product code
        var pqty = $form.find(".pqty").val();     // Get product quantity

        // AJAX request to add item to cart
        $.ajax({
            url: 'action.php',
            method: 'post',
            data: {
                pid: pid,
                pname: pname,
                pprice: pprice,
                pqty: pqty,
                pimage: pimage,
                pcode: pcode
            },
            success: function(response) {
                $("#message").html(response); // Display success or error message
                window.scrollTo(0, 0); // Scroll to the top of the page
                load_cart_item_number(); // Reload cart item count after adding item
            }
        });
    });
});
