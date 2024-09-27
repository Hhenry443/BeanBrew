function showDiv(category) {
    // Hide both the filter divs
    document.getElementById('food').classList.add('hidden');
    document.getElementById('drink').classList.add('hidden');

    // Hide both the product divs
    document.getElementById('foodProducts').classList.add('hidden');
    document.getElementById('drinkProducts').classList.add('hidden');

    // Show the selected category's filter div
    document.getElementById(category).classList.remove('hidden');

    // Show the corresponding products div
    if (category === 'food') {
        document.getElementById('foodProducts').classList.remove('hidden');
    } else if (category === 'drink') {
        document.getElementById('drinkProducts').classList.remove('hidden');
    }

    // Make both texts normal
    document.getElementById('foodText').className = 'mt-2 text-lg';
    document.getElementById('drinkText').className = 'mt-2 text-lg';

    // Make selected text bold and underlined
    document.getElementById(category + "Text").className = "mt-2 text-lg font-bold underline decoration-[#B16119] decoration-2";
}


function toggleSelection(buttonId) {
    const button = document.getElementById(buttonId);

    // Toggle the selected state with Tailwind classes
    button.classList.toggle('bg-[#67360A]'); // Toggle background color to selected color
    button.classList.toggle('ring-2'); // Add ring when selected
    button.classList.toggle('ring-[#67360A]'); // Add the ring color
}

function clearSelectionVeg() {
    // Remove the selected state from both buttons
    document.getElementById('veganBtn').classList.remove('bg-[#67360A]', 'ring-2', 'ring-[#67360A]');
    document.getElementById('vegetarianBtn').classList.remove('bg-[#67360A]', 'ring-2', 'ring-[#67360A]');
}

function clearSelectionAllergen() {
    // Remove the selected state from both buttons
    document.getElementById('milkBtn').classList.remove('bg-[#67360A]', 'ring-2', 'ring-[#67360A]');
    document.getElementById('treeNutsBtn').classList.remove('bg-[#67360A]', 'ring-2', 'ring-[#67360A]');
    document.getElementById('peanutBtn').classList.remove('bg-[#67360A]', 'ring-2', 'ring-[#67360A]');
    document.getElementById('soybeansBtn').classList.remove('bg-[#67360A]', 'ring-2', 'ring-[#67360A]');
}