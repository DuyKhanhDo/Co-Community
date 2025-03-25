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

    // Thiết lập biến cho trình phát video
    const videoPlayer = document.querySelector('.video-player');
    const playButton = document.querySelector('.play-button');
    const rewindButton = document.querySelector('.rewind-button');
    const forwardButton = document.querySelector('.forward-button');
    const progressBar = document.querySelector('.progress-bar');
    const volumeButton = document.querySelector('.volume-button');
    const volumeSlider = document.querySelector('.volume-slider');
    const volumeLevel = document.querySelector('.volume-level');
    const fullscreenButton = document.querySelector('.fullscreen-button');
    const timeDisplay = document.querySelector('.time-display');
    
    // Cờ theo dõi trạng thái phát
    let isPlaying = false;
    
    // Xử lý sự kiện nút phát/tạm dừng
    playButton.addEventListener('click', function() {
        if (isPlaying) {
            videoPlayer.pause();
            playButton.textContent = '▶';
        } else {
            videoPlayer.play();
            playButton.textContent = '⏸';
        }
        isPlaying = !isPlaying;
    });
    
    // Xử lý sự kiện nhấn vào video để phát/tạm dừng
    videoPlayer.addEventListener('click', function(e) {
        // Ngăn chặn hành vi mặc định
        e.preventDefault();
        
        if (isPlaying) {
            videoPlayer.pause();
            playButton.textContent = '▶';
        } else {
            videoPlayer.play();
            playButton.textContent = '⏸';
        }
        isPlaying = !isPlaying;
    });
    
    // Xử lý nút tua lại
    rewindButton.addEventListener('click', function() {
        videoPlayer.currentTime = Math.max(0, videoPlayer.currentTime - 10);
        updateProgressBar();
    });
    
    // Xử lý nút tua đi
    forwardButton.addEventListener('click', function() {
        videoPlayer.currentTime = Math.min(videoPlayer.duration, videoPlayer.currentTime + 10);
        updateProgressBar();
    });
    
    // Xử lý nút âm lượng
    volumeButton.addEventListener('click', function() {
        if (videoPlayer.muted) {
            videoPlayer.muted = false;
            volumeButton.textContent = '🔊';
            volumeLevel.style.width = (videoPlayer.volume * 100) + '%';
        } else {
            videoPlayer.muted = true;
            volumeButton.textContent = '🔇';
            volumeLevel.style.width = '0%';
        }
    });
    
    // Xử lý thanh âm lượng
    volumeSlider.addEventListener('click', function(e) {
        const rect = volumeSlider.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        videoPlayer.volume = pos;
        volumeLevel.style.width = (pos * 100) + '%';
        
        if (pos === 0) {
            volumeButton.textContent = '🔇';
            videoPlayer.muted = true;
        } else {
            volumeButton.textContent = '🔊';
            videoPlayer.muted = false;
        }
    });
    
    // Xử lý nút toàn màn hình
    fullscreenButton.addEventListener('click', function() {
        if (videoPlayer.requestFullscreen) {
            videoPlayer.requestFullscreen();
        } else if (videoPlayer.webkitRequestFullscreen) { /* Safari */
            videoPlayer.webkitRequestFullscreen();
        } else if (videoPlayer.msRequestFullscreen) { /* IE11 */
            videoPlayer.msRequestFullscreen();
        }
    });
    
    // Cập nhật thanh tiến trình
    function updateProgressBar() {
        if (videoPlayer.duration) {
            const percentage = (videoPlayer.currentTime / videoPlayer.duration) * 100;
            progressBar.style.width = percentage + '%';
            
            // Cập nhật hiển thị thời gian
            const currentTime = formatTime(videoPlayer.currentTime);
            const duration = formatTime(videoPlayer.duration);
            timeDisplay.textContent = currentTime + ' / ' + duration;
        }
    }
    
    // Xử lý thanh tiến trình khi người dùng nhấp vào
    document.querySelector('.player-progress').addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        videoPlayer.currentTime = pos * videoPlayer.duration;
        updateProgressBar();
    });
    
    // Cập nhật thanh tiến trình khi video đang phát
    videoPlayer.addEventListener('timeupdate', updateProgressBar);
    
    // Định dạng thời gian từ giây sang HH:MM:SS
    function formatTime(seconds) {
        const h = Math.floor(seconds / 3600);
        const m = Math.floor((seconds % 3600) / 60);
        const s = Math.floor(seconds % 60);
        
        return [
            h,
            m > 9 ? m : '0' + m,
            s > 9 ? s : '0' + s
        ].filter(Boolean).join(':');
    }
    
    // Xử lý danh sách tập phim
    const episodeCards = document.querySelectorAll('.episode-card');
    episodeCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.cursor = 'pointer';
        });
        
        card.addEventListener('click', function(e) {
            // Ngăn chặn hành vi mặc định của thẻ a
            if (e.target.tagName.toLowerCase() !== 'a') {
                e.preventDefault();
                window.location.href = this.querySelector('a').getAttribute('href');
            }
        });
    });
    
    // Xử lý nút bình luận
    const commentSubmitButton = document.querySelector('.comment-submit button');
    const commentInput = document.querySelector('.comment-input');
    
    commentSubmitButton.addEventListener('click', function() {
        const commentText = commentInput.value.trim();
        if (commentText) {
            // Tạo phần tử bình luận mới
            const newComment = document.createElement('div');
            newComment.className = 'comment-item';
            
            const currentTime = new Date();
            const timeStr = 'Vừa xong';
            
            newComment.innerHTML = `
                <div class="user-avatar"></div>
                <div class="comment-content">
                    <div class="comment-header">
                        <div class="user-name">Bạn</div>
                        <div class="comment-time">${timeStr}</div>
                    </div>
                    <div class="comment-text">
                        ${commentText}
                    </div>
                    <div class="comment-actions">
                        <div class="comment-action">Thích (0)</div>
                        <div class="comment-action">Trả lời</div>
                        <div class="comment-action">Báo cáo</div>
                    </div>
                </div>
            `;
            
            // Thêm bình luận mới vào danh sách
            document.querySelector('.comments-list').prepend(newComment);
            
            // Làm mới ô nhập liệu
            commentInput.value = '';
            
            // Cập nhật số lượng bình luận
            const commentsTitle = document.querySelector('.comments-title');
            const currentCount = parseInt(commentsTitle.textContent.match(/\d+/)[0], 10);
            commentsTitle.textContent = commentsTitle.textContent.replace(/\d+/, currentCount + 1);
        }
    });
    
    // Xử lý nút "Thích" cho các bình luận
    document.querySelectorAll('.comment-action').forEach(action => {
        if (action.textContent.includes('Thích')) {
            action.addEventListener('click', function() {
                const likeCount = parseInt(this.textContent.match(/\d+/)[0], 10);
                this.textContent = `Thích (${likeCount + 1})`;
                this.style.color = '#3498db';
            });
        }
    });
    
    // Xử lý nút "Xem thêm bình luận"
    const loadMoreButton = document.querySelector('.load-more button');
    loadMoreButton.addEventListener('click', function() {
        // Mô phỏng tải thêm bình luận
        const commentsList = document.querySelector('.comments-list');
        
        for (let i = 0; i < 3; i++) {
            const newComment = document.createElement('div');
            newComment.className = 'comment-item';
            
            const names = ['MarvelHero', 'TonyStarkFan', 'ThorLover'];
            const comments = [
                'Phần này hay hơn Infinity War rất nhiều!',
                'Cảnh chiến đấu cuối cùng thật đáng kinh ngạc. Giá như họ có thêm thời gian để phát triển nhân vật Black Widow.',
                'Thor béo là Thor hay nhất! Thật vui khi thấy anh ấy vượt qua được trầm cảm.'
            ];
            
            newComment.innerHTML = `
                <div class="user-avatar"></div>
                <div class="comment-content">
                    <div class="comment-header">
                        <div class="user-name">${names[i]}</div>
                        <div class="comment-time">${i + 3} giờ trước</div>
                    </div>
                    <div class="comment-text">
                        ${comments[i]}
                    </div>
                    <div class="comment-actions">
                        <div class="comment-action">Thích (${Math.floor(Math.random() * 10)})</div>
                        <div class="comment-action">Trả lời</div>
                        <div class="comment-action">Báo cáo</div>
                    </div>
                </div>
            `;
            
            commentsList.appendChild(newComment);
        }
        
        // Mô phỏng việc ẩn nút khi đã tải hết bình luận
        loadMoreButton.textContent = 'Đã tải tất cả bình luận';
        loadMoreButton.disabled = true;
    });
    
    // Xử lý nút thêm vào danh sách và chia sẻ
    const actionButtons = document.querySelectorAll('.episode-actions button');
    
    actionButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.textContent.includes('Thêm vào danh sách')) {
                alert('Đã thêm vào danh sách xem của bạn!');
                this.innerHTML = '<i class="icon icon-check"></i> Đã thêm vào danh sách';
                this.classList.remove('btn-outline');
                this.classList.add('btn-success');
            } else if (this.textContent.includes('Chia sẻ')) {
                // Mô phỏng chức năng chia sẻ
                const shareOptions = ['Facebook', 'Twitter', 'WhatsApp', 'Email', 'Sao chép liên kết'];
                const shareOption = prompt('Chọn cách chia sẻ:\n1. Facebook\n2. Twitter\n3. WhatsApp\n4. Email\n5. Sao chép liên kết', '5');
                
                if (shareOption) {
                    const option = parseInt(shareOption, 10);
                    if (option >= 1 && option <= 5) {
                        alert(`Đã chia sẻ qua ${shareOptions[option - 1]}!`);
                    }
                }
            }
        });
    });
}); 