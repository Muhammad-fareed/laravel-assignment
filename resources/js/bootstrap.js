window._ = require('lodash');

// Axios for making HTTP requests with CSRF token support
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Bootstrap and jQuery
try {
    window.Popper = require('@popperjs/core').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {
    console.error(e);
}
