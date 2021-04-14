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
                                :src="baseUrl+'storage/'+meal.meal_user.avatar"
                                :lazy-src="baseUrl+'storage/'+meal.meal_user.avatar"
                            >
                            </v-list-item-avatar>
                            <v-list-item-content>
                            <v-list-item-title class="title" style="margin-top:20px;">{{meal.meal_user.name}} {{meal.meal_user.lastName}} </v-list-item-title>

                            </v-list-item-content>
                        </v-list-item>
                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-phone
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>{{meal.phone}}</v-list-item-title>
                            <v-list-item-subtitle>Phone</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-icon>
                            <v-icon>mdi-message-text</v-icon>
                            </v-list-item-icon>
                        </v-list-item>


                        <v-divider inset></v-divider>

                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-web
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title><a :href="meal.web" >{{meal.web}}</a></v-list-item-title>
                            <v-list-item-subtitle>Website</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-icon>
                            <v-icon>mdi-mouse</v-icon>
                            </v-list-item-icon>
                        </v-list-item>


                        <v-divider inset></v-divider>

                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-email
                            </v-icon>
                            </v-list-item-icon>

                            <v-list-item-content>
                            <v-list-item-title>{{meal.email}}</v-list-item-title>
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
                            <v-list-item-title></v-list-item-title>
                            <v-list-item-subtitle>{{meal.location}}</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-icon>
                            </v-list-item-icon>
                        </v-list-item>


                        <v-divider inset></v-divider>

                        <v-list-item dense>
                            <v-list-item-icon>
                            </v-list-item-icon>

                            <v-list-item-content v-if="meal.details">
                            <v-list-item-title> {{meal.name}}</v-list-item-title>
                            <v-list-item-action-text>{{meal.details}}</v-list-item-action-text>
                            </v-list-item-content>
                        </v-list-item>
                        <v-divider inset></v-divider>
                        <v-list-item dense>
                            <v-list-item-icon>
                            <v-icon color="indigo">
                                mdi-file-pdf
                            </v-icon>
                            </v-list-item-icon>
                            <v-list-item-content >
                                <v-list-item-title>
                                    <input v-model.number="currentPage" type="number" style="width: 3em" /> /{{pageCount}}
                                    <v-btn
                                    icon
                                    color="pink"
                                    @click="page('previous')"
                                    >
                                    <v-icon>mdi-skip-previous</v-icon>
                                    </v-btn>

                                    <v-btn
                                    icon
                                    color="pink"
                                    @click="page('next')"
                                    >
                                    <v-icon>mdi-skip-next</v-icon>
                                    </v-btn>


                                    <v-btn
                                    small
                                    icon
                                    color="pink"
                                    @click="zoon('previous')"
                                    >
                                    <v-icon>mdi-magnify-minus</v-icon>
                                    </v-btn>

                                    <v-btn
                                    small
                                    icon
                                    color="pink"
                                    @click="zoon('next')"
                                    >
                                    <v-icon>mdi-magnify-plus</v-icon>
                                    </v-btn>
                                    {{percent}}%
                                </v-list-item-title>
                                <v-list-item-action-text>
                                <template>
                                <vue-pdf
                                    :src="baseUrl+'storage/'+meal.meal_file.path+meal.meal_file.name"
                                    @num-pages="pageCount = $event"
                                    @page-loaded="currentPage = $event"
                                    :page="currentPage"
                                    @progress="loadedRatio = $event"
                                    @error="error"
                                    @link-clicked="currentPage = $event"
                                    :style="'border: 1px solid red; display: inline-block; width: '+percent+'%'"
                                />
                                </template>
                                </v-list-item-action-text>
                            </v-list-item-content>
                        </v-list-item>
                         <v-divider inset></v-divider>



            </v-row>
        </v-card>
    </v-main>
  </v-app>
</template>

<script>
import vuePdf from 'vue-pdf-worker-fix'
  export default {


    components: {
        vuePdf
    },

    data() {

        return {
            baseUrl:'http://localhost/data_sync/public/',
            drawer:true,
            meal:[],
            profile:[],
            chef:[],
            currentPage: 1,
            pageCount: 0,
            percent:100,
        }

    },

    computed: {
        token(){
            return this.$route.params.token;
        },
    },
    methods: {
        error: function(err) {
        console.log(err);
        },
        page(action){
            if(action == "next"){

                this.currentPage = ++this.currentPage;
            }else{
                this.currentPage = --this.currentPage;
            }
        },
        zoon(action){
            if(action == "next"){

                this.percent = this.percent+10;
            }else{
                this.percent = this.percent-10;
            }
        }
    },
    mounted() {
    axios
        .get('pub/'+this.token)
        .then(response => (this.meal = response.data));
    },

  }
</script>
