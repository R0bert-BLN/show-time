import Alpine from 'alpinejs';

import {dropdown} from './components/dropdown.js';
import {buttons} from "./components/buttons.js";
import {tables} from "./components/tables.js";
import {colors} from "./components/colors.js";
import {bandsSubForms} from "./components/bandsSubForms.js";
import {notification} from "./components/notification.js";

window.Alpine = Alpine;

document.addEventListener('turbo:load', () => {
    Alpine.start();
});

document.addEventListener('alpine:init', () => {
    Alpine.data('dropdown', dropdown);
    Alpine.data('buttons', buttons);
    Alpine.data('tables', tables);
    Alpine.data('colors', colors);
    Alpine.data('bandsSubForms', bandsSubForms);
    Alpine.data('notification', notification);
});
