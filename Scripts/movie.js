document.addEventListener('DOMContentLoaded', () => {
  // Thêm sự kiện card link
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
    
    // Thêm hiệu ứng hover
    card.addEventListener('mouseenter', function() {
      this.style.cursor = 'pointer';
    });
  });

  // Thêm sự kiện cho các mục trong danh sách thịnh hành
  const trendingItems = document.querySelectorAll('.trending-item');
  trendingItems.forEach(item => {
    item.addEventListener('click', function() {
      window.location.href = 'movie_page.html';
    });
    
    item.addEventListener('mouseenter', function() {
      this.style.cursor = 'pointer';
    });
  });

  // Thêm sự kiện cho các mục trong danh sách của người dùng
  const userItems = document.querySelectorAll('.user-item');
  userItems.forEach(item => {
    item.addEventListener('click', function() {
      window.location.href = 'movie_page.html';
    });
    
    item.addEventListener('mouseenter', function() {
      this.style.cursor = 'pointer';
    });
  });
}); 