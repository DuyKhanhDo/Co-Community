document.addEventListener('DOMContentLoaded', () => {
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

  // Thêm sự kiện cho các nút trong phần hành động
  const actionButtons = document.querySelectorAll('.movie-actions .btn');
  actionButtons.forEach(button => {
    if (button.classList.contains('btn-outline')) {
      button.addEventListener('click', function() {
        alert('Đã thêm phim vào danh sách xem của bạn!');
      });
    } else if (button.classList.contains('btn-secondary')) {
      button.addEventListener('click', function() {
        alert('Đang tải xuống phim...');
      });
    }
  });

  // Thêm sự kiện cho thẻ episode-card
  const episodeCard = document.querySelector('.episode-card');
  if (episodeCard) {
    episodeCard.addEventListener('click', function() {
      window.location.href = 'movie_episode.html';
    });
    
    episodeCard.addEventListener('mouseenter', function() {
      this.style.cursor = 'pointer';
    });
  }

  // Thêm sự kiện cho các thẻ movie-card
  const movieCards = document.querySelectorAll('.movie-card');
  movieCards.forEach(card => {
    card.addEventListener('click', function(e) {
      // Nếu người dùng không nhấp vào liên kết cụ thể bên trong thẻ
      if (!e.target.closest('a:not(.card-link)')) {
        const link = this.querySelector('.card-link');
        if (link) {
          window.location.href = link.getAttribute('href');
        }
      }
    });
    
    card.addEventListener('mouseenter', function() {
      this.style.cursor = 'pointer';
    });
  });
}); 