<template>
<div  >
    <v-row>
    <v-col cols="12" >
    <section id="contactform">
        <v-card
        elevation="2"
        >
        <v-card-title v-if="!respMessage">{{$t('title_conta')}}</v-card-title>
        <v-card-title v-else >{{$t('result_title_conta')}}</v-card-title>
        <v-card-subtitle>{{$t('sub_title_conta')}}</v-card-subtitle>
            <v-form class="pa-6" ref="Form" v-model="valid" lazy-validation>
                <v-text-field
                v-model="name"
                :error-messages="nameErrors"
                :counter="45"
                :label="$t('name')"
                required
                @input="$v.name.$touch()"
                @blur="$v.name.$touch()"
                ></v-text-field>
                <v-text-field
                v-model="email"
                :error-messages="emailErrors"
                :label="$t('email')"
                required
                @input="$v.email.$touch()"
                @blur="$v.email.$touch()"
                ></v-text-field>
                <v-text-field
                v-model="phone"
                :error-messages="emailPhone"
                :label="$t('phone_number')"
                type="number"
                required
                @input="$v.phone.$touch()"
                @blur="$v.phone.$touch()"
                ></v-text-field>

                <v-textarea
                rows="2"
                v-model="message"
                :label="$t('message')"
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
                {{$t('submit')}}
                </v-btn>
                <v-btn
                outlined
                @click="clear"
                color="indigo"
                >
                {{$t('clear')}}
                </v-btn>

            </v-card-actions>

            </v-form>
            </v-card>

    </section>
    </v-col>
    <v-col cols="12">

        <v-row class="pl-5 pt-2">
            <p class="black--text font-weight-light">
                <strong>{{$t('email')}}</strong> - geral@moz-concursopublico.info
            </p>
        </v-row>
    </v-col>
    <!--
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

                    <div class="black--text font-weight-medium"> </div>
                </v-row>
                <v-row class="pl-6 pt-3">
                    <p class="black--text font-weight-light">
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
                    <p class="black--text font-weight-light">
                        <strong>Email</strong> - geral@moz-concursopublico.info
                    </p>
                </v-row>
                <v-row class="pl-6 pt-1">
                    <p class="black--text font-weight-light">
                        <strong>Web</strong> - moz-concursopublico.info
                    </p>
                </v-row>


            </v-col>
        </v-row>

    </v-col>
    -->

    <v-row class="mt-10 pl-2">
        <v-col cols="12">

            <section id="team">
                <p   class="font-weight-medium text-color" >
                {{$t('thank_you')}}
                </p>
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
            {{$t('contents')}}
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
                <v-list-item-title v-text="$t(item.title)"></v-list-item-title>
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
      phone: { required ,maxLength: maxLength(21)},
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
            { title: 'contact_form',link:'#contactform', icon: 'mdi-ray-start-vertex-end' },
            { title: 'team',link:'#team', icon: 'mdi-account' },
        ],
      name: '',
      email: '',
      phone: '',
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
      emailPhone () {
        const errors = []
        if (!this.$v.phone.$dirty) return errors
        !this.$v.phone.required && errors.push('Phone is required')
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
                "phone":this.phone,
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
        this.phone = ''
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
<style>
 .text-color{
    color: #E1B80D;
 }
</style>

