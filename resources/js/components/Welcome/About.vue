<template>
<div  >
    <v-row>
    <v-col cols="12" >
    <p class="font-weight-black">
      ABOUT US
    </p>
    <section id="Brand">
        <p class="font-weight-medium">
        Our Brand: EatInMore.
        </p>
        <p class="font-weight-light">
            Stay home and allow the chef to come to the comfort of your own home. it is with this concept that EatInMore intends to bring a unique culinary experience to your home through chefs with experience in hospitality industry, some chefs come with Michelin stars in their curriculum vitae. EatInMore also reveals the idea that renowned chefs are always access. Using EatInMore is as simple as booking a restaurant or hotel at the comfort of your own home, without the hassle of preparing dinner at home yourself. All you need to do is to book the chef and enjoy your favorite meals from home. On the day of the event, the chef buys the freshest ingredients, brings the kitchen kit, prepares and serves the meal.
        </p>
    </section>

    <section id="Mission">
        <p class="font-weight-medium" >
        Mission.
        </p>
        <p class="font-weight-light">
            EatInMore is a chefs’ application with the aim to provide an excellent cooking experience and a remarkable service to our clients, by giving them the best chefs the world has to offer to cook for them at the comfort of their own home and also provide an innovative approach into the culinary field.
        </p>
    </section>

    <section id="Vision">
        <p class="font-weight-light">
            We believe that with communication technologies everything can be available to everyone and without decreasing quality. EatInMore brings to you, not a new concept, but an improved one the world of culinary has to offer, that simply means taking the best restaurants to our customer’s home.
        </p>
    </section>
    <section id="WORKS">
        <p class="font-weight-medium">
        HOW IT WORKS.
        </p>

            <p class="font-weight-light">
            Combine several details and find the best chef and menu in your region, just for that follow the below:
            </p>
            <ul>
                <ul>

                    <p>
                        •	Choose the type of service;
                    </p>

                    <p>
                        •	Choose the date and location of your event;
                    </p>
                    <p>
                        •	Find a chef or menu available in your region;
                    </p>
                    <p>
                        •	Make the reservation online;
                    </p>
                    <p>
                        •	Have fun and enjoy the service.
                    </p>

                </ul>
            </ul>
        <p class="font-weight-light">
            If you are a chef, in just three steps, be our partner and increase your recipes. EatInMore increases the chef's exposure as it has a specialized and vibrant digital marketing team.
        </p>
        <p class="font-weight-light">
            To register and have your menus published, you do not need to pay anything, the fee is charged for the service contracted by customers.
        </p>
        <p class="font-weight-light">
            Register with EatInMore and create your profile.
        </p>
        <p class="font-weight-light">
            Register your menus and include your necessary details.
        </p>
        <p class="font-weight-light">
            Wait for contacts, manage your customer portfolio and leverage revenue.
        </p>
    </section>


    </v-col>

    <v-navigation-drawer
      app
      clipped
      right
      dense
    >

      <v-list-item>
        <v-list-item-content>
          <v-list-item-title class="title">
            Contents
          </v-list-item-title>
        </v-list-item-content>
      </v-list-item>

    <v-divider></v-divider>
      <v-list shaped dense>
            <v-list-item-group
                color="primary"
            >

        <v-list-item
            v-for="(item, i) in items"
            :key="i"
            @click="$vuetify.goTo(item.link)"

        >
            <v-list-item-content>
                <v-list-item-title v-text="item.title"></v-list-item-title>
            </v-list-item-content>
        </v-list-item>
            </v-list-item-group>
      </v-list>
      <v-divider class="mx-4"></v-divider>
            <v-row  dense justify="center" align="center">
                <v-btn
                v-for="icon in icons"
                :key="icon"
                class="mx-1"
                icon
                >
                <v-icon size="24px">
                    {{ icon }}
                </v-icon>
                </v-btn>
            </v-row>
    </v-navigation-drawer>
    </v-row>
</div>
</template>
<script>
  export default {
    data () {
      return {
        items: [
          { title: 'Brand',link:'#Brand', icon: 'mdi-ray-start-vertex-end' },
          { title: 'Mission',link:'#Mission', icon: 'mdi-account' },
          { title: 'Vision',link:'#Vision', icon: 'mdi-hvac' },
          { title: 'Works',link:'#Works', icon: 'mdi-playlist-check'}
        ],
        icons: [
            'mdi-facebook',
            'mdi-twitter',
            'mdi-linkedin',
            'mdi-instagram',
        ],
      }
    },
  }
</script>
