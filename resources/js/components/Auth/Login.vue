<template>
  <v-card class="" outlined>

    <v-progress-linear
      :active="dialogW"
      indeterminate
      color="primary"
    ></v-progress-linear>

      <v-card-text>
          <v-form ref="loginForm" v-model="valid" lazy-validation @submit.prevent="validate">
              <v-row class="pt-6">
                  <v-col cols="12">
                      <v-text-field dense outlined  v-model="loginEmail" :rules="loginEmailRules" :error-messages="loginError" label="E-mail" required ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                      <v-text-field dense outlined autocomplete="off" v-model="loginPassword" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min]" :type="show1 ? 'text' : 'password'" name="input-10-1" :label="$t('password')" :hint="$t('at_least_8_characters')"   @click:append="show1 = !show1"></v-text-field>

                        <v-tooltip bottom class="mt-n1">
                        <template v-slot:activator="{ on }">
                            <a
                            target="_blank"
                            href="forgetPassword"
                            @click.stop
                            v-on="on"
                            >
                            {{$t('forgot_password')}}
                            </a>
                        </template>
                        {{$t('use_link_reset')}}
                        </v-tooltip>
                  </v-col>

                  <v-col class="d-flex" cols="6" sm="6" xsm="12" align-end>
                        <router-link to="/register" class="pt-3">
                            {{$t('register_now')}}
                        </router-link>
                  </v-col>
                  <v-spacer></v-spacer>
                  <v-col class="d-flex" cols="6" sm="6" xsm="12" align-end>
                      <v-btn elevation="1"  block  color="primary" type="submit"> {{$t('login')}} </v-btn>
                  </v-col>
              </v-row>
          </v-form>
      </v-card-text>
  </v-card>
</template>

<script>
export default {
name: 'locale-changer',
  data() {
    return {
      dialogW:false,
      loginError:null,
      dialog: true,
      tab: 0,
      tabs: [
          {name:"Login", icon:"mdi-account"},
      ],
      valid: true,
      loginPassword: "",
      loginEmail: "",
      loginEmailRules: [
        v => !!v || "Required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
      ],
      show1: false,
      rules: {
        required: value => !!value || "Required.",
        min: v => (v && v.length >= 8) || "Min 8 characters"
      },
      testError:'',
      country:'',
      user_id:'',
      verMessage:'',
      verUrl:'',
      allerros:'',
      sucess:'',
      verDescription: '',
      verButtonMessage: '',
    };
  },
  beforeCreate() {
    this.form = this.$form.createForm(this, { name: 'normal_login' });
  },
  methods: {
    validate() {
      if (this.$refs.loginForm.validate()) {
        // submit form to server/API here...
        this.dialogW=true;
        this.login(this.loginEmail,this.loginPassword);
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },

    login (email,password) {
      this.$store
        .dispatch('login', {
          email: email,
          password: password
        })
        .then(() => {
          this.dialogW=false;
          this.$router.push({ name: 'home' })
        })
        .catch(err => {
        this.dialogW=false;
        var errors =null;
        var status=err.response.status;
        //console.log(status);
            if (status == 403){
                this.user_id=err.response.data.id;
                this.verDescription=err.response.data.description;
                this.verMessage=err.response.data.message;
                this.verUrl=err.response.data.url;
                this.verButtonMessage=err.response.data.button;

                this.openVerifyNotification();
            }
            if (status == 422){
             const errors = err.response.data;

              //console.log(errors.error);
              this.loginError=errors.error;
              //this.openNotification('error', 'Error on Save', errors.error);

            }
            else if (status == 429){
             const errors = err.response.data;

              //console.log(errors.errors.email[0]);
              this.loginError=errors.errors.email[0];

            }
            else{
            this.dialogW=false;
            this.openNotification('error','Error during login','Please contact admin web-site');
          }
        })
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
    closeNotification(key){
        axios
        .post(this.verUrl, { data: { id: this.user_id} })
        .then(response => {
            this.allerros = [];
            this.sucess = true;
            if (response.data.errors) {
                response.data.errors.forEach(error => { this.openNotification('error', 'Action Button Error', error);});

            } else {

                this.openNotification('success', this.verMessage, 'Action Button successfully');
            }
        })
      .catch((error) => {
        this.success = false;
        var errors =null;
        var status=error.response.status;
            if (status == 422){
            errors=error.response.data.errors;
            errors.forEach(error => { this.openNotification('error', 'Action Button Error', error);});
          }else{
            this.openNotification('error','Action Button Error',error.response.data['error']);
          }
      });

        this.$notification.close(key)
    },
    openVerifyNotification() {
      const key = `open${Date.now()}`;
      this.$notification.open({
        message: this.verMessage,
        placement:'bottomRight',
        description:
           this.verDescription,
        btn: h => {
          return h(
            'a-button',
            {
              props: {
                type: 'primary',
                size: 'small',
              },
              on: {
                click: () => this.closeNotification(key),
              },
            },
            this.verButtonMessage,
          );
        },
        key,
        onClose: close,
        duration: 0,

      });
    },

  },
};
</script>
<style>
#components-form-demo-normal-login .login-form {
  max-width: 300px;
}
#components-form-demo-normal-login .login-form-forgot {
  float: right;
}
#components-form-demo-normal-login .login-form-Remember {
  float: left ;
}
#components-form-demo-normal-login .login-form-button {
  width: 100%;
}
</style>
