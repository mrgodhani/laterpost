<template>
  <input type="text"
          v-el:input
          v-model='model'
          lazy
          :name='name'
          :placeholder='placeholder' class="form-control" />
</template>
<script>
export default {
  props: {
    model: {
      twoWay: true
    },
    name: {},
    placeholder: {}
  },
  ready() {
    $(this.$els.input).datetimepicker();
  }
}
