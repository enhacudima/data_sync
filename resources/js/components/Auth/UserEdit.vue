<template>
    <div>
        <v-form ref="registerForm" v-model="valid" lazy-validation>
            <v-row>
                <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="formReg.name"  label="First Name" maxlength="255" :counter="255" required :rules="[rules.required]"></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6">
                    <v-text-field v-model="formReg.lastName"  label="Last Name" maxlength="255" :counter="255" :rules="[rules.required]" required></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field disabled v-model="formReg.email" :rules="emailRules" label="E-mail" :counter="255" required></v-text-field>
                </v-col>
                <v-col cols="12" sm="4" md="4">
                    <v-autocomplete
                    v-model="formReg.prefix_phone_1"
                    :items="countrys"
                    label="Prefix"
                    required
                    item-text="phone"
                    return-object
                    :rules="[rules.required]"
                    >
                    </v-autocomplete>
                </v-col>
                <v-col cols="12" sm="8" md="8">
                    <v-text-field v-model="formReg.phone1" type="number"  :rules="[rulesPhone.required,rulesPhone.min,rulesPhone.max]" label="Phone Number" maxlength="9" :counter="9" required></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-menu
                    ref="menu"
                    v-model="menu"
                    :close-on-content-click="false"
                    transition="scale-transition"
                    offset-y
                    min-width="auto"
                    >
                    <template v-slot:activator="{ on, attrs }">
                        <v-text-field
                        v-model="formReg.dataBrith"
                        label="Birthday date"
                        prepend-icon="mdi-calendar"
                        readonly
                        v-bind="attrs"
                        v-on="on"
                        :rules="[rules.required]"
                        ></v-text-field>
                    </template>
                    <v-date-picker
                        ref="picker"
                        v-model="formReg.dataBrith"
                        :max="new Date(new Date().setFullYear(new Date().getFullYear() - 18)).toISOString().substr(0, 10)"
                        min="1950-01-01"
                        @change="save"
                    ></v-date-picker>
                    </v-menu>
                </v-col>

                <v-col cols="12">
                    <v-text-field v-model="formReg.fullAddress" type="text"  label="Full Address" :rules="[]" maxlength="255" :counter="255" ></v-text-field>
                </v-col>
                <v-col cols="12">
                <v-spacer></v-spacer>
                    <v-btn class="float-right"
                        fab
                        small
                        @click="formReg.isEditing = !formReg.isEditing"
                    >
                        <v-icon v-if="formReg.isEditing">
                        mdi-close
                        </v-icon>
                        <v-icon v-else>
                        mdi-pencil
                        </v-icon>
                    </v-btn>
                </v-col>

                <v-col cols="12">
                    <v-text-field :disabled="!formReg.isEditing" v-model="formReg.old_password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[]" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Old Password"  counter @click:append="show1 = !show1"></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field :disabled="!formReg.isEditing" v-model="formReg.password" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[]" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Password" counter @click:append="show1 = !show1"></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field :disabled="!formReg.isEditing" block v-model="formReg.password_confirmation" :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'" :rules="[ passwordMatch]" :type="show1 ? 'text' : 'password'" name="input-10-1" label="Confirm Password" counter @click:append="show1 = !show1"></v-text-field>
                </v-col>
                <v-spacer></v-spacer>
                <v-col class="d-flex ml-auto" cols="12" sm="1" xsm="12">
                    <v-btn elevation="1" large :disabled="!valid" color="success" @click="validate">Save</v-btn>
                </v-col>
            </v-row>
        </v-form>
    </div>
</template>

<script>
export default {
  components: {},
    props: {
        value: Boolean,
        show: {
            type:Boolean
        },
    },
  computed: {
    showDialog: {
        get () {
            return this.show
        },
        set (show) {
            this.$emit('input', show)
        }
    },
    passwordMatch() {
      return () => this.password === this.password_confirmation || "Password must match";
    }
  },
  methods: {
      save (date) {
        //this.$refs.menu.save(formReg.dataBrith)
      },
    validate() {
      if (this.$refs.registerForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendData(this.formReg);
      }
    },
    reset() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
    sendData(data) {
      axios
      .post("userEdit", { data: { userData: data} })
      .then(response => {
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});

          } else {

              this.openNotification('success', 'Save', 'You have been update all data successfully');
              //this.$router.push({ name: 'register/result' });
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
  getUserData(){
    axios
        .get('getUserData')
        .then(response => (this.userDetail = response.data,
        this.formReg.name=this.userDetail.name,
        this.formReg.lastName=this.userDetail.lastName,
        this.formReg.prefix_phone_1=this.userDetail.prefix_phone_1.replace('+',''),
        this.formReg.phone1=this.userDetail.phone1.substr(-9),
        this.formReg.dataBrith= this.userDetail.dataBrith,
        this.formReg.email= this.userDetail.email,
        this.formReg.old_password="",
        this.formReg.password= "",
        this.formReg.password_confirmation= "",
        this.formReg.fullAddress = this.userDetail.fullAddress
        ));

  },

  },
  data: () => ({
    userDetail:[],
    formReg:{
      name:null,
      lastName:null,
      prefix_phone_1:"",
      phone1:"",
      dataBrith: null,
      email: "",
      old_password:"",
      password: "",
      password_confirmation:null,
      isEditing: false,
      fullAddress:null,
    },
    menu: false,
    userType:[
      {name:"Chef",type:"3"},
      {name:"Client",type:"2"},
    ],
    countrys:[],
    terms_conditions: false,
    dialog: true,
    tab: 0,
    tabs: [
        {name:"Login", icon:"mdi-account"},
        {name:"Register", icon:"mdi-account-outline"}
    ],
    valid: true,
    verify: "",
    loginPassword: "",
    loginEmail: "",
    loginEmailRules: [
      v => !!v || "Required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid"
    ],
    emailRules: [
      v => !!v || "Required",
      v => /.+@.+\..+/.test(v) || "E-mail must be valid"
    ],

    show1: false,
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
    rulesPhone: {
      required: value => !!value || "Required.",
      min: v => (v && v.length >= 9) || "Min 9 characters",
      max: v => (v && v.length <= 9) || "Max 9 characters"
    },
    setUserData(){

    }
  }),

  mounted() {
  axios
      .get('getCountryStates')
      .then(response => (this.countrys = response.data));
       this.getUserData();
  },
  watch: {
    showDialog (val, oldVal) {
      //console.log(val)
      this.getUserData();
    },
    menu (val) {
      val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
    },
  },


};

</script>

