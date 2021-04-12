<template>
<div  >
    <v-row>
    <v-col cols="12" >
    <section id="contactform">
        <v-card
        elevation="2"
        >
        <v-card-title v-if="!respMessage">Send message for us</v-card-title>
        <v-card-title v-else >Message received successfully</v-card-title>
        <v-card-subtitle>Our team will answer you as soon as possible</v-card-subtitle>
            <v-form class="pa-6" ref="Form" v-model="valid" lazy-validation>
                <v-text-field
                v-model="name"
                :error-messages="nameErrors"
                :counter="45"
                label="Name"
                required
                @input="$v.name.$touch()"
                @blur="$v.name.$touch()"
                ></v-text-field>
                <v-text-field
                v-model="email"
                :error-messages="emailErrors"
                label="E-mail"
                required
                @input="$v.email.$touch()"
                @blur="$v.email.$touch()"
                ></v-text-field>

                <v-textarea
                rows="2"
                v-model="message"
                label="Message"
                :counter="255"
                :error-messages="messageErrors"
                @change="$v.message.$touch()"
                @blur="$v.message.$touch()"
                required
                ></v-textarea>


            <v-card-actions>
                <v-btn
                outlined
                class="mr-4"
                @click="submit"
                :disabled="!valid"
                >
                submit
                </v-btn>
                <v-btn
                outlined
                @click="clear"
                color="indigo"
                >
                clear
                </v-btn>

            </v-card-actions>

            </v-form>
            </v-card>

    </section>
    </v-col>
    <v-col cols="12">

        <v-row class="mt-10">
            <v-col class="pl-6"
            xs="12"
            sm="6"
            md="6"
            lg="6"
            xl="6"
            >
                <v-row class="pt-6">
                    <v-icon

                    >
                    mdi-map-marker
                    </v-icon>

                    <div class="font-weight-medium"> </div>
                </v-row>
                <v-row class="pl-6 pt-3">
                    <p class="font-weight-light">
                        <strong>Mozambique</strong> - Maputo, Rua Simões da Silva, 111
                    </p>
                </v-row>


            </v-col>
            <v-col cols="1">

            <v-divider  vertical></v-divider>
            </v-col>

            <v-col class="pl-6"
            xs="12"
            sm="5"
            md="5"
            lg="5"
            xl="5"
            >
                <v-row class="pt-6">
                    <v-icon

                    >
                    mdi-dialpad
                    </v-icon>
                </v-row>
                <v-row class="pl-6 pt-3">
                    <p class="font-weight-light">
                        <strong>Email</strong> - geral@datasync.co.mz
                    </p>
                </v-row>


            </v-col>
        </v-row>

    </v-col>

    <v-row class="mt-10">
        <v-col cols="12">

            <section id="team">
                <p class="font-weight-medium" >
                Thank You.
                </p>
                <p class="font-weight-light">
                Our Team is grateful for using our services. <v-icon  color="red">mdi-heart</v-icon><v-icon small color="red">mdi-heart</v-icon><v-icon x-small color="red">mdi-heart</v-icon></p>
            </section>

        </v-col>
    </v-row>

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
  import { validationMixin } from 'vuelidate'
  import { required, maxLength, email } from 'vuelidate/lib/validators'

  export default {
    mixins: [validationMixin],

    validations: {
      name: { required, maxLength: maxLength(45) },
      email: { required, email ,maxLength: maxLength(255)},
      message: { required,maxLength: maxLength(255) },
    },

    data: () => ({
        respMessage:false,
        valid: true,
        icons: [
            'mdi-facebook',
            'mdi-twitter',
            'mdi-linkedin',
            'mdi-instagram',
        ],
        items: [
            { title: 'Contact Form',link:'#contactform', icon: 'mdi-ray-start-vertex-end' },
            { title: 'Team',link:'#team', icon: 'mdi-account' },
        ],
      name: '',
      email: '',
      message: '',
    }),

    computed: {
      messageErrors () {
        const errors = []
        if (!this.$v.message.$dirty) return errors
        !this.$v.message.required && errors.push('Message is required')
        return errors
      },
      nameErrors () {
        const errors = []
        if (!this.$v.name.$dirty) return errors
        !this.$v.name.maxLength && errors.push('Name must be at most 45 characters long')
        !this.$v.name.required && errors.push('Name is required.')
        return errors
      },
      emailErrors () {
        const errors = []
        if (!this.$v.email.$dirty) return errors
        !this.$v.email.email && errors.push('Must be valid e-mail')
        !this.$v.email.required && errors.push('E-mail is required')
        return errors
      },
    },

    methods: {
      submit () {
        this.$v.$touch()
        if (this.$refs.Form.validate()) {
            // submit form to server/API here...
             var form={
                "name":this.name,
                "email":this.email,
                "message":this.message,
            }
            this.sendData(form);
        }
      },
    sendData(data) {
        axios
        .post("contact/send/message", { data: { messageData: data} })
        .then(response => {
            this.clear();
            this.allerros = [];
            this.sucess = true;
            if (response.data.errors) {
                //console.log(response.data.errors);
                response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});

            } else {
                this.respMessage=true;
                this.openNotification('success', 'Save', 'Message received successfully');

            }
        })
        .catch((error) => {
            this.success = false;
            var errors =null;
            var status=error.response.status;
            //console.log(status);
                if (status == 422){
                errors=error.response.data.errors;
                //console.log(errors);
                errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
            }else{
                this.openNotification('error','Error on Save',error);
            }
        });
    },
      clear () {
        this.$v.$reset()
        this.name = ''
        this.email = ''
        this.message = ''
      },

    openNotification: function (type, m, d) {
        this.$notification.config({
            placement: 'topRight',
            top: 35,
            duration: 8,
        });
        this.$notification[type]({
            message: m,
            description: d,
        });
    },
    },
  }
</script>

