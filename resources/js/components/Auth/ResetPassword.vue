<template>
  <v-card class="px-4" outlined>
      <v-card-text>
          <v-form ref="loginForm" v-model="valid" lazy-validation>
              <v-row>
                  <v-col cols="12">
                      <v-text-field v-model="email" :rules="loginEmailRules" label="E-mail" required :error-messages="loginError"></v-text-field>
                  </v-col>
                <v-col cols="12">
                    <v-text-field v-model="password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, rules.min,rules.password]" :type="show1 ? 'text' : 'password'" name="input-10-1" :label="$t('password')" hint="At least 8 characters" counter @click:append="show1 = !show1" ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field block v-model="password_confirmation" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[rules.required, passwordMatch]" :type="show1 ? 'text' : 'password'" name="input-10-1" :label="$t('password_confirm')" counter @click:append="show1 = !show1"></v-text-field>
                </v-col>
                  <v-col class="d-flex" cols="12" sm="12" xsm="12" align-end>
                      <v-btn elevation="1" large block  color="success" @click="validate"> {{$t('reset')}}</v-btn>
                  </v-col>
                  <v-spacer></v-spacer>
              </v-row>
          </v-form>
      </v-card-text>

    <v-dialog
      v-model="dialogW"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        color="primary"
        dark
      >
        <v-card-text>
          Please stand by
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-card>
</template>

<script>
export default {

  computed: {
    passwordMatch() {
      return () => this.password === this.password_confirmation || "Password must match";
    },
    token(){
        return this.$route.params.token;
    }
  },
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
      email:null,
      password: null,
      password_confirmation:null,
      show1: false,
      loginEmailRules: [
        v => !!v || "Required",
        v => /.+@.+\..+/.test(v) || "E-mail must be valid"
      ],
      rules: {
        required: value => !!value || "Required.",
        min: v => (v && v.length >= 8) || "Min 8 characters",
        password: value => {
          const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
          return (
            pattern.test(value) ||
            "Min. 8 characters with at least one capital letter, a number and a special character."
          );
        }
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
        //console.log(this.urlParams);
        this.dialogW=true;
        this.login(this.email,this.token,this.password,this.password_confirmation);
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },

    login (email,token,password,password_confirmation) {
      axios
      .post("reset-password", { email:email, token:token, password: password,password_confirmation,password_confirmation })
        .then(response => {
            this.dialogW=false;
            this.allerros = [];
            this.sucess = true;
            if (response.data.errors) {
                //console.log(response.data.errors);
                this.loginError=errors[0];
                response.data.errors.forEach(error => { this.openNotification('error', 'Reset', error);});
                //this.openNotification('info', 'Reset', response.data.message);

            } else {
            console.log(response.data);
            this.dialogW=false;
            this.$router.push({ name: 'home' })
            this.openNotification('info', 'Reset', response.data.success);

            }
        })
        .catch((error) => {
            this.dialogW=false;
            this.success = false;
            var errors =null;
            var status=error.response.status;
            //console.log(status);
                if (status == 422){
                errors=error.response.data.errors;
                //console.log(errors);
                this.loginError=errors[0];
                errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
            }else{
                this.loginError=error;
                this.openNotification('error','Error on Save',error);
            }
        });
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
