export default class NavBarHome {
    constructor() {
        this.containerImg = document.querySelector('.containerImg');
        this.containerWrapper = document.querySelector('.containerWrapper');
        this.action();
    }

    action() {
        this.containerImg.addEventListener('click', () => {
            if (this.containerWrapper.className === 'containerWrapper') {
                this.closeMenu();
            } else {
                this.openMenu();
            }
        })
    }

    openMenu() {
        this.containerWrapper.classList.remove('closedMenu');
    }

    closeMenu() {
        this.containerWrapper.classList.add('closedMenu');
    }
}