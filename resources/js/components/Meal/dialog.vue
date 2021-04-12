<template>
  <v-row justify="center">
    <v-dialog
      v-model="showDialog"
      fullscreen
      hide-overlay
      transition="dialog-bottom-transition"
    >
      <v-card>        
        <v-toolbar
          dark
          background-color="indigo"
          fixed-tabs
        >
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn
              dark
              text
              @click="showDialog = false"
            >
            <v-icon>mdi-close</v-icon>
              Close
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-title>
        </v-card-title>
        <v-card-text>
          <v-container>
              <mealEdit v-bind:codMealId="codMeal"/>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  import mealEdit from './MealEdit.vue';
  export default {
    components: { mealEdit},
    props: {
        value: Boolean,
        codMeal: {
            type:Number
        },
    },
    created () {
        //console.log(this.codMeal)
    },
    data() {
        return {
           
        }
    },
 
    computed: {
        showDialog: {
        get () {
            return this.value
        },
        set (value) {
            this.$emit('input', value)
        }
        },
    },
    mounted() {
      //console.log(this.codMeal)
        
    },
    watch: {
    codMeal (val, oldVal) {
      //console.log(val)
    }
    }
    
  }
</script>