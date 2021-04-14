<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      class="pt-4"
      color="grey lighten-3"
      mini-variant
    >
      <v-avatar
        class="d-block text-center mx-auto mb-9"
      >
      <img
        :src="baseUrl+'storage/icons/40x40px.jpg'"
        :lazy-src="baseUrl+'storage/icons/40x40px.jpg'"
        alt="logo"
      ></v-avatar>
    </v-navigation-drawer>

    <v-main>
        <v-card class="mx-auto" max-width="1000" tile>
            <v-img height="200" :src="baseUrl+'storage/icons/fundo.jpg'"
            lazy-src="storage/icons/fundo.jpeg"
            ></v-img>
            <v-row style="margin:2.5%;position:absolute; top: 130px">

                        <v-list-item dense>
                        <v-list-item-avatar size="100">
                            <img
                                :src="baseUrl+'storage/'+user.avatar"
                                :lazy-src="baseUrl+'storage/'+user.avatar"
                            >
                            </v-list-item-avatar>
                            <v-list-item-content>
                            <v-list-item-title class="title" style="margin-top:20px;">{{user.name}} {{user.lastName}} </v-list-item-title>

                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-phone
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>+{{user.phone1}}</v-list-item-title>
                            <v-list-item-subtitle>Phone</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-icon>
                            <v-icon>mdi-message-text</v-icon>
                            </v-list-item-icon>
                        </v-list-item>


                        <v-divider inset></v-divider>


                        <v-divider inset></v-divider>

                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-email
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>{{user.email}}</v-list-item-title>
                            <v-list-item-subtitle>Email</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-icon>
                            </v-list-item-icon>

                        </v-list-item>

                        <v-divider inset></v-divider>

                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-map-marker
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>{{user.country}}</v-list-item-title>
                            <v-list-item-subtitle>{{user.address}}</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-icon>
                            </v-list-item-icon>
                        </v-list-item>


                        <v-divider inset></v-divider>
            </v-row>
        </v-card>
    </v-main>
  </v-app>
</template>

<script>
  export default {


    data() {

        return {
            baseUrl:'http://localhost/data_sync/public/',
            drawer:true,
            user:[],
            profile:[],
            chef:[],
        }

    },

    computed: {
        token(){
            return this.$route.params.token;
        },
    },
    methods: {
    },
    mounted() {
    axios
        .get('user/profile/'+this.token)
        .then(response => (this.user = response.data));
    },

  }
</script>
