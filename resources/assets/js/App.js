import Vue from 'vue';

import TodoListApp from './vue/TodoApp.vue';
import store from './vue/store/todo.js';


new Vue({
  el: '#app',
  template: '<TodoListApp />',
  components: { TodoListApp },
  store,
});


