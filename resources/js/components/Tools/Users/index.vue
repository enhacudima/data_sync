<template>
    <div>
    <v-col cols="12" dense>
        <v-server-table url="getUsersList" :columns="columns" :options="options">

            <div slot="id" slot-scope="props">
                    {{props.row.id}}
                    <v-btn
                        small
                        icon
                        color="green"
                        :to="'/'+props.row.key"
                        target="_blank"
                    >
                    <v-icon small>mdi-eye-outline</v-icon>
                    </v-btn>
            </div>

            <div slot="Roles" slot-scope="props">
                <v-btn
                    small
                    icon
                    color="green"
                    @click="userRoles(props.row.name,props.row.key)"
                >
                <v-icon small>mdi-folder-open-outline</v-icon>
                </v-btn>
            </div>

            <div slot="status" slot-scope="props">
                    <v-btn
                    small
                    outlined
                    color="red"
                    v-if="props.row.email_verified_at === null"
                    >
                    <v-icon small>mdi-check</v-icon>
                    Not verified
                    </v-btn>
                    <v-btn
                    small
                    outlined
                    color="green"
                    v-else-if="props.row.status === 1"
                    >
                    <v-icon small>mdi-check-all</v-icon>
                    Active
                    </v-btn>
                    <v-btn
                    small
                    outlined
                    color="pink"
                    v-else-if="props.row.status === 0 "
                    >
                    <v-icon small>mdi-fire</v-icon>
                    Suspended
                    </v-btn>
            </div>

            <div slot="email_verified_at" slot-scope="props">
                {{formatBrithDate(props.row.email_verified_at)}}
            </div>
            <div slot="dataBrith" slot-scope="props">
                {{formatBrithDate(props.row.dataBrith)}}
            </div>
            <div slot="updated_at" slot-scope="props">
                {{formatDate(props.row.updated_at)}}
            </div>
            <div slot="child_row" slot-scope="props">
                <div><b>Chef Type:</b> {{ props.row.title}}</div>
            </div>
            <div slot="user_type" slot-scope="props">
                <v-btn
                small
                outlined
                color="red"
                v-if="props.row.type === 1 "
                @click="openUserType(props.row.key)"
                >
                <v-icon small>mdi-shield-check</v-icon>
                {{ props.row.user_type}}
                </v-btn>
                <v-btn
                small
                outlined
                color="green"
                v-if="props.row.type === 2 "
                @click="openUserType(props.row.key)"
                >
                <v-icon small>mdi-shield-check</v-icon>
                {{ props.row.user_type}}
                </v-btn>
                <v-btn
                small
                outlined
                color="pink"
                v-if="props.row.type === 3 "
                @click="openUserType(props.row.key)"
                >
                <v-icon small>mdi-shield-check</v-icon>
                {{ props.row.user_type}}
                </v-btn>
            </div>
             <div slot="phone1" slot-scope="props">
                 +{{ props.row.phone1 }}
             </div>
        </v-server-table>
    </v-col>

    <v-dialog
        v-model="dialogRoles"
        max-width="500px"
        persistent
    >
        <v-card>
        <v-card-title>
            <span class="headline">{{userName}}'s Roles</span>
        </v-card-title>

        <v-card-text>
            <v-container>
            <v-row>
                <v-col
                cols="12"
                >
                <v-autocomplete
                    v-model="editedItem.roles"
                    :items="roles"
                    label="Roles"
                    item-text="name"
                    item-value="id"
                    return-object
                    outlined
                    dense
                    chips
                    small-chips
                    multiple
                >
                </v-autocomplete>
                </v-col>
            </v-row>
            </v-container>
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
            color="blue darken-1"
            text
            @click="close"
            >
            Cancel
            </v-btn>
            <v-btn
            color="blue darken-1"
            text
            @click="save"
            >
            Save
            </v-btn>
        </v-card-actions>
        </v-card>
    </v-dialog>


    <v-dialog
      v-model="dialogType"
      persistent
      max-width="500px"
    >
      <v-card>
        <v-form ref="priceForm" v-model="valid" lazy-validation>
        <v-card-title>
          <span class="headline">Update User</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="formList.commets"
                  label="Comments*"
                  required
                  :rules="[rules.required]"
                ></v-text-field>
              </v-col>
            <v-col cols="12">
              <v-autocomplete
                v-model="formList.type"
                :items="userType"
                label="Type"
                item-text="type"
                item-value="id"
                return-object
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="12">
              <v-autocomplete
                v-model="formList.userStatus"
                :items="userStatus"
                label="Status"
                item-text="name"
                item-value="id"
                return-object
              >
              </v-autocomplete>
            </v-col>
            <v-col cols="12">
              <v-autocomplete
                v-model="formList.chefType"
                :items="experiences"
                label="Chef Type"
                :item-text="item => '('+item.ref+')' + item.title + ' - '+ item.description"
                item-value="key"
                return-object
              >
              </v-autocomplete>
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
            @click="dialogType = false"
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

    </div>

</template>


<script>

    export default {

        mounted() {
            this.initialize (),
            axios
                .get('getExperiencesActive')
                .then(response => (this.experiences = response.data));
        },
         methods: {
            userRoles(name,key){
            axios
                .get('getUserRoles/'+key)
                .then(response => (this.editedItem.roles = response.data, this.userKey = key,this.userName=name,this.dialogRoles = true));

            },
            close () {
                this.editedItem.roles=null
                this.userName=null
                this.dialogRoles = false
            },
            save () {
                axios
                .post("roles/users/create/"+this.userKey, { data: this.editedItem })
                .then(response => (this.close()))
                 this.initialize ()
            },
            initialize () {
                axios
                .get('getRoles')
                .then(response => (this.roles = response.data));

            },
            onUpdate() {
             this.$refs.table.refresh();
            },
            formatDate(date) {
              return moment(date).format('DD-MM-YYYY HH:mm:ss');
            },
            formatBrithDate(date) {
              return moment(date).format('DD-MM-YYYY');
            },
            openUserType(key){
                this.userKey = key;

                this.dialogType=true;
            },
        validate() {
        if (this.$refs.priceForm.validate()) {
            // submit form to server/API here...
            //console.log(this.formReg);
            this.sendData(this.formList);
            this.dialogType = false;
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
        .post("tools/users/update/"+this.userKey, { data: { userData: data} })
        .then(response => {
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

        data() {
            return {
                userName:null,
                userHasRoles:null,
                editedItem:{
                    roles:null
                },
                roles:[],
                userKey:null,
                experiences:[],
                rules: {
                    required: value => !!value || "Required.",
                    password: value => {
                    const pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/;
                    return (
                        pattern.test(value) ||
                        "Min. 8 characters with at least one capital letter, a number and a special character."
                    );
                    }
                },
                valid: true,
                formList:{
                    commets:null,
                    type:null,
                    chefType:null,
                    userStatus:null,

                },
                userType:[
                    {type:"Admin",id:"1"},
                    {type:"Client",id:"2"},
                    {type:"Chef",id:"3"}
                ],

                userStatus:[
                    {name:"Suspended",id:"0"},
                    {name:"Active",id:"1"},
                ],
                dialogType:false,
                dialogRoles:false,
                columns: ["id","name","lastName","dataBrith","country","phone1","updated_at","email_verified_at","user_type","status","Roles"],
                tableData: [],
                options: {
                headings: {
                        name: 'Name',
                        lastName: 'Surname',
                        dataBrith: 'Data Brith',
                        country: 'Country',
                        phone1: 'Phone',
                        updated_at: 'Updated',
                        user_type: 'Type',
                        status: 'Status',
                        email_verified_at: 'Verified',
                        id:"#",

                    },
                    filterable: ["id","name","lastName","dataBrith","country","phone1","updated_at","user_type","status","email_verified_at"],
                    filterByColumn: true,
                    orderBy: { column: 'updated_at'},
                    setOrder: { ascending:true},
                    uniqueKey: 'id',
                    listColumns: {
                    },


                perPage: 12,
                perPageValues:[12,25, 50, 75,100,250,500,1000],
            }
        };
    },
    }

</script>


<style>
.table thead th {
    padding: 0.3rem;
    padding-top: 0.3rem;
    padding-right: 0.3rem;
    padding-bottom: 0.3rem;
    padding-left: 0.3rem;
    font-size: 12px;
}
.table tbody td {
    padding: 0.3rem;
    padding-top: 0.3rem;
    padding-right: 0.3rem;
    padding-bottom: 0.3rem;
    padding-left: 0.3rem;
    font-size: 12px;
}
th:nth-child(3) {
  text-align: center;
}

.VueTables__child-row-toggler {
  width: 16px;
  height: 16px;
  line-height: 16px;
  display: block;
  margin: auto;
  text-align: center;
}

.VueTables__child-row-toggler--closed::before {
  content: "+";
}
</style>
