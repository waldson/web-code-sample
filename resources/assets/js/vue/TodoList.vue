<template>
  <ul class="todo__list" v-if="items.length > 0">
    <TodoItem
      v-for="item in items"
      :item="item"
      :key="item.id"
    />
  </ul>
  <div v-else class="todo__empty">No items</div>
</template>
<script>
import TodoItem from './TodoItem.vue';

export default {
  name: 'TodoList',
  props: {
    items: {
      type: Array,
      required: true
    }
  },
  components: { TodoItem }
}
</script>
