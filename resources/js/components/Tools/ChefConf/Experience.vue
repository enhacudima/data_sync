<template>
  <div justify="center" >
    <v-row class=" pb-6 " cols="12" justify="center">
      <v-btn
      class="mx-2"
      fab
      dark
      small
      color="primary"
      @click="dialog = true"
    >
      <v-icon dark>
        mdi-plus
      </v-icon>
    </v-btn>

      <v-btn
      class="mx-2"
      fab
      dark
      small
      color="primary"
      @click="edit()"
    >
      <v-icon dark>
        mdi-pencil
      </v-icon>
    </v-btn>
      <v-btn
      class="mx-2"
      fab
      dark
      small
      color="green"
      @click="priceStatus(true)"
    >
      <v-icon dark>
        mdi-check
      </v-icon>
    </v-btn>
      <v-btn
      class="mx-2"
      fab
      dark
      small
      color="pink"
       @click="priceStatus(false)"
    >
      <v-icon dark>
        mdi-close
      </v-icon>
    </v-btn>

    </v-row>
    <v-row colos="12" justify="center" class=" pa-10">
      <v-data-table
        dense
        class="elevation-1"
        v-model="selected"
        :headers="headers"
        :items="experiences"
        item-key="id"
        show-select
        :single-select="singleSelect"
        justify="center"
      >
      <template v-slot:top class="pl-2">
        <v-switch
          v-model="singleSelect"
          label="Single select"
          class="pa-3"
        ></v-switch>
      </template>
      </v-data-table>
    </v-row>

  <v-row justify="center">
    <v-dialog
      v-model="dialog"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-form ref="priceForm" v-model="valid" lazy-validation>
        <v-card-title>
          <span class="headline">Add Experience</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formPrice.title"
                  label="Title*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-range-slider
                  v-model="formPrice.range"
                  :max="max"
                  :min="min"
                  hide-details
                  class="align-center"
                >
                  <template v-slot:prepend>
                    <v-text-field
                      :value="formPrice.range[0]"
                      class="mt-0 pt-0"
                      hide-details
                      single-line
                      type="number"
                      style="width: 60px"
                      @change="$set(formPrice.range, 0, $event)"
                    ></v-text-field>
                  </template>
                  <template v-slot:append>
                    <v-text-field
                      :value="formPrice.range[1]"
                      class="mt-0 pt-0"
                      hide-details
                      single-line
                      type="number"
                      style="width: 60px"
                      @change="$set(formPrice.range, 1, $event)"
                    ></v-text-field>
                  </template>
                </v-range-slider>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="formPrice.ref"
                  label="Reference*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="formPrice.description"
                  label="Description*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialog = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="validate"
            :disabled="!valid"
          >
            Save
          </v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </v-row>

  <!--edit form-->
  
    <v-dialog
      v-model="dialogEdit"
      persistent
      max-width="600px"
    >
      <v-card>
        <v-form ref="editForm" v-model="validEdit" lazy-validation>
        <v-card-title>
          <span class="headline">Edit Experience - {{formEditPrice.title}}</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formEditPrice.title"
                  label="Title*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-range-slider
                  v-model="formEditPrice.range"
                  :max="max"
                  :min="min"
                  hide-details
                  class="align-center"
                >
                  <template v-slot:prepend>
                    <v-text-field
                      :value="formEditPrice.range[0]"
                      class="mt-0 pt-0"
                      hide-details
                      single-line
                      type="number"
                      style="width: 60px"
                      @change="$set(formEditPrice.range, 0, $event)"
                    ></v-text-field>
                  </template>
                  <template v-slot:append>
                    <v-text-field
                      :value="formEditPrice.range[1]"
                      class="mt-0 pt-0"
                      hide-details
                      single-line
                      type="number"
                      style="width: 60px"
                      @change="$set(formEditPrice.range, 1, $event)"
                    ></v-text-field>
                  </template>
                </v-range-slider>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="formEditPrice.ref"
                  label="Reference*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="formEditPrice.description"
                  label="Description*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
              
            </v-row>
          </v-container>
          <small>*indicates required field</small>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="blue darken-1"
            text
            @click="dialogEdit = false"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="validateEdit"
            :disabled="!validEdit"
          >
            Save
          </v-btn>
        </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
    
  </div>
</template>
<script>
  export default {
    props: {
        
    },
    data () {
      return {
        dialogEdit: false,
        min: 1,
        max: 10,
        range: [1, 1],
        valid: true,
        validEdit:true,
        rules: {
          required: value => !!value || "Required.",
        },
        formPrice:{
          title:null,
          range: [1, 1],
          ref:null,
          description:null,

        },
        formEditPrice:{
          title:null,
          range: [1, 1],
          ref:null,
          description:null,
          key:null,

        },
        dialog:false,
        selected: [],
        singleSelect: false,
        experiences: [],
        headers: [
          {
            text: 'Status',
            align: 'start',
            //sortable: false,
            value: 'experience_status.name',
          },
          { text: 'Title', value: 'title' },
          { text: 'Rate from', value: 'experience_from' },
          { text: 'Rate to', value: 'experience_to' },
          { text: 'References', value: 'ref' },
          { text: 'Description', value: 'description' },
          { text: 'Creator Name', value: 'experiences_users.name' },
          { text: 'Creator Last Name', value: 'experiences_users.lastName' },
          { text: 'Created_at', value: 'created_at' },
          { text: 'Updated_at', value: 'updated_at' },
        ],
      }
    },
    watch: {

    },
    methods:{
    edit(){
      var data =this.selected[0];
      this.dialogEdit = true
      if(data){
        this.formEditPrice.title = data.title,
        this.formEditPrice.range = [data.experience_from, data.experience_to],
        this.formEditPrice.ref = data.ref,
        this.formEditPrice.description = data.description 
        this.formEditPrice.key = data.key                                                     

      }
  
    },
    getExperiences(){
      axios
          .get('getExperiences')
          .then(response => (this.experiences = response.data));
    },
    validate() {
      if (this.$refs.priceForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formReg);
        this.sendData(this.formPrice);
        this.dialog = false;
      }
    },
    validateEdit() {
      if (this.$refs.editForm.validate()) {
        // submit form to server/API here...
        //console.log(this.formEditPrice);
        this.sendEditData(this.formEditPrice);
        this.dialogEdit = false;
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
      .post("tools/experience/create", { data: { experienceData: data} })
      .then(response => {
          this.getExperiences();
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
              
          } else {
              
              this.openNotification('success', 'Save', 'You have been store all data successfully');
              
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
    sendEditData(data) {
         axios
        .post("tools/experience/update/"+this.formEditPrice.key , { data: { experienceData: data} })
        .then(response => {
            this.getExperiences();
            this.allerros = [];
            this.sucess = true;
            if (response.data.errors) {
                //console.log(response.data.errors);
                response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
                
            } else {
                
                this.openNotification('success', 'Save', 'You have been store all data successfully');
                
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
    priceStatus(status) {
      axios
      .post("tools/experience/status/"+status, { data: { experienceStatusData: this.selected} })
      .then(response => {
          this.getExperiences();
          this.allerros = [];
          this.sucess = true;
          if (response.data.errors) {
              //console.log(response.data.errors);
              response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});
              
          } else {
              
              this.openNotification('success', 'Save', 'You have been updated all data successfully');
              
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

    },
    mounted() {
      this.getExperiences();
    }
  }
</script>