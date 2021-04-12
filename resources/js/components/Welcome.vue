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
        v-for="n in 6"
        :key="n"
        :color="`grey ${n === 1 ? 'darken' : 'lighten'}-1`"
        :size="n === 1 ? 36 : 20"
        class="d-block text-center mx-auto mb-9"
      ></v-avatar>
    </v-navigation-drawer>

    <v-main>

    <v-card
      elevation="2"
      loading
    ></v-card>

  <v-card
    :loading="loading"
    class="mx-auto my-12"
    max-width="200"
    contain
  >
    <template slot="progress">
      <v-progress-linear
        color="deep-purple"
        height="10"
        indeterminate
      ></v-progress-linear>
    </template>

    <v-img
      height="250"
      src="storage/icons/icon.jpg"
    ></v-img>

    <v-card-title>EatInMore</v-card-title>

    <v-divider class="mx-4"></v-divider>

    <v-card-actions>
      <router-link to="/register" class="nav-item nav-link">
      <v-btn
        color="deep-purple lighten-2"
        text
        
      >
        Login or Register
      </v-btn>
      </router-link>
    </v-card-actions>
  </v-card>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data: () => ({ drawer: null }),
  }
</script>


<style>
#components-layout-demo-basic {
  text-align: center;     
}
#components-layout-demo-basic .ant-layout-header,
#components-layout-demo-basic .ant-layout-footer {
 
}
#components-layout-demo-basic .ant-layout-footer {
  line-height: 1.5;
}
#components-layout-demo-basic .ant-layout-content {
  min-height: 120px;
  line-height: 120px;
  margin-top: 10vh;
}
#components-layout-demo-basic > .ant-layout {
  height: 100vh;
}
#components-layout-demo-basic > .ant-layout:last-child {
}
.picture_avatar_welcome {
  width: 200px;
  height: 250px;
}
</style>