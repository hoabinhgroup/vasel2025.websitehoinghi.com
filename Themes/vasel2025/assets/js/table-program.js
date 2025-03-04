function show_day(day) {
    // Ẩn tất cả các tab
    document.querySelectorAll('.tab-pane').forEach(tab => {
        tab.style.display = 'none';
    });
    
    // Hiển thị tab được chọn
    document.getElementById(day).style.display = 'block';

    // Xử lý active button
    document.querySelectorAll('.btn').forEach(btn => {
        btn.classList.remove('day-active');
    });
    document.querySelector(`[onclick="show_day('${day}')"]`).classList.add('day-active');
}