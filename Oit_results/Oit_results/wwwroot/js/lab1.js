const btnUp = {
    el: document.querySelector('.btn-up'),
    show() {
        this.el.classList.remove('btn-up_hide');
    },
    hide() {
        this.el.classList.add('btn-up_hide');
    },
    addEventListener() {
        window.addEventListener('scroll', () => {
            const scrollY = window.scrollY || document.documentElement.scrollTop;
            scrollY > 300 ? this.show() : this.hide();
        });
        document.querySelector('.btn-up').onclick = () => {
            window.scrollTo({
                top: 0,
                left: 0,
                behavior: 'smooth'
            });
        }
    }
}

btnUp.addEventListener();


function openImageWindow(src) {
    var window = document.querySelector('.window-img')
    window.classList.remove('window-img_hide')
    window.children[0].src = src
}
function closeImageWindow(){
    var window = document.querySelector('.window-img')
    window.classList.add('window-img_hide')

}