document.addEventListener("DOMContentLoaded", () => {
  const categoriesDiv = document.getElementById("categories");
  const medicationsDiv = document.getElementById("medications");
  const cartItems = document.getElementById("cart-items");
  const cartTotal = document.getElementById("cart-total");

  // Fetch categories & medicines from backend
  fetch("../api/data.php")
    .then(res => res.json())
    .then(data => {
      displayCategories(data.categories);
      displayMedications(data.medications);
    })
    .catch(error => console.error("Error fetching data:", error));

  // Show categories
  function displayCategories(categories) {
    categoriesDiv.innerHTML = "<h2>Categories</h2>";
    const list = document.createElement("div");
    list.className = "categories-list";

    categories.forEach(cat => {
      const btn = document.createElement("button");
      btn.className = "category-pill";
      btn.textContent = cat.name;
      btn.onclick = () => filterMedications(cat.id);
      list.appendChild(btn);
    });

    categoriesDiv.appendChild(list);
  }

  // Show medications
  function displayMedications(medications) {
    medicationsDiv.innerHTML = "";
    medications.forEach(med => {
      const card = document.createElement("div");
      card.className = "med-card";
      card.innerHTML = `
        <img src="${med.image_url}" alt="${med.name}">
        <h3 class="med-name">${med.name}</h3>
        <p class="med-generic">${med.description}</p>
        <p class="med-price">Price: Rs. ${med.price}</p>
        <button class="add-btn" onclick="addToCart(${med.id})">Add to Cart</button>
      `;
      medicationsDiv.appendChild(card);
    });
  }

  // Filter by category
  function filterMedications(categoryId) {
    fetch(`../api/data.php?category_id=${categoryId}`)
      .then(res => res.json())
      .then(data => displayMedications(data.medications));
  }

  // Add to cart
  window.addToCart = function (id) {
    fetch("../api/cart.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, quantity: 1 })
    })
      .then(res => res.json())
      .then(data => updateCart(data));
  };

  // Update cart
  function updateCart(cart) {
    cartItems.innerHTML = "";
    let total = 0;
    cart.forEach(item => {
      const li = document.createElement("li");
      li.className = "cart-item";
      li.innerHTML = `
    <span>${item.name} x ${item.quantity} = Rs. ${item.total}</span>
    <button class="remove-btn" onclick="removeFromCart(${item.id})">&times;</button>
    `;
      cartItems.appendChild(li);
      total += item.total;
    });
    cartTotal.textContent = `Total: Rs. ${total.toFixed(2)}`;
  }

  // Add this new function
  window.removeFromCart = function (id) {
    fetch(`../api/cart.php?id=${id}`, {
      method: "DELETE"
    })
      .then(res => res.json())
      .then(data => updateCart(data))
      .catch(error => console.error("Error removing item:", error));
  };

  // Fetch initial cart state
  fetch("../api/cart.php")
    .then(res => res.json())
    .then(data => updateCart(data));
});