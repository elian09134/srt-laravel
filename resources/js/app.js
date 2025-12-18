import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// import animations (IntersectionObserver reveals, etc.)
import './animations';
// expose axios already in bootstrap; nothing else needed here
