<template>
  <v-data-table
    :headers="headers"
    :items="roles"
    sort-by="crated_at"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >

        <v-toolbar-title>List</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog
          v-model="dialog"
          max-width="500px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              New Plan
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-container>
                <v-row>
                    <v-col
                        cols="12"
                    >
                        <v-text-field
                        v-model="editedItem.name"
                        label="Plan name"
                        outlined
                        ></v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                    >
                        <v-textarea
                            v-model="editedItem.description"
                            label="Description"
                            auto-grow
                            outlined
                            rows="1"
                            row-height="15"
                        ></v-textarea>
                    </v-col>
                    <v-col
                    cols="12"
                    >
                        <v-text-field
                            dense
                            outlined
                            label="Price"
                            v-model="editedItem.price"
                            type="number"
                        >
                        </v-text-field>
                    </v-col>
                    <v-col
                    cols="12"
                    >
                        <v-text-field
                            dense
                            outlined
                            label="Signup fee price"
                            v-model="editedItem.signup_fee"
                            type="number"
                        >
                        </v-text-field>
                    </v-col>
                    <v-col
                    cols="12"
                    >
                        <v-text-field
                            dense
                            outlined
                            label="Invoice period"
                            v-model="editedItem.invoice_period"
                            type="number"
                        >
                        </v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                    >
                        <v-autocomplete
                            v-model="editedItem.invoice_interval"
                            :items="permissions"
                            label="Invoice interval"
                            item-text="interval"
                            item-value="interval"
                            outlined
                            dense
                        >
                        </v-autocomplete>
                    </v-col>
                    <v-col
                    cols="12"
                    >
                        <v-text-field
                            dense
                            outlined
                            label="Trial period"
                            v-model="editedItem.trial_period"
                            type="number"
                        >
                        </v-text-field>
                    </v-col>
                    <v-col
                        cols="12"
                    >
                        <v-autocomplete
                            v-model="editedItem.trial_interval"
                            :items="permissions"
                            label="Trial interval"
                            item-text="interval"
                            item-value="interval"
                            outlined
                            dense
                        >
                        </v-autocomplete>
                    </v-col>
                    <v-col
                    cols="12"
                    >
                        <v-text-field
                            dense
                            outlined
                            label="Sort order"
                            v-model="editedItem.sort_order"
                            type="number"
                        >
                        </v-text-field>
                    </v-col>

                    <v-col
                        cols="12"
                    >

                    <v-autocomplete
                        v-model="editedItem.currency"
                        :items="currencys"
                        label="Currency"
                        required
                        :rules="[rules.required]"
                        item-text="alphabetic_code"
                        item-value="alphabetic_code"
                        outlined
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
        <v-dialog v-model="dialogDelete" max-width="500px">
          <v-card>
            <v-card-title class="headline">Are you sure you want to delete this item?</v-card-title>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
        small
        class="mr-2"
        @click="editItem(item)"
      >
        mdi-pencil
      </v-icon>
      <v-icon
        v-if="!item.deleted_at"
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
      <v-icon
        v-else
        small
        @click="restordeleteItem(item.id)"
      >
        mdi-backup-restore
      </v-icon>
    </template>

    <template v-slot:item.created_at="{ item }">
        {{formatBrithDate(item.created_at)}}
    </template>
    <template v-slot:item.deleted_at="{ item }">
        {{formatBrithDate(item.deleted_at)}}
    </template>

    <template v-slot:no-data>
      <v-btn
        color="primary"
        @click="initialize"
      >
        Reset
      </v-btn>
    </template>
  </v-data-table>
</template>

<script>
  export default {
    data: () => ({
        rules: {
            required: value => !!value || "Required.",
        },
      currencys:[],
      selected:[],
      permissions:[
          {interval:'hour'},
          {interval:'day'},
          {interval:'week'},
          {interval:'month'},
      ],
      roles:[],
      dialog: false,
      dialogDelete: false,
      headers: [
        { text: '#', value: 'id' },
        { text: 'name', value: 'name' },
        { text: 'description', value: 'description' },
        { text: 'price', value: 'price' },
        { text: 'signup_fee', value: 'signup_fee' },
        { text: 'invoice_period', value: 'invoice_period' },
        { text: 'invoice_interval', value: 'invoice_interval' },
        { text: 'trial_period', value: 'trial_period' },
        { text: 'trial_interval', value: 'trial_interval' },
        { text: 'sort_order', value: 'sort_order' },
        { text: 'Status', value: 'status'},
        { text: 'created_at', value: 'created_at' },
        { text: 'deleted_at', value: 'deleted_at' },
        { text: 'actions', value: 'actions' },
      ],
      desserts: [],
      editedID:null,
      editedIndex: -1,
      editedItem: {
        name: '',
        description: '',
        price: 0,
        signup_fee: 0,
        invoice_period: 0,
        invoice_interval: '',
        trial_period: 0,
        trial_interval: '',
        sort_order: 0,
        currency: '',
      },
      defaultItem: {
        name: '',
        description: '',
        price: 0,
        signup_fee: 0,
        invoice_period: 0,
        invoice_interval: '',
        trial_period: 0,
        trial_interval: '',
        sort_order: 0,
        currency: '',
      },

    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Plan' : 'Edit Plan'
      },
    },

    watch: {
      dialog (val) {
        val || this.close()
      },
      dialogDelete (val) {
        val || this.closeDelete()
      },
    },

    created () {
      this.initialize()
    },

    methods: {

    formatBrithDate(date) {
        return moment(date).format('DD-MM-YYYY');
    },
      initialize () {
         axios
          .get('plan-get-full')
          .then(response => (this.roles = response.data));
        axios
            .get('getCurrencyArr')
            .then(response => (this.currencys = response.data));

      },

      editItem (item) {
        this.editedID= Object.assign({}, item).id
        this.editedIndex = this.roles.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.editedItem.permissions = Object.assign({}, item).permissions
        this.dialog = true
      },

      deleteItem (item) {
        this.editedID= Object.assign({}, item).id
        this.editedIndex = this.roles.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.roles.splice(this.editedIndex, 1)
         axios
          .get('plan-delete/'+this.editedID)
          .then(response => (this.initialize ()));

        this.closeDelete()
      },
      restordeleteItem(id){
         axios
          .get('plan-restor-delete/'+id)
          .then( response => (this.initialize ()));

      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      closeDelete () {
        this.dialogDelete = false
        this.$nextTick(() => {
          this.editedItem = Object.assign({}, this.defaultItem)
          this.editedIndex = -1
        })
      },

      save () {
        this.sendData(this.editedItem)
      },


        sendData(data) {
            axios
            .post("plan-create-validate", { data: { formData: data,planDatID: this.editedID} })
            .then(response => {
                this.allerros = [];
                this.sucess = true;
                if (response.data.errors) {
                   // console.log(response.data.errors);
                    response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});

                } else {
                    this.initialize ()
                    this.close()
                    this.openNotification('success', 'Save', 'You have been store all data successfully');

                }
            })
            .catch((error) => {
                //console.log(error.response.data.errors);
                this.success = false;
                var errors =null;
                var status=error.response.status;
               // console.log(status);
                    if (status == 422){
                    errors=error.response.data.errors;
                    //console.log(errors);

                    let a = []

                    a = Object.keys(errors).map((field) => {

                    return {
                        message: errors[field]
                    }
                    })
                   a.forEach(error => { this.openNotification('error', 'Error on Save', error.message);});
                    console.log(a)
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
  }
</script>
