const openButton = document.getElementById('openmenu');
const closeButton = document.getElementById('closemenu');
const media = window.matchMedia('(width < 760px');
const collapsable = document.getElementById('collapsable');
const menuList = document.getElementById('menuList');

function setupMenu(e) {
    if(e.matches) {
        collapsable.setAttribute('inert', '');
        menuList.style.transition = 'none';
    } else {
        collapsable.removeAttribute('inert', '');
    }
}

function openMenu() {
    openButton.setAttribute('aria-expanded', 'true');
    collapsable.removeAttribute('inert');
    menuList.removeAttribute('style');
}

function closeMenu() {
    openButton.setAttribute('aria-expanded', 'false');
    collapsable.setAttribute('inert', '');

    setTimeout(() => {
        menuList.style.transition = 'none';
    }, 500);
}

setupMenu(media);
media.addEventListener('change',function(e) {
    setupMenu(e);
})
openButton.addEventListener('click', openMenu);
closeButton.addEventListener('click', closeMenu);



// // progressive enchancement
// document.addEventListener('DOMContentLoaded', function(event) 
// {
//     let hamburger = document.getElementById('hamburger');
//     // If JS is enabled, it will un-expand the hamburger
//     hamburger.setAttribute('aria-expanded', 'false');
//     hamburger.onclick = function()
//     {   
//         if(this.getAttribute('aria-expanded') == 'false')
//         {
//             this.setAttribute('aria-expanded', 'true');
//         }else{
//             this.setAttribute('aria-expanded', 'false');
//         }
//     }
// });

// // JavaScript to toggle the hamburger menu
// document.getElementById("hamburger").addEventListener("click", function() {
//   var menuList = document.getElementById("menuList");
//   var hamburger = document.getElementById("hamburger");
//   var isActive = menuList.classList.toggle("active");

//   // Update aria-expanded attribute based on visibility
//   hamburger.setAttribute("aria-expanded", isActive);
//   this.classList.toggle("active", isActive);
// });
