import './bootstrap';

import { createApp } from '@vue/runtime-dom';
import { Quasar, Notify, QNotifyCreateOptions } from 'quasar';
import quasarIconSet from 'quasar/icon-set/fontawesome-v6';

// Import icon libraries
import '@quasar/extras/roboto-font/roboto-font.css';
import '@quasar/extras/fontawesome-v6/fontawesome-v6.css';

// Import Quasar css
import 'quasar/src/css/index.sass';

import app from './App.vue';
import router from './router';

const notifyConfig: QNotifyCreateOptions = {
    position: 'top-right',
    timeout: 10000,
    progress: true,
    actions: [{ icon: 'fa-solid fa-xmark', color: 'white', handler: () => { } }]
}

createApp(app)
    .use(router)
    .use(Quasar, {
        plugins: { Notify },
        config: { notify: notifyConfig },
        iconSet: quasarIconSet
    })
    .mount('#app')
