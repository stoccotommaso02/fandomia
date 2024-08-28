// JavaScript to toggle the hamburger menu
document.getElementById("hamburger").addEventListener("click", function() {
  var menuList = document.getElementById("menuList");
  var hamburger = document.getElementById("hamburger");
  var isActive = menuList.classList.toggle("active");

  // Update aria-expanded attribute based on visibility
  hamburger.setAttribute("aria-expanded", isActive);
  this.classList.toggle("active", isActive);
});
