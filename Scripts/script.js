document.addEventListener('DOMContentLoaded', () => {
  const carouselItems = Array.from(document.querySelectorAll('.carousel-item'));
  const dots = Array.from(document.querySelectorAll('.dot'));
  const carousel = document.querySelector('.carousel-container');
  
  let currentIndex = 0;
  let autoSlideInterval;

  // Khởi tạo và xử lý sự kiện
  function init() {
    // Hiển thị slide đầu tiên
    positionAllItems(currentIndex);
    // Cập nhật theme từ slide đầu tiên
    updateThemeFromItem(carouselItems[currentIndex]);
    // Thêm các sự kiện
    addEventListeners();
    // Bắt đầu auto slide
    startAutoSlide();
  }

  function addEventListeners() {
    // Click trên dot
    dots.forEach((dot, i) => dot.addEventListener('click', () => setActiveItem(i)));
    
    // Xử lý resize
    window.addEventListener('resize', () => positionAllItems(currentIndex));
    
    // Tạm dừng auto slide khi hover
    carousel.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
    carousel.addEventListener('mouseleave', startAutoSlide);
    
    // Thêm xử lý click trái phải trên carousel
    carousel.addEventListener('click', handleCarouselClick);
    
    // Thêm xử lý click cho nút điều hướng - với stopPropagation để ngăn event lan tỏa
    const prevButton = document.querySelector('.carousel-prev');
    const nextButton = document.querySelector('.carousel-next');
    
    prevButton.addEventListener('click', (e) => {
      e.stopPropagation(); // Ngăn event lan tỏa
      setActiveItem(currentIndex - 1);
    });
    
    nextButton.addEventListener('click', (e) => {
      e.stopPropagation(); // Ngăn event lan tỏa
      setActiveItem(currentIndex + 1);
    });
  }

  // Hàm xử lý click trái phải trên carousel
  function handleCarouselClick(event) {
    // Kiểm tra nếu click vào carousel-content hoặc các thành phần con của nó thì không xử lý
    if (event.target.closest('.carousel-content') || 
        event.target.classList.contains('view-button') ||
        event.target.tagName === 'A') {
      return;
    }
    
    const carouselRect = carousel.getBoundingClientRect();
    const clickX = event.clientX - carouselRect.left;
    const carouselWidth = carouselRect.width;
    
    // Nếu click vào 30% bên trái, chuyển sang slide trước
    if (clickX < carouselWidth * 0.3) {
      setActiveItem(currentIndex - 1);
    } 
    // Nếu click vào 30% bên phải, chuyển sang slide kế tiếp
    else if (clickX > carouselWidth * 0.7) {
      setActiveItem(currentIndex + 1);
    }
  }

  // Hàm cập nhật theme từ carousel item
  function updateThemeFromItem(item) {
    const bgColor = item.dataset.bgColor || '#333';
    const primaryColor = item.dataset.primaryColor || '#444';
    const buttonColor = item.dataset.buttonColor || '#4a76a8';
    
    document.documentElement.style.setProperty('--carousel-bg-color', bgColor);
    document.documentElement.style.setProperty('--primary-color', primaryColor);
    document.documentElement.style.setProperty('--button-color', buttonColor);
    document.documentElement.style.setProperty('--highlight-color', buttonColor);
    
    // Cập nhật màu nền cho featured section
    document.getElementById('featured-section').style.backgroundColor = bgColor;
  }

  function setActiveItem(index) {
    currentIndex = (index + carouselItems.length) % carouselItems.length; // Xử lý index âm
    positionAllItems(currentIndex);
    
    // Cập nhật theme từ slide hiện tại
    const activeItem = carouselItems[currentIndex];
    updateThemeFromItem(activeItem);
    
    // Cập nhật dot active
    dots.forEach(dot => dot.classList.remove('active'));
    dots[currentIndex].classList.add('active');
  }

  function positionAllItems(centerIndex) {
    // Đơn giản hóa phần này - chỉ hiển thị item active, ẩn các item khác
    carouselItems.forEach((item, i) => {
      if (i === centerIndex) {
        item.style.display = 'flex';
        item.classList.add('active');
      } else {
        item.style.display = 'none';
        item.classList.remove('active');
      }
    });
  }

  function startAutoSlide() {
    autoSlideInterval = setInterval(() => {
      setActiveItem(currentIndex + 1);
    }, 5000);
  }

  // Khởi chạy
  init();
});