<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
      color="white"
    >
        <v-sheet
            class="pa-4"
            color="white"
        >
            <v-img
                :src="baseUrl+'storage/icons/110x92px.png'"
                :lazy-src="baseUrl+'storage/icons/110x92px.png'"
                aspect-ratio="2"
                max-height="95"
                max-width="250"
                contain
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
        </v-sheet>
    </v-navigation-drawer>

    <v-main>
      <v-container
         class="py-8 px-6 mb-8"
        fluid
      >
        <v-row>
            <v-col cols="12">
                <v-card class="mx-auto" max-width="1000" tile>
                    <!--<v-img height="200" :src="baseUrl+'storage/icons/fundo.jpg'"
                    lazy-src="storage/icons/fundo.jpeg"
                    ></v-img>-->
                    <v-row style="margin:2.5%; top: 0px">

                                <v-list-item dense>
                                <v-list-item-avatar size="100">
                                    <img
                                        v-if="meal.meal_user"
                                        :src="baseUrl+'storage/'+meal.meal_user.avatar"
                                        :lazy-src="baseUrl+'storage/'+meal.meal_user.avatar"
                                    >
                                    </v-list-item-avatar>
                                    <v-list-item-content>
                                    <v-list-item-title class="title" style="margin-top:20px;" v-if="meal.meal_user">{{meal.meal_user.name}} {{meal.meal_user.lastName}} </v-list-item-title>

                                    </v-list-item-content>
                                </v-list-item>
                                <v-list-item dense>
                                    <v-list-item-icon>
                                    <v-icon color="#867666">
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
                                    <v-icon color="#867666">
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
                                    <v-icon color="#867666">
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
                                    <v-icon color="#867666">
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
                                    <v-icon color="#867666">
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
                                        <vue-pdf
                                            v-if="meal.meal_file"
                                            :src="baseUrl+'storage/'+meal.meal_file.path+meal.meal_file.name"
                                            @num-pages="pageCount = $event"
                                            @page-loaded="currentPage = $event"
                                            :page="currentPage"
                                            @progress="loadedRatio = $event"
                                            @error="error"
                                            @link-clicked="currentPage = $event"
                                            :style="'border: 1px solid red; display: inline-block; width: '+percent+'%'"
                                        />
                                        </v-list-item-action-text>
                                    </v-list-item-content>
                                </v-list-item>
                    </v-row>
                </v-card>

          </v-col>
        </v-row>
      </v-container>
    </v-main>

    <v-footer padless fixed app color="#867666">

      <v-col
        class="text-center"
        cols="12"
      >
       <div
            :class="[`text-caption`]"
            class="transition-swing white--text ml-4"
        >
         &copy;{{ new Date().getFullYear() }} — Um produto da <b>Data Sync, Limitada</b>
        </div>
      </v-col>
    </v-footer>
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
        .then(response => (this.meal = response.data, console.log(this.meal)));
    },

  }
</script>
<style >
.theme--light.v-application {
    background: #f5f5f5;
    color: rgb(250, 250, 250);
}

</style>
