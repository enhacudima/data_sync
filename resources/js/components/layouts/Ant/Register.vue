<template>
<div>
  <nprogress-container></nprogress-container>
  <v-app id="inspire">

    <v-main class="grey lighten-3">
      <v-container>
            <v-row align="center" justify="center" class="pt-1e pt-md-2 mt-md-2" >
                <v-img
                    src="storage/icons/110x92px.jpg"
                    lazy-src="storage/icons/110x92px.jpg"
                    aspect-ratio="2"
                    max-height="200"
                    max-width="130"
                    contain
                    to="/"
                >
                </v-img>
            </v-row>
            <v-row align="center" justify="center" >

            <v-col
                cols="12"
                sm="5"
                class="pt-6"

            >
                <div
                min-height="30vh"
                rounded="lg"
                >
                 <slot/>
                 <v-row class="mt-6">
                    <v-col cols="4">

                    <!--
                    <div class="locale-changer">
                        <select v-model="$i18n.locale">
                        <option v-for="(lang, i) in langs" :key="`Lang${i}`" :value="lang">
                            {{ lang.replaceAll('_', ' ').toUpperCase()}}
                        </option>
                        </select>
                    </div>
                        <v-select
                        v-model="my_lang"
                        :items="langs"
                        :label="$t('language')"
                        dense
                        outlined
                        @change="changeLocale(my_lang)"
                        >
                            <template v-slot:selection="{ item }">
                            {{ item.replaceAll('_', ' ').toUpperCase() }}
                            </template>
                            <template  v-slot:item="{ item }">
                            {{ item.replaceAll('_', ' ').toUpperCase()}}
                            </template>
                        </v-select>
                        -->
                    </v-col>
                 </v-row>
                </div>
            </v-col>


            </v-row>
      </v-container>
    </v-main>
  </v-app>
  </div>
</template>

<script>
import NprogressContainer from 'vue-nprogress/src/NprogressContainer'
import {i18n} from '../../../i18n.js'
  export default {
    components: {
        NprogressContainer
    },
    name: 'locale-changer',
    methods: {
    changeLocale(locale) {
        i18n.locale = locale;
    }
    },
    data: () => ({
      my_lang:'en',
      langs: ['en', 'pt'] ,
    }),
  }
</script>
