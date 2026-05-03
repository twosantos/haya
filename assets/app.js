/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// start the Stimulus application
import './bootstrap';

import { createApp } from 'vue';
import App from './components/App.vue';

const app = createApp(App);

// If you want to make axios available globally in your Vue 3 app like `this.axios` or `this.$axios`:
// import axios from 'axios';
// app.config.globalProperties.axios = axios;
// app.config.globalProperties.$axios = axios;

app.mount('#app');
