// assets/js/cart_handler.js

(function initQtyAndCart() {
  const attach = () => {
    // Delegasi event untuk tombol qty (+/-)
    document.addEventListener("click", (e) => {
      const btn = e.target.closest(".quantity-btn");
      if (!btn) return;

      const id = btn.getAttribute("data-id");
      if (!id) return;

      const qtyView  = document.getElementById(`view-${id}`);
      const qtyInput = document.getElementById(`qty-${id}`);
      if (!qtyView || !qtyInput) return;

      let qty = parseInt(qtyView.innerText || "1", 10);
      if (btn.classList.contains("plus"))  qty++;
      if (btn.classList.contains("minus") && qty > 1) qty--;

      qtyView.innerText = String(qty);
      qtyInput.value    = String(qty);
    });
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", attach);
  } else {
    attach();
  }
})();

// Notifikasi 2 detik kanan-atas
function showNotification(message, type = "success") {
  const el = document.createElement("div");
  el.className = "cart-notification " + (type === "error" ? "error" : "");
  el.textContent = message;
  document.body.appendChild(el);
  setTimeout(() => el.remove(), 2000);
}

// AJAX add to cart
function addToCart(id_produk) {
  const qtyEl = document.getElementById(`qty-${id_produk}`);
  const qty = qtyEl ? qtyEl.value : 1;

  fetch("actions/add_to_cart.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id_produk=${encodeURIComponent(id_produk)}&qty=${encodeURIComponent(qty)}`
  })
    .then((r) => r.text())
    .then((txt) => {
      if (txt.trim() === "SUCCESS") {
        showNotification("✅ Produk ditambahkan ke keranjang");
      } else {
        showNotification("⚠️ Gagal menambahkan ke keranjang", "error");
        console.warn("add_to_cart:", txt);
      }
    })
    .catch((err) => {
      showNotification("⚠️ Terjadi kesalahan jaringan", "error");
      console.error(err);
    });
}
