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
            EatInMore Store
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
                <v-row
                justify="center"
                align="center"
                >
                    <v-col
                    xs="12"
                    sm="4"
                    md="4"
                    lg="4"
                    xl="4"
                    align="center"
                    >
                    <v-row>
                        <v-col
                        xs="6"
                        sm="6"
                        md="6"
                        lg="6"
                        xl="6"
                        >
                            <v-img
                                src="storage/icons/android.png"
                                lazy-src="storage/icons/android.png"
                                max-height="500"
                                max-width="250"
                            >
                                <template v-slot:placeholder>
                                <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                >
                                    <v-progress-circular
                                    indeterminate
                                    color="grey lighten-5"
                                    ></v-progress-circular>
                                </v-row>
                                </template>
                            </v-img>
                        </v-col>


                        <v-col
                        xs="6"
                        sm="6"
                        md="6"
                        lg="6"
                        xl="6"
                        >
                            <v-img
                                src="storage/icons/qrcod.png"
                                lazy-src="storage/icons/qrcod.png"
                                max-height="500"
                                max-width="250"
                            >
                                <template v-slot:placeholder>
                                <v-row
                                    class="fill-height ma-0"
                                    align="center"
                                    justify="center"
                                >
                                    <v-progress-circular
                                    indeterminate
                                    color="grey lighten-5"
                                    ></v-progress-circular>
                                </v-row>
                                </template>
                            </v-img>
                        </v-col>
                    </v-row>

                    <v-subheader>It is currently not possible to process your order, please use the android application</v-subheader>

                    </v-col>

                </v-row>
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
  export default {
    components: { },
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
