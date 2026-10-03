document.querySelectorAll('.product-card').forEach(card => {
  const minus = card.querySelector('.minus');
  const plus = card.querySelector('.plus');
  const value = card.querySelector('.quantity-value');
  const qtyInput = card.querySelector('.form-qty');

  minus.addEventListener('click', () => {
    let val = parseInt(value.textContent);
    if (val > 1) {
      val--;
      value.textContent = val;
      qtyInput.value = val;
    }
  });

  plus.addEventListener('click', () => {
    let val = parseInt(value.textContent);
    val++;
    value.textContent = val;
    qtyInput.value = val;
  });
});
