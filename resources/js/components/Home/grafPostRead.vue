<template>
  <v-card
    class="mt-4 mx-auto"
    max-width="100%"
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
        Post Read
      </div>
      <div class="subheading font-weight-light grey--text">
        Last Post Read
      </div>
      <v-divider class="my-2"></v-divider>
      <v-icon
        class="mr-2"
        small
      >
        mdi-clock
      </v-icon>
      <span class="caption grey--text font-weight-light">last read {{last}}</span>
    </v-card-text>
  </v-card>
</template>
<script>
  export default {
    data: () => ({
      last:null,
      data:[],
      labels: [
        '1m',
        '2m',
        '3m',
        '4m',
        '5m',
        '6m',
        '7m',
        '8m',
        '9m',
        '10m',
        '11m',
      ],
      value: [
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
        0,
      ],
    }),
    methods:{
        getData(){
        axios
            .get('getPostRead')
            .then(
                response => (this.data = response.data.data,this.last=response.data.last,this.read() )
            );

        },
        read(){
            let arrvalue = [];
            let arrlabels = [];
            this.data.forEach((value, index) => {
               arrvalue.push(value.value);
               arrlabels.push(value.month+'m');
            });
            this.value = arrvalue
            this.labels = arrlabels
            //console.log(this.value )
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
