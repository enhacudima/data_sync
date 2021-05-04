<template>
  <v-app id="inspire" >
    <v-app-bar
      app
      clipped-right
      flat
      height="72"
      color="#867666"
    >
    <v-app-bar-nav-icon color="white"  @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-spacer></v-spacer>
            <v-img
             v-if="!drawer"
                src="storage/icons/CP - AF_70px negative.png"
                lazy-src="storage/icons/CP - AF_70px negative.png"
                aspect-ratio="2"
                max-height="70"
                max-width="200"
                contain
            ></v-img>
    <!--
      <v-responsive max-width="500">
        <v-text-field
          dense
          flat
          hide-details
          rounded
          solo-inverted
          :placeholder="$t('search')+' todos'"
        ></v-text-field>
      </v-responsive>-->
      <v-spacer></v-spacer>

        <div class="pr-2">
            <router-link to="/login" tag="button">
            <v-btn
            text
            small
            color="white"
            >
            <v-icon>mdi-account</v-icon>
            {{$t('login')}}
            </v-btn>

            </router-link>
        </div>
    </v-app-bar>

    <v-navigation-drawer
      v-model="drawer"
      app
      color="grey lighten-4"
    >
        <v-sheet
            class="pa-4"
            color="grey lighten-4"
        >
    <v-img
        src="storage/icons/110x92px.png"
        lazy-src="storage/icons/110x92px.png"
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

        <v-row
        class="fill-height ma-0"
        align="center"
        justify="center"
        >
        DataSync
        </v-row>

        <v-row
        class="fill-height ma-0"
        align="center"
        justify="center"
        >

        <v-col cols="8">
            <v-select
            v-model="my_lang"
            :items="langs"
            menu-props="auto"
            label="en"
            hide-details
            prepend-icon="mdi-translate"
            single-line
            @change="changeLocale(my_lang)"
            >
                <template v-slot:selection="{ item }">
                  {{ item.replaceAll('_', ' ').toUpperCase() }}
                </template>
                <template  v-slot:item="{ item }">
                  {{ item.replaceAll('_', ' ').toUpperCase()}}
                </template>
            </v-select>
        </v-col>

        </v-row>

        </v-sheet>
      <v-divider></v-divider>

      <v-list>
        <v-list-item
          v-for="(linkName, index)  in linksNames"
          :key="linkName"
          :to="links[index]"
          link
        >
          <v-list-item-icon>
            <v-icon>{{ icons[index] }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content>
            <v-list-item-title>{{ $t(linkName) }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-main>
      <v-container
         class="py-8 px-6 mb-8"
        fluid
      >
        <v-row>
          <v-col
            cols="12"
          >
          <!---->
          <slot/>
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
    <div class="main-wrapper">
        <cookie-law theme="blood-orange--rounded"></cookie-law>
    </div>
  </v-app>
</template>

<script>
import CookieLaw from 'vue-cookie-law';
import {i18n} from '../../../i18n.js'
  export default {
    components: { CookieLaw },
    name: 'locale-changer',

    methods: {
    changeLocale(locale) {
        i18n.locale = locale;
    }
    },

    data: () => ({
      my_lang:'pt_BR',
      langs: ['en', 'pt_BR'] ,
      states:[],
      drawer: false,
      iconsFoot: [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ],
      linksNames: [
        'Publicações',
        'about_us',
        'contact',
        'terms_and_conditions',
      ],
      links:[
        '/',
        'about',
        'contact',
        'terms',
      ],
      icons: [
        'mdi-view-grid',
        'mdi-information',
        'mdi-phone',
        'mdi-hammer-screwdriver',
      ],
    }),
  }
</script>

<style >
.theme--light.v-application {
    background: #f5f5f5;
    color: rgba(0, 0, 0, 0.87);
}

</style>

