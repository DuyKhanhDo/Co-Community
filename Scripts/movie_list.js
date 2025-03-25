document.addEventListener('DOMContentLoaded', function() {
    // Xử lý dropdown menu - cải tiến để dropdown hiển thị cho đến khi rời cả button và dropdown
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        const dropdownBtn = dropdown.querySelector('.dropbtn');
        const dropdownContent = dropdown.querySelector('.dropdown-content');
        
        // Thiết lập trạng thái hover cho dropdown
        dropdown.addEventListener('mouseenter', function() {
            dropdownContent.style.display = 'block';
            dropdownContent.style.opacity = '1';
        });
        
        // Chỉ ẩn dropdown khi rời khỏi cả vùng của dropdown
        dropdown.addEventListener('mouseleave', function() {
            dropdownContent.style.display = 'none';
            dropdownContent.style.opacity = '0';
        });
    });
    
    // Xử lý filter select
    const filterSelects = document.querySelectorAll('.filter-select');
    filterSelects.forEach(select => {
        select.addEventListener('change', function() {
            // Thực hiện lọc phim (mô phỏng)
            console.log('Filter changed:', this.value);
            // Trong thực tế, bạn sẽ gọi API hoặc lọc dữ liệu hiện có
        });
    });
    
    // Xử lý pagination
    const pageLinks = document.querySelectorAll('.page-link, .page-next');
    pageLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Loại bỏ trạng thái active hiện tại
            document.querySelectorAll('.page-link').forEach(item => {
                item.classList.remove('active');
            });
            
            // Đánh dấu trang hiện tại là active (nếu không phải là nút "Trang tiếp")
            if (!this.classList.contains('page-next')) {
                this.classList.add('active');
            }
            
            // Mô phỏng chuyển trang
            console.log('Navigate to page:', this.textContent.trim());
            // Trong thực tế, bạn sẽ tải dữ liệu trang mới
        });
    });
    
    // Xử lý nút action trong movie-item
    const actionBtns = document.querySelectorAll('.action-btn');
    actionBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isPlayButton = this.querySelector('.icon-play');
            const isPlusButton = this.querySelector('.icon-plus');
            
            if (isPlayButton) {
                // Mô phỏng phát phim
                const movieTitle = this.closest('.movie-item').querySelector('.movie-title').textContent;
                alert(`Đang phát phim: ${movieTitle}`);
                
                // Trong thực tế, chuyển đến trang xem phim
                // window.location.href = 'movie_episode.html';
            } else if (isPlusButton) {
                // Mô phỏng thêm vào danh sách
                const movieTitle = this.closest('.movie-item').querySelector('.movie-title').textContent;
                alert(`Đã thêm phim "${movieTitle}" vào danh sách xem của bạn`);
                
                // Đổi màu nút để biểu thị đã thêm
                this.style.backgroundColor = 'var(--secondary-color)';
            }
        });
    });
    
    // Xử lý click vào movie-item
    const movieItems = document.querySelectorAll('.movie-item');
    movieItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Ngăn chặn hành vi mặc định của thẻ a
            if (e.target.tagName.toLowerCase() !== 'a' && 
                !e.target.closest('.action-btn')) {
                
                // Lấy đường dẫn từ thẻ a bên trong
                const link = this.querySelector('.movie-link').getAttribute('href');
                if (link) {
                    window.location.href = link;
                }
            }
        });
    });
}); 