<template>
<div>
    <v-tabs
    v-model="tab"
    >
      <v-tab href="#tab-1">Chef Level</v-tab>
      <v-tab href="#tab-2">Other Options</v-tab>
    </v-tabs>
    <v-tabs-items v-model="tab" class="pt-4">
        <v-tab-item
            :key="1"
            :value="'tab-' + 1"
        >
        <Experience/>
        </v-tab-item>        
        <v-tab-item
            :key="2"
            :value="'tab-' + 2"
        >
        Comming soon
        </v-tab-item>
    </v-tabs-items>
          
</div>
</template>
<script>
import Experience from "./Experience.vue";
export default {
    
    components: { Experience },
    data() {
        return {
            tab:null,

        }
    },
    methods: {

        },
    mounted() {
     
    },
        
    watch: {
    }
}
</script>