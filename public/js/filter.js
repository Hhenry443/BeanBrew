// JavaScript to toggle dropdown visibility and handle food filtering
const foodButton = document.getElementById('fooddropdownButton');
const foodMenu = document.getElementById('fooddropdownMenu');
const foodItems = foodMenu.querySelectorAll('a');
const foodProducts = document.querySelectorAll('#foodProducts a'); // Select <a> tags instead of .product

// Show/hide food dropdown
foodButton.addEventListener('click', () => {
    foodMenu.classList.toggle('hidden');
});

// Filter food products when a dropdown item is selected
foodItems.forEach(item => {
    item.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default link behavior
        const selectedValue = item.getAttribute('data-value');
        foodButton.textContent = selectedValue;
        foodMenu.classList.add('hidden'); // Hide menu after selection

        // Filter the food items
        foodProducts.forEach(productLink => {
            const productType = productLink.querySelector('.product').getAttribute('data-type');
            if (selectedValue === 'All Food' || productType === selectedValue) {
                productLink.classList.remove('hidden');
            } else {
                productLink.classList.add('hidden');
            }
        });
    });
});

// JavaScript to toggle dropdown visibility and handle drink filtering
const drinkButton = document.getElementById('drinkdropdownButton');
const drinkMenu = document.getElementById('drinkdropdownMenu');
const drinkItems = drinkMenu.querySelectorAll('a');
const drinkProducts = document.querySelectorAll('#drinkProducts a'); // Select <a> tags instead of .product

// Show/hide drink dropdown
drinkButton.addEventListener('click', () => {
    drinkMenu.classList.toggle('hidden');
});

// Filter drink products when a dropdown item is selected
drinkItems.forEach(item => {
    item.addEventListener('click', (event) => {
        event.preventDefault(); // Prevent default link behavior
        const selectedValue = item.getAttribute('data-value');
        drinkButton.textContent = selectedValue;
        drinkMenu.classList.add('hidden'); // Hide menu after selection

        // Filter the drink items
        drinkProducts.forEach(productLink => {
            const productType = productLink.querySelector('.product').getAttribute('data-type');
            if (selectedValue === 'All Drinks' || productType === selectedValue) {
                productLink.classList.remove('hidden');
            } else {
                productLink.classList.add('hidden');
            }
        });
    });
});
