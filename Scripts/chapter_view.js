document.addEventListener("DOMContentLoaded", function () {
  // 1) Sự kiện click trong vùng .comic-container
  const comicContainer = document.querySelector(".comic-container");
  if (comicContainer) {
    comicContainer.addEventListener("click", function () {
      alert("Chuyển chap!");
      // Hoặc chuyển hướng:
      // window.location.href = 'Chapter_160.html';
    });
  }

  // 2) Floating Buttons (Prev / Chapter List / Next)
  const floatingButtons = document.querySelectorAll(".floating-btn");
  if (floatingButtons.length >= 3) {
    // Nút đầu => Trang trước
    floatingButtons[0].addEventListener("click", function () {
      alert("Navigating to previous page");
    });
    // Nút thứ 2 => Mở danh sách chương
    floatingButtons[1].addEventListener("click", function () {
      alert("Opening chapter list");
    });
    // Nút thứ 3 => Trang sau
    floatingButtons[2].addEventListener("click", function () {
      alert("Navigating to next page");
    });
  }

  // 3) Hướng đọc (dropdown: vertical / horizontal)
  const readDirectionSelect = document.querySelector(
    'select[name="read_direction"]'
  );
  if (readDirectionSelect) {
    readDirectionSelect.addEventListener("change", function () {
      const value = this.value;
      console.log("Hướng đọc được chọn:", value);

      // Nếu muốn thay đổi cách xếp .comic-container (dọc / ngang)
      if (comicContainer) {
        if (value === "vertical") {
          comicContainer.style.flexDirection = "column";
        } else {
          comicContainer.style.flexDirection = "row";
        }
      }
    });
  }

  // 4) Chế độ đọc (nếu tồn tại: select[name="display_mode"])
  const displayModeSelect = document.querySelector(
    'select[name="display_mode"]'
  );
  if (displayModeSelect) {
    displayModeSelect.addEventListener("change", function () {
      console.log("Chế độ đọc:", displayModeSelect.value);
      // Thực hiện logic thay đổi giao diện khi chọn "single-page" hay "all-pages"
    });
  }

  // 5) Page Fit (nếu tồn tại: select[name="page_fit"])
  const pageFitSelect = document.querySelector('select[name="page_fit"]');
  if (pageFitSelect) {
    pageFitSelect.addEventListener("change", function () {
      console.log("Kích thước trang:", pageFitSelect.value);
      // Thực hiện logic thay đổi scale trang nếu cần
    });
  }

  // 6) Auto Scroll (nếu tồn tại: input[name="auto_scroll"])
  const autoScrollCheck = document.querySelector('input[name="auto_scroll"]');
  if (autoScrollCheck) {
    autoScrollCheck.addEventListener("change", function () {
      if (autoScrollCheck.checked) {
        console.log("Tự động cuộn: ON");
        // Bắt đầu cơ chế auto-scroll
      } else {
        console.log("Tự động cuộn: OFF");
        // Dừng auto-scroll
      }
    });
  }
}); 