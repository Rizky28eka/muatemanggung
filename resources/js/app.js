import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.Alpine = Alpine;
Alpine.start();

AOS.init({
    duration: 700,
    easing: 'ease-out-cubic',
    once: true,
    offset: 60,
    delay: 0,
});
