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