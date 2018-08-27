<template>
    <li class="todo__item" :class="{ done: item.completed }">
      <CheckIcon :checked="item.completed" @input="updateItem"/>
      {{ item.text }}
      <a href="javascript:void(0)" class="todo__item__delete-icon" @click="deleteItem">
        <i class="far fa-trash-alt"></i>
      </a>
    </li>
</template>
<script>
import CheckIcon from './CheckIcon.vue';

export default {
  name: 'TodoList',
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  components: { CheckIcon },
  methods: {
    updateItem: function () {
      this.$store.dispatch(
        'toggleCompleted',
        this.item
      );
    },
    deleteItem: function() {
      this.$store.dispatch(
        'deleteItem',
        this.item
      );
    }
  }
}
</script>
