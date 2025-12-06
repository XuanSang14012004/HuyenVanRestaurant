document.getElementById('orderAllBtn').addEventListener('click', function () {
    const selectedItems = [];

    document.querySelectorAll('.menu-item').forEach(item => {
        const checkbox = item.querySelector('.select-item');
        const qtyInput = item.querySelector('.quantity');

        if (checkbox.checked) {
            selectedItems.push({
                name: item.dataset.name,
                price: Number(item.dataset.price),
                quantity: Number(qtyInput.value)
            });
        }
    });

    // Nếu không chọn món nào
    if (selectedItems.length === 0) {
        alert("⚠ Vui lòng chọn ít nhất 1 món!");
        return;
    }

    // Lưu vào localStorage
    localStorage.setItem('selectedItems', JSON.stringify(selectedItems));

    // Chuyển sang trang xác nhận
    window.location.href = 'order.php';
});
