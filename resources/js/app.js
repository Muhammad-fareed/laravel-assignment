// Importing Bootstrap and AdminLTE
import 'bootstrap/dist/css/bootstrap.min.css'; // Bootstrap CSS
import 'bootstrap'; // Bootstrap JS
import 'jquery'; // jQuery required for Bootstrap and AdminLTE
import 'admin-lte/dist/css/adminlte.min.css'; // AdminLTE CSS
import 'admin-lte/dist/js/adminlte.min.js'; // AdminLTE JS

// Existing Alpine.js setup from Breeze
import './bootstrap'; // Optional Bootstrap JS setup that comes with Laravel (can be removed if handled via npm above)
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
