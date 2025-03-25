document.addEventListener('DOMContentLoaded', () => {
    // Lấy các thành phần tab
    const tabs = document.querySelectorAll('.tab');
    const forms = document.querySelectorAll('.auth-form');
    
    // Xử lý chuyển tab
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const targetTab = tab.getAttribute('data-tab');
            
            // Cập nhật trạng thái active cho tab
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
            
            // Hiển thị form tương ứng
            forms.forEach(form => {
                if (form.id === `${targetTab}-form`) {
                    form.classList.add('active');
                } else {
                    form.classList.remove('active');
                }
            });
        });
    });
    
    // Xử lý đăng nhập
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const rememberMe = document.getElementById('remember-me')?.checked || false;
            
            // Kiểm tra dữ liệu
            if (!email || !password) {
                showMessage('Vui lòng nhập đầy đủ thông tin đăng nhập', 'error');
                return;
            }
            
            // Giả lập đăng nhập thành công
            showMessage('Đăng nhập thành công, đang chuyển hướng...', 'success');
            
            // Giả lập chuyển hướng sau đăng nhập
            setTimeout(() => {
                window.location.href = 'comic.html';
            }, 1500);
        });
    }
    
    // Xử lý đăng ký
    const registerForm = document.getElementById('register-form');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const agreeTerms = document.getElementById('agree-terms').checked;
            
            // Kiểm tra dữ liệu
            if (!username || !email || !password || !confirmPassword) {
                showMessage('Vui lòng nhập đầy đủ thông tin đăng ký', 'error');
                return;
            }
            
            if (password !== confirmPassword) {
                showMessage('Mật khẩu xác nhận không khớp', 'error');
                return;
            }
            
            if (!agreeTerms) {
                showMessage('Bạn cần đồng ý với điều khoản sử dụng', 'error');
                return;
            }
            
            // Kiểm tra mật khẩu mạnh
            if (password.length < 8) {
                showMessage('Mật khẩu phải có ít nhất 8 ký tự', 'error');
                return;
            }
            
            // Giả lập đăng ký thành công
            showMessage('Đăng ký thành công! Đang chuyển hướng đến trang đăng nhập...', 'success');
            
            // Chuyển đến trang đăng nhập sau khi đăng ký
            setTimeout(() => {
                window.location.href = 'login.html';
            }, 1500);
        });
    }
    
    // Xử lý đăng nhập bằng mạng xã hội
    const socialButtons = document.querySelectorAll('.social-button');
    socialButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Xác định loại mạng xã hội
            let provider = '';
            if (this.classList.contains('facebook')) provider = 'Facebook';
            if (this.classList.contains('google')) provider = 'Google';
            
            showMessage(`Đang chuyển hướng đến trang đăng nhập qua ${provider}...`, 'info');
            
            // Giả lập đăng nhập qua mạng xã hội
            setTimeout(() => {
                showMessage(`Đăng nhập bằng ${provider} thành công!`, 'success');
                
                // Giả lập chuyển hướng sau đăng nhập
                setTimeout(() => {
                    window.location.href = 'comic.html';
                }, 1500);
            }, 1500);
        });
    });
    
    // Hiệu ứng cho background
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
    setInterval(randomizeBackground, 30000);
    
    // Hiển thị thông báo
    function showMessage(message, type = 'info') {
        // Kiểm tra nếu đã có thông báo thì xóa
        const existingMessage = document.querySelector('.message');
        if (existingMessage) {
            existingMessage.remove();
        }
        
        // Tạo element thông báo
        const messageElement = document.createElement('div');
        messageElement.className = `message ${type}`;
        messageElement.textContent = message;
        
        // Thêm vào DOM
        const authBox = document.querySelector('.auth-box');
        if (authBox) {
            authBox.appendChild(messageElement);
        }
        
        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            messageElement.classList.add('hide');
            setTimeout(() => messageElement.remove(), 300);
        }, 3000);
    }
    
    // Thêm CSS cho thông báo
    const style = document.createElement('style');
    style.textContent = `
        .message {
            padding: 12px;
            margin: 15px 30px;
            border-radius: 4px;
            text-align: center;
            animation: fadeIn 0.3s;
            position: relative;
        }
        
        .message.success {
            background-color: rgba(46, 204, 113, 0.2);
            color: #27ae60;
            border-left: 4px solid #27ae60;
        }
        
        .message.error {
            background-color: rgba(231, 76, 60, 0.2);
            color: #c0392b;
            border-left: 4px solid #c0392b;
        }
        
        .message.info {
            background-color: rgba(52, 152, 219, 0.2);
            color: #2980b9;
            border-left: 4px solid #2980b9;
        }
        
        .message.hide {
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
}); 