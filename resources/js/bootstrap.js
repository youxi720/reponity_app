/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
import Pusher from 'pusher-js';
import Echo from 'laravel-echo/dist/echo.common.js';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,  // 環境変数に置き換え
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'ap3',  // 環境変数に置き換え
    forceTLS: true
});