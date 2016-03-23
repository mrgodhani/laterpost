<template>
  <div class="modal-mask" v-show="show" transition="modal">
    <div class="modal-wrapper">
      <div class="modal-container" v-bind:class="{ 'modal-large' : large }">
        <div class="modal-body">
          <slot name="body">
          </slot>
        </div>
        <div class="modal-footer">
          <slot name="footer">
            <button class="btn btn-default"
            @click="show = false">
            Cancel
            </button>
            <button class="btn btn-primary"
              @click="show = false">
              Schedule
            </button>
          </slot>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
      show: {
        type: Boolean,
        required: true,
        twoWay: true
      },
      large: {
        type: Boolean
      }
  }
}
</script>
