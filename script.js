const header = document.querySelector(".header");

function fixedNavbar() {
  header.classList.toggle("scrolled", window.pageYOffset > 0);
}
fixedNavbar();
window.addEventListener("scroll", fixedNavbar);

let menu = document.querySelector("#menu-btn");
if (menu) {
  menu.addEventListener("click", function () {
    let nav = document.querySelector(".navbar");
    nav.classList.toggle("active");
  });
}

let userBtn = document.getElementById("user-btn");
if (userBtn) {
  userBtn.addEventListener("click", function () {
    let userBox = document.querySelector(".profile-detail");
    userBox.classList.toggle("active");
  });
}

/*-------- slide --------*/
let slides = document.querySelectorAll(".testimonial-item");
let index = 0;
function nextSlide() {
  slides[index].classList.remove("active");
  index = (index + 1) % slides.length;
  slides[index].classList.add("active");
}

function prevSlide() {
  slides[index].classList.remove("active");
  index = (index - 1 + slides.length) % slides.length;
  slides[index].classList.add("active");
}

document.addEventListener("DOMContentLoaded", () => {
  let slides = document.querySelectorAll(".testimonial-item");
  let index = 0;

  window.nextSlide = function () {
    slides[index].classList.remove("active");
    index = (index + 1) % slides.length;
    slides[index].classList.add("active");
  };

  window.prevSlide = function () {
    slides[index].classList.remove("active");
    index = (index - 1 + slides.length) % slides.length;
    slides[index].classList.add("active");
  };
});

/*------------search--------------*/

function toggleSearchArea() {
  const searchArea = document.getElementById("searchArea");
  const resultBox = document.getElementById("resultBox");
  searchArea.classList.toggle("active");

  if (!searchArea.classList.contains("active")) {
    document.getElementById("searchInput").value = "";
    resultBox.classList.remove("active");
    resultBox.innerHTML = "<p>Start typing to see results...</p>";
  }
}

document.addEventListener("click", function (event) {
  const searchBox = document.getElementById("searchArea");
  const searchButton = document.querySelector(".search-button");

  if (
    !searchBox.contains(event.target) && // Không nhấn vào hộp tìm kiếm
    !searchButton.contains(event.target) // Không nhấn vào nút search
  ) {
    searchBox.classList.remove("active"); // Ẩn hộp tìm kiếm
  }
});

document.addEventListener("click", function (event) {
  const searchBox = document.getElementById("user-btn");
  const searchButton = document.querySelector(".profile-detail");

  if (
    !searchBox.contains(event.target) && // Không nhấn vào hộp tìm kiếm
    !searchButton.contains(event.target)
  ) {
    searchButton.classList.remove("active");
  }
});

let items = [];

//search vvoi keyword
function searchProducts(keyword) {
  const encodedKeyword = encodeURIComponent(keyword);

  const url = `getproducts.php?keyword=${encodedKeyword}`;

  window.location.href = url;
}

// function searchProducts(keyword) {
//   const encodedKeyword = encodeURIComponent(keyword);
//   const url = `getproducts.php?keyword=${encodedKeyword}`;

//   fetch(url)
//     .then((response) => {
//       if (!response.ok) {
//         throw new Error(
//           `Network response was not ok (status: ${response.status})`
//         );
//       }
//       return response.json();
//     })
//     .then((data) => {
//       const resultBox = document.getElementById("resultBox");
//       resultBox.innerHTML = ""; // Xóa nội dung cũ

//       if (data.length > 0) {
//         data.forEach((item) => {
//           const link = document.createElement("a");
//           link.href = `getproducts.php?keyword=${encodeURIComponent(
//             item.name
//           )}`;
//           link.className = "result-item";
//           link.textContent = item.name;
//           resultBox.appendChild(link);
//         });

//         // Gắn sự kiện click cho các kết quả
//         attachClickHandlers();
//       } else {
//         resultBox.innerHTML = "<p>No products found.</p>";
//       }
//     })
//     .catch((error) => {
//       console.error("Error fetching products:", error);
//       alert("An error occurred while fetching products.");
//     });
// }

document
  .getElementById("searchInput")
  .addEventListener("keypress", function (event) {
    if (event.key === "Enter") {
      event.preventDefault();
      const keyword = event.target.value.trim();
      if (keyword) {
        // document.getElementById("searchForm").submit();
        searchProducts(keyword);
      } else {
        alert("Please enter a keyword to search.");
      }
    }
  });

function attachClickHandlers() {
  // Lấy tất cả các mục <li> bên trong #resultBox
  const resultItems = document.querySelectorAll("#resultBox ul li");

  // Gắn sự kiện click cho từng mục
  resultItems.forEach((item) => {
    item.addEventListener("click", () => {
      const selectedProduct = item.textContent.trim(); // Lấy nội dung text của mục được click
      handleResultClick(selectedProduct); // Xử lý sự kiện click
    });
  });
}

// Hàm xử lý sự kiện khi click vào một kết quả
function handleResultClick(productName) {
  console.log("Selected product:", productName);
  // Điều hướng đến trang sản phẩm cụ thể
  window.location.href = `getproducts.php?keyword=${encodeURIComponent(
    productName
  )}`;
}

function fetchProducts() {
  fetch("checkinfor.php?action=getProducts")
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      items = data;
    })
    .catch((error) => console.error("Error fetching products:", error));
}

// Hàm cập nhật kết quả tìm kiếm
function updateResults() {
  const searchInput = document
    .getElementById("searchInput")
    .value.toLowerCase();
  const resultBox = document.getElementById("resultBox");

  const results = items.filter((item) =>
    item.toLowerCase().includes(searchInput)
  );

  resultBox.classList.add("active"); // Hiện box kết quả
  if (searchInput === "") {
    resultBox.innerHTML = "<p>Start typing to see results...</p>";
  } else if (results.length > 0) {
    resultBox.innerHTML = `<ul>${results
      .map((item) => `<li>${item}</li>`)
      .join("")}</ul>`;
    attachClickHandlers();
  } else {
    resultBox.innerHTML = "<p>No results found.</p>";
  }
}

document.addEventListener("DOMContentLoaded", fetchProducts);

document.getElementById("searchInput").oninput = updateResults;

/*-----------profile -------------*/
function showcontent(contentId) {
  // Ẩn tất cả các phần nội dung
  document.querySelectorAll(".main-infor").forEach((content) => {
    content.classList.remove("active");
  });
  // Hiển thị phần nội dung được chọn
  document.getElementById(contentId).classList.add("active");
}

// document.addEventListener("DOMContentLoaded", function () {
//   function enableEdit() {
//     // Bật chỉnh sửa
//     document
//       .querySelectorAll("#profile-form input, #profile-form select")
//       .forEach((input) => {
//         input.disabled = false;
//       });
//     // Hiển thị nút Save và ẩn nút Edit
//     const editButton = document.getElementById("edit-button");
//     const saveButton = document.getElementById("save-button");

//     if (editButton && saveButton) {
//       editButton.style.display = "none";
//       saveButton.style.display = "inline-block";
//     } else {
//       console.error("Edit or Save button not found.");
//     }
//   }

//   function saveProfile() {
//     // Submit form để lưu thông tin
//     const profileForm = document.getElementById("profile-form");
//     if (profileForm) {
//       profileForm.submit();
//     } else {
//       console.error("Profile form not found.");
//     }
//   }

//   // Gán sự kiện vào nút
//   const editButton = document.getElementById("edit-button");
//   const saveButton = document.getElementById("save-button");

//   if (editButton) editButton.onclick = enableEdit;
//   if (saveButton) saveButton.onclick = saveProfile;
// });

// function enableEdit() {
//   document.getElementById("edit-button").style.display = "none";
//   document.getElementById("save-button").style.display = "inline";

//   document.getElementById("username").disabled = false;
//   // document.getElementById("username").style.display = "inline-block";
//   document.getElementById("image-upload").disabled = false;
//   document.getElementById("fullname-user").disabled = false;
//   document.getElementById("email-user").disabled = false;
//   document.getElementById("dob").disabled = false;
//   document.getElementById("gender").disabled = false;
// }

let isEditing = false;

function enableEdit() {
  // Bỏ disabled và hiển thị nút lưu
  isEditing = true; // Bật chế độ chỉnh sửa

  document.getElementById("username").disabled = false;
  document.getElementById("fullname-user").disabled = false;
  document.getElementById("email-user").disabled = false;
  document.getElementById("dob").disabled = false;
  document.getElementById("gender").disabled = false;
  document.getElementById("save-button").style.display = "inline-block"; // Hiện nút Lưu
  document.getElementById("edit-button").style.display = "none"; // Ẩn nút Chỉnh sửa
}

// Hàm gọi để kích hoạt input file khi nhấn vào ảnh
// Khi người dùng nhấn vào ảnh, sẽ kích hoạt input file
// Mở modal khi nhấn vào ảnh
// const imageBox = document.getElementById("image-modal");

function showModal() {
  document.getElementById("popup-box").style.display = "block";
}

// Đóng modal
function closeModal() {
  // imageBox.classList.remove("active");
  document.getElementById("popup-box").style.display = "none";
}

// Hiển thị ảnh khi nhấn nút "Xem ảnh"
function viewImage(event) {
  event.preventDefault();
  const imageUrl = "../<?= $user['profile'] ?? 'image/0.jpg'; ?>"; // Địa chỉ ảnh
  document.getElementById("image-preview").src = imageUrl; // Cập nhật src cho ảnh
  document.getElementById("image-viewer").style.display = "block"; // Hiển thị ảnh trong modal
  closeModal(); // Đóng modal chính nếu cần
}

// Đóng cửa sổ xem ảnh
function closeImageViewer(event) {
  event.preventDefault();
  document.getElementById("image-viewer").style.display = "none"; // Ẩn cửa sổ xem ảnh
}

// Chọn ảnh mới khi nhấn nút "Đổi ảnh"
function changeImage(event) {
  event.preventDefault();

  document.getElementById("image-upload").click(); // Kích hoạt input file để chọn ảnh mới
  closeModal(); // Đóng modal sau khi chọn "Đổi ảnh"
}

// Hiển thị ảnh khi người dùng chọn ảnh mới
function previewImage(event) {
  const file = event.target.files[0]; // Lấy file người dùng chọn
  const reader = new FileReader(); // Khởi tạo FileReader để đọc ảnh

  reader.onload = function () {
    // Cập nhật lại src của ảnh
    document.getElementById("user-image").src = reader.result;
  };

  if (file) {
    reader.readAsDataURL(file); // Đọc file ảnh dưới dạng Data URL
  }
}

// Hàm hiển thị hộp thoại ở vị trí con trỏ chuột
function showBox(event) {
  if (isEditing) {
    var popupBox = document.getElementById("popup-box");
    var mouseX = event.pageX; // Lấy vị trí X của con trỏ chuột
    var mouseY = event.pageY; // Lấy vị trí Y của con trỏ chuột

    popupBox.style.left = mouseX + "px";
    popupBox.style.top = mouseY + "px";

    // Hiển thị hộp thoại
    popupBox.style.display = "block";

    showModal();
  }
}

window.onclick = function (event) {
  var popupBox = document.getElementById("popup-box");
  var box = document.getElementById("user-image");
  // Nếu nhấn ra ngoài hộp thoại, đóng hộp thoại
  if (popupBox && box) {
    if (
      !box.contains(event.target) &&
      !popupBox.contains(event.target) // Kiểm tra nếu nhấn ra ngoài popup
    ) {
      popupBox.style.display = "none"; // Đóng popup
    }
  }
};

function loadPage(page) {
  // Gửi yêu cầu AJAX để lấy dữ liệu của trang mới
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "your-php-file.php?page=" + page, true); // Thay 'your-php-file.php' bằng tên file PHP của bạn
  xhr.onload = function () {
    if (xhr.status === 200) {
      // Chèn kết quả vào trong bảng (hoặc phần HTML khác)
      document.getElementById("order-table-body").innerHTML = xhr.responseText;
      // Cập nhật phân trang
      updatePagination(page);
    }
  };
  xhr.send();
}

function updatePagination(page) {
  var links = document.querySelectorAll(".pagination a");
  links.forEach(function (link) {
    // Remove the 'active' class from all links
    link.classList.remove("active");
  });
  // Set the 'active' class to the current page
  document
    .querySelector(".pagination a:nth-child(" + page + ")")
    .classList.add("active");
}

// function enableEdit() {
//   const isEditing =
//     document.getElementById("edit-button").textContent === "Chỉnh sửa";
//   document
//     .querySelectorAll("#profile-form input, #profile-form select")
//     .forEach((el) => (el.disabled = !isEditing));
//   document.getElementById("edit-button").textContent = isEditing
//     ? "Hủy"
//     : "Chỉnh sửa";
//   document.getElementById("save-button").style.display = isEditing
//     ? "inline-block"
//     : "none";
// }

// document
//   .getElementById("profile-form")
//   .addEventListener("submit", function (e) {
//     // Khóa các trường
//     document
//       .querySelectorAll("#profile-form input, #profile-form select")
//       .forEach((el) => (el.disabled = true));
//     // Đổi nút "Lưu" thành "Chỉnh sửa"
//     document.getElementById("edit-button").textContent = "Chỉnh sửa";
//     document.getElementById("save-button").style.display = "none";
//   });

/*-------------------slide----------------*/
const track = document.querySelector(".carousel-track");
const slidess = Array.from(track.children);
let currentIndex = 0;

function moveToSlide(index) {
  const slideWidth = slidess[0].getBoundingClientRect().width;
  track.style.transform = `translateX(-${index * slideWidth}px)`;
  currentIndex = index;
}

function autoSlide() {
  const nextIndex = (currentIndex + 1) % slidess.length;
  moveToSlide(nextIndex);
}

// Tự động lướt sau mỗi 3 giây
setInterval(autoSlide, 4000);
