<template>
  <v-tabs >
      <v-tab>
        <v-icon left>
          mdi-account-supervisor-outline
        </v-icon>
        Users
      </v-tab>
      <v-tab>
        <v-icon left>
          mdi-script-text-outline
        </v-icon>
        Roles
      </v-tab>
      <v-tab>
        <v-icon left>
          mdi-wrench-outline
        </v-icon>
        Options
      </v-tab>

      <v-tab-item>
        <v-card flat>
          <v-card-text>
              <Users/>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <Roles/>
          </v-card-text>
        </v-card>
      </v-tab-item>
      <v-tab-item>
        <v-card flat>
            <!---->
            <ChefConf/>
        </v-card>
      </v-tab-item>
    </v-tabs>
</template>
<script>
     import ChefConf from './ChefConf/index.vue';
     import Users from './Users/index.vue';
     import Roles from './Permissions/rolos.vue';
export default {
    components: { Users,ChefConf,Roles },
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
