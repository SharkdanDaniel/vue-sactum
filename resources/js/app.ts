import './bootstrap';

import { createApp } from '@vue/runtime-dom';
import { Quasar, Notify, Dialog, QNotifyCreateOptions } from 'quasar';
import { createPinia } from 'pinia'
import quasarIconSet from 'quasar/icon-set/fontawesome-v6';

// Import Vue Cropper
import 'cropperjs/dist/cropper.css';

// Import icon libraries
import '@quasar/extras/roboto-font/roboto-font.css';
import '@quasar/extras/fontawesome-v6/fontawesome-v6.css';

// Import Quasar css
import 'quasar/src/css/index.sass';

import app from './App.vue';
import router from './router';

const pinia = createPinia()

const notifyConfig: QNotifyCreateOptions = {
    timeout: 10000,
    progress: true,
    actions: [{ icon: 'fa-solid fa-xmark', color: 'white', handler: () => { } }]
}

createApp(app)
    .use(pinia)
    .use(router)
    .use(Quasar, {
        plugins: { Notify, Dialog },
        config: { notify: notifyConfig },
        iconSet: quasarIconSet,
        animations: 'all'
    })
    .mount('#app')
