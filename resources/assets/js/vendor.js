
window._ = require('lodash');
window.Popper = require('popper.js').default;
   

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}
 


window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
 
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
  

require('datatables.net');
require('datatables.net-bs4');



window.moment = require('moment');
window.moment.locale('pt-BR');
  
window.iziToast = require('izitoast');
window.swal = require('sweetalert2');
window.select2 = require('select2');




/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */
import Echo from "laravel-echo"

window.io = require('socket.io-client');

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
    // host: 'http://sgpm.edu.desenvolvimento:6001'
});



// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });