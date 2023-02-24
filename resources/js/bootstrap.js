window._ = require('lodash');

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

const pusherConfig = {
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname,
    wsPort: process.env.MIX_PUSHER_APP_WS_PORT,
    wsPath: process.env.MIX_PUSHER_APP_WS_PATH,
    wssPort: process.env.MIX_PUSHER_APP_WSS_PORT,
    forceTLS: location.protocol === 'https:',
    enabledTransports: ['ws'],
}

if (pusherConfig.forceTLS) {
    pusherConfig.wsPath = process.env.MIX_PUSHER_APP_WSS_PATH;
    pusherConfig.enabledTransports = ['ws', 'wss'];
}

window.Echo = new Echo(pusherConfig);
