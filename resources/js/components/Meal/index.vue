<template>
<div>
    <v-tabs
    v-model="tab"
    >
      <v-tab href="#tab-1">{{$t('publicacoes')}}</v-tab>
      <v-tab href="#tab-2">{{$t('nova_publicacao')}}</v-tab>
    </v-tabs>
    <v-tabs-items v-model="tab" class="pt-4">
        <v-tab-item
            :key="1"
            :value="'tab-' + 1"
        >
        <mealList />
        </v-tab-item>
        <v-tab-item
            :key="2"
            :value="'tab-' + 2"
        >
        <mealNew />
        </v-tab-item>
    </v-tabs-items>

</div>
</template>
<script>
  import mealList from './mealList.vue';
  import mealNew from './MealNew.vue';
export default {
    components: { mealList,mealNew },
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
