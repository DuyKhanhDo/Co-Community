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

    // Xử lý chuyển đổi tab
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Loại bỏ active class từ tất cả các nút và tab
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Thêm active class vào nút được click và tab tương ứng
            this.classList.add('active');
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Xử lý các nút action trong movie-item
    const actionButtons = document.querySelectorAll('.action-btn');
    
    actionButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isPlayButton = this.classList.contains('icon-play');
            const isPlusButton = this.classList.contains('icon-plus');
            
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

    // Xử lý tìm kiếm
    const searchInput = document.querySelector('.search-bar input');
    const searchButton = document.querySelector('.search-bar button');

    searchButton.addEventListener('click', function() {
        const searchTerm = searchInput.value.trim();
        if (searchTerm) {
            // Mô phỏng tìm kiếm
            alert(`Đang tìm kiếm: ${searchTerm}`);
            // Trong thực tế, chuyển đến trang kết quả tìm kiếm
            // window.location.href = `search.html?q=${encodeURIComponent(searchTerm)}`;
        }
    });

    // Xử lý nhấn Enter trong ô tìm kiếm
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchButton.click();
        }
    });
}); 