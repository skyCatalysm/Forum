import '../scss/app.scss';
import Vue from 'vue';
import App from '../components/App';

new Vue({
    delimiters: ['${', '}'],
    el: '#app',
    render: h => h(App)
});