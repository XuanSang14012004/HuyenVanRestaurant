
document.getElementById("orderAllBtn").addEventListener("click", function() {
  const checkedItems = document.querySelectorAll(".select-item:checked");
  
  if (checkedItems.length === 0) {
    alert("❌ Bạn chưa chọn món nào!");
    return;
  }

  let total = 0;
  let message = "🍽️ Danh sách món bạn đã chọn:\n\n";

  checkedItems.forEach(item => {
    const menuItem = item.closest(".menu-item");
    const name = menuItem.getAttribute("data-name");
    const price = parseInt(menuItem.getAttribute("data-price"));
    total += price;
    message += `• ${name}: ${price.toLocaleString()}đ\n`;
  });

  message += `\n👉 Tổng cộng: ${total.toLocaleString()}đ\n\nCảm ơn bạn đã đặt món ❤️`;
  alert(message);
});

