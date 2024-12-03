const header = document.querySelector("header");

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

let userBtn = document.querySelector("#user-btn");
if (userBtn) {
  userBtn.addEventListener("click", function () {
    let userBox = document.querySelector(".profile-detail");
    userBox.classList.toggle("active");
  });
}

/*----------- scroll event-----------*/
/*const leftArrow = document.querySelector(".left-arrow .bxs-left-arrow"),
  rightArrow = document.querySelector(".right-arrow .bxs-right-arrow"),
  slider = document.querySelector(".slider");

<<<<<<< Updated upstream
/*-------------- home page slider --------------*/
=======
function scrollRight() {
  if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
    slider.scrollTo({
      left: 0,
      behavior: "smooth",
    });
  } else {
    slider.scrollBy({
      left: window.innerWidth,
      behavior: "smooth",
    });
  }
}

function scrollLeft() {
  if (slider.scrollWidth - slider.clientWidth === slider.scrollLeft) {
    slider.scrollTo({
      left: window.innerWidth,
      behavior: "smooth",
    });
  }
}

let timerId = setInterval(scrollRight, 7000);

function resetTimer() {
  clearInterval(timerId);
  timerId = setInterval(scrollRight, 7000);
}

slider.addEventListener("click", function (ev) {
  if (ev.target === leftArrow) {
    scrollLeft();
    resetTimer();
  }
});

slider.addEventListener("click", function (ev) {
  if (ev.target === rightArrow) {
    scrollRight();
    resetTimer();
  }
});
*/
/*-------- slide --------*/
// let slides = document.querySelectorAll(".testimonial-item");
// let index = 0;
// function nextSlide() {
//   slides[index].classList.remove("active");
//   index = (index + 1) % slides.length;
//   slides[index].classList.add("active");
// }

// function prevSlide() {
//   slides[index].classList.remove("active");
//   index = (index - 1 + slides.length) % slides.length;
//   slides[index].classList.add("active");
// }

document.addEventListener("DOMContentLoaded", () => {
  let slides = document.querySelectorAll(".testimonial-item");
  let index = 0;

  window.nextSlide = function () {
    // Gắn hàm vào window để HTML gọi được
    slides[index].classList.remove("active");
    index = (index + 1) % slides.length;
    slides[index].classList.add("active");
  };

  window.prevSlide = function () {
    // Gắn hàm vào window để HTML gọi được
    slides[index].classList.remove("active");
    index = (index - 1 + slides.length) % slides.length;
    slides[index].classList.add("active");
  };
});
>>>>>>> Stashed changes
