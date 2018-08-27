<template>
  <div class="w-100">
    <h1 class="title">Sample To-Do</h1>
    <div class="todo-entry__container">
      <input
        ref="todoInput"
        class="todo-entry__input"
        type="text"
        value=""
        placeholder="New item"
        title="Press enter to submit a new item"
        v-model="newTodo"
        @keyup.enter="addTodo"/>
    </div>
    <div class="todo__filters">
      <a href="javascript:void(0)"
        class="todo__filter"
        @click="() => this.filter = 'all'"
        :class="{ active: filter == 'all' }"
      >
        All <span v-if="items.length > 0">({{ items.length }})</span>
      </a> |

      <a href="javascript:void(0)"
        class="todo__filter"
        @click="() => this.filter = 'open'"
        :class="{ active: filter == 'open' }"
      >
        Open <span v-if="openItems.length > 0">({{ openItems.length }})</span>
      </a> |

      <a href="javascript:void(0)"
        class="todo__filter"
        @click="() => this.filter = 'completed'"
        :class="{ active: filter == 'completed' }"
      >
        Completed <span v-if="completedItems.length > 0">({{ completedItems.length }})</span>
      </a>
    </div>
    <TodoList :items="activeItems" />
  </div>
</template>
<script>
import uuid from 'uuid/v4';

import TodoList from './TodoList.vue';

export default {
  name: 'TodoApp',
  data: () => ({
    newTodo: '',
    filter: 'all'
  }),
  methods: {
    addTodo: function() {
      if (!this.newTodo) {
        return;
      }

      const todo = {
        uuid: uuid(),
        text: this.newTodo,
        created_at: new Date(),
        completed: false,
        completed_at: null
      };

      this.$store.dispatch('addItem', todo);
      this.newTodo = '';
    }
  },
  components: { TodoList },
  computed: {
    activeItems: function () {
      switch (this.filter) {
        case 'open':
          return this.openItems;
        case 'completed':
          return this.completedItems;
        default:
          return this.items;
      }
    },
    items: function () {
      return this.$store.getters.items;
    },
    openItems: function () {
      return this.$store.getters.openItems;
    },
    completedItems: function () {
      return this.$store.getters.completedItems;
    }
  },
  created: function() {
    this.$store.dispatch('fetchItems');
  },
  mounted: function () {
    this.$refs.todoInput.focus();
  }
}
</script>
