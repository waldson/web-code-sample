<template>
  <a href="javascript:void(0)" @click="toggle" class="check-icon">
    <i class="far fa-check-square" v-if="checked"></i>
    <i class="far fa-square" v-else></i>
  </a>
</template>
<script>
export default {
  name: 'CheckIcon',
  props: {
    checked: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    toggle: function () {
      this.$emit('input', !this.checked);
    }
  }
}
</script>
<style lang="scss" scoped>
</style>
