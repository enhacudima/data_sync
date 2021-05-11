<template>
  <v-card
    class="mt-4 mx-auto"
    max-width="400"
  >
    <v-sheet
      class="v-sheet--offset mx-auto"
      color="cyan"
      elevation="12"
      max-width="calc(100% - 32px)"
    >
      <v-sparkline
        :labels="labels"
        :value="value"
        color="white"
        line-width="2"
        padding="16"
      ></v-sparkline>
    </v-sheet>

    <v-card-text class="pt-0">
      <div class="title font-weight-light mb-2">
        User Creation
      </div>
      <div class="subheading font-weight-light grey--text">
        Last User Performance
      </div>
      <v-divider class="my-2"></v-divider>
      <v-icon
        class="mr-2"
        small
      >
        mdi-clock
      </v-icon>
      <span class="caption grey--text font-weight-light">last registration {{last}}</span>
    </v-card-text>
  </v-card>
</template>
<script>
  export default {
    data: () => ({
      last:null,
      data:[],
      labels: [
        '12am',
        '3am',
        '6am',
        '9am',
        '12pm',
        '3pm',
        '6pm',
        '9pm',
      ],
      value: [
        200,
        675,
        410,
        390,
        310,
        460,
        250,
        240,
      ],
    }),
    methods:{
        getData(){
            console.log(this.labels);
        axios
            .get('grafUser')
            .then(
                response => (this.data = response.data.data,this.last=response.data.last,this.read() )
            );

        },
        read(){
            let arrvalue = [];
            let arrlabels = [];
            this.data.forEach((value, index) => {
               arrvalue.push(value.value);
               arrlabels.push(value.month+'Mon');
            });
            this.value = arrvalue
            this.labels = arrlabels
        }
    },
    mounted(){
        this.getData()

    }
  }
</script>
<style>
  .v-sheet--offset {
    top: -24px;
    position: relative;
  }
</style>
