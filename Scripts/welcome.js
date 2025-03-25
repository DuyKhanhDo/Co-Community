document.addEventListener('DOMContentLoaded', () => {
    // Xử lý nút đăng nhập qua mạng xã hội
    const socialButtons = document.querySelectorAll('.social-button');
    
    socialButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Xác định loại mạng xã hội
            let provider = '';
            if (this.classList.contains('apple')) provider = 'Apple';
            if (this.classList.contains('google')) provider = 'Google';
            if (this.classList.contains('twitter')) provider = 'Twitter';
            if (this.classList.contains('facebook')) provider = 'Facebook';
            
            // Thông báo (trong thực tế sẽ chuyển hướng đến trang đăng nhập của nhà cung cấp)
            alert(`Đang chuyển hướng đến trang đăng nhập qua ${provider}...`);
            
            // Ở đây chúng ta có thể chuyển hướng đến URL đăng nhập thực tế
            // window.location.href = `auth/${provider.toLowerCase()}.html`;
        });
    });
    
    // Thêm hiệu ứng chuyển động cho background
    const randomizeBackground = () => {
        // Danh sách các ảnh nền có thể thay đổi
        const backgrounds = [
            'https://i.pinimg.com/originals/0e/82/43/0e82432118d20d3b9f90b90de3e264ff.jpg',
            'https://i.pinimg.com/originals/b7/13/9e/b7139e2e0a53d0e995b7effde20b5871.png',
            'https://i.pinimg.com/originals/e1/3d/65/e13d65af3c527580a275a49c6261719c.jpg',
            'https://wallpaperaccess.com/full/5785827.jpg',
            'https://c4.wallpaperflare.com/wallpaper/501/276/927/anime-anime-girls-digital-art-artwork-2d-hd-wallpaper-preview.jpg'
        ];
        
        // Chọn ngẫu nhiên một ảnh nền
        const randomBg = backgrounds[Math.floor(Math.random() * backgrounds.length)];
        
        // Thay đổi ảnh nền với hiệu ứng mờ dần
        const bgArea = document.querySelector('.background-area');
        bgArea.style.opacity = 0;
        
        setTimeout(() => {
            bgArea.style.backgroundImage = `url('${randomBg}')`;
            bgArea.style.opacity = 1;
        }, 500);
    };
    
    // Thay đổi background mỗi 30 giây
    // setInterval(randomizeBackground, 30000);
    
    // Hiệu ứng transition cho background
    const bgArea = document.querySelector('.background-area');
    bgArea.style.transition = 'opacity 1s ease';
}); 