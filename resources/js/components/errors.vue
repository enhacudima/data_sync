<template>
  <div class="text-center">
    <v-snackbar
      v-model="snackbar"
      :multi-line="multiLine"
      :color="color"
    >
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="white"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>
import EventBus from '../event-bus';
  export default {
    data: () => ({
      multiLine: true,
      snackbar: false,
      text: '',
      color:'red',
    }),
    created () {
    EventBus.$on("snackBar",  (data) => {
      this.color = data.color;
      this.text = data.text;
      this.snackbar = data.model;
    });
  },
  watch: {

  },

}

</script>
