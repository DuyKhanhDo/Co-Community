document.addEventListener('DOMContentLoaded', function() {
    // Xử lý alert message tự động ẩn sau 5 giây
    const alertMessage = document.querySelector('.alert');
    if (alertMessage) {
        setTimeout(function() {
            alertMessage.style.opacity = '0';
            setTimeout(function() {
                alertMessage.style.display = 'none';
            }, 500);
        }, 5000);
    }

    // Xử lý tìm kiếm
    const searchInput = document.querySelector('.search-bar input');
    const searchButton = document.querySelector('.search-bar button');
    
    if (searchButton && searchInput) {
        searchButton.addEventListener('click', function(e) {
            e.preventDefault();
            searchContent(searchInput.value);
        });
        
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchContent(searchInput.value);
            }
        });
    }
    
    function searchContent(query) {
        // Lấy loại nội dung hiện tại (phim, người dùng, thể loại)
        const currentAction = window.location.search.split('action=')[1]?.split('&')[0] || 'dashboard';
        if (query.trim() !== '') {
            window.location.href = `admin_panel.php?action=${currentAction}&search=${encodeURIComponent(query.trim())}`;
        }
    }

    // Xử lý responsive menu
    const toggleMobileMenu = document.querySelector('.mobile-menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (toggleMobileMenu && sidebar) {
        toggleMobileMenu.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }

    // Xử lý tooltip cho các nút
    const actionButtons = document.querySelectorAll('.btn-edit, .btn-delete');
    
    actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = this.classList.contains('btn-edit') ? 'Sửa' : 'Xóa';
            
            document.body.appendChild(tooltip);
            
            const rect = this.getBoundingClientRect();
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.opacity = '1';
            
            this.addEventListener('mouseleave', function() {
                document.body.removeChild(tooltip);
            }, { once: true });
        });
    });

    // Xử lý chuyển đổi giữa các tab trong form sửa phim (nếu có)
    const formTabs = document.querySelectorAll('.form-tabs .tab-btn');
    const formTabPanes = document.querySelectorAll('.tab-pane');
    
    if (formTabs.length > 0 && formTabPanes.length > 0) {
        formTabs.forEach(tab => {
            tab.addEventListener('click', function() {
                formTabs.forEach(t => t.classList.remove('active'));
                formTabPanes.forEach(p => p.classList.remove('active'));
                
                this.classList.add('active');
                const tabId = this.getAttribute('data-tab');
                document.getElementById(tabId).classList.add('active');
            });
        });
    }

    // Xử lý preview ảnh khi upload (nếu có)
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    
    imageInputs.forEach(input => {
        const previewContainer = document.createElement('div');
        previewContainer.className = 'image-preview';
        input.parentNode.insertBefore(previewContainer, input.nextSibling);
        
        input.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    previewContainer.appendChild(img);
                };
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });

    // Xử lý confirm trước khi xóa
    const deleteLinks = document.querySelectorAll('a[href*="delete_"]');
    
    deleteLinks.forEach(link => {
        if (!link.hasAttribute('onclick')) {
            link.addEventListener('click', function(e) {
                if (!confirm('Bạn có chắc muốn xóa mục này?')) {
                    e.preventDefault();
                }
            });
        }
    });
}); 