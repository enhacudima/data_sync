<template>
  <v-data-table
    :headers="headers"
    :items="invoices"
    sort-by="crated_at"
    class="elevation-1"
    dense
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >

        <v-toolbar-title>Invoices</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="apply" max-width="500px">
          <v-card>
            <v-card-title class="headline">Are you sure you want to accept this invoice?</v-card-title>
              <v-container>
                <v-row>
                  <v-col
                    cols="12"
                  >
                    <v-autocomplete
                        v-model="form.operation"
                        :items="operations"
                        label="Type of Operation"
                        item-text="operation"
                        item-value="operation"
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
                        label="Total Amount"
                        v-model="form.amount"
                        type="number"
                    >
                    </v-text-field>
                  </v-col>


                    <v-col
                        cols="12"
                    >
                        <v-textarea
                            v-model="form.notes"
                            label="Notes"
                            auto-grow
                            outlined
                            rows="1"
                            row-height="15"
                        ></v-textarea>
                    </v-col>

                </v-row>
              </v-container>

            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="apply=!apply">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="confirmApply()">Yes</v-btn>
              <v-spacer></v-spacer>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
    <template v-slot:item.actions="{ item }">
        <v-btn
            icon
            :href="'storage/'+item.file.path+item.file.name"
            _blanck
        >
            <v-icon
                small
                class="mr-2"
            >
                mdi-file-pdf
            </v-icon>
        </v-btn>
    </template>

    <template v-slot:item.created_at="{ item }">
        {{formatBrithDate(item.created_at)}}
    </template>

    <template v-slot:item.status="{ item }">
        <v-btn
        small
        color="#e1b80d"
        :disabled="item.status_name.name !== 'pending'"
        @click="dialogApply(item.id)"
        >
            {{item.status_name.name}}
        </v-btn>

    </template>

  </v-data-table>
</template>

<script>

  export default {
    data: () => ({
      operations: [
          {operation : 'Renew'},
          {operation : 'New'},
          {operation : 'Change'},
          {operation : 'Not Apply'},

      ] ,
      form: {
          operation:null,
          notes:null,
          invoice_id: null,
          amount: null,
      },
      apply:false,
      loading: false,
      fileInfo:'',
      selected:[],
      plans:[],
      invoices:[],
      dialog: false,
      dialogDelete: false,
      headers: [
        { text: '#', value: 'id' },
        { text: 'User Name', value: 'user.name' },
        { text: 'User Last Name', value: 'user.lastName' },
        {
          text: 'Date',
          align: 'start',
          sortable: false,
          value: 'created_at',
        },
        { text: 'File', value: 'pdf_file' },
        { text: 'Plan', value: 'plan.name' },
        { text: 'Price', value: 'plan.price' },
        { text: 'Currency', value: 'plan.currency' },
        { text: 'Period', value: 'plan.invoice_interval' },
        { text: 'Reference', value: 'reference' },
        { text: 'Status', value: 'status'},
        { text: 'Amount', value: 'amount'},
        { text: 'File', value: 'actions', sortable: false },
        { text: 'Note', value: 'note' },
      ],
      desserts: [],
      editedID:null,
      editedIndex: -1,
      editedItem: {
        file: '',
        plans: '',
      },
      defaultItem: {
        file: '',
        plans: '',
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Invoice' : 'Edit Item'
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
        confirmApply(){

            this.save ()
        },
        dialogApply(id){
            this.form.invoice_id = id
            this.apply = !this.apply
        },

        formatBrithDate(date) {
            return moment(date).format('DD-MM-YYYY');
        },
      initialize () {
         axios
          .get('plan-get-invoices')
          .then(response => (this.invoices = response.data));

         axios
          .get('plan-get-plans')
          .then(response => (this.plans = response.data));
      },

      editItem (item) {
        this.editedID= Object.assign({}, item).id
        this.editedIndex = this.invoices.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.editedItem.plans = Object.assign({}, item).plans
        this.dialog = true
      },

      deleteItem (item) {
        this.editedID= Object.assign({}, item).id
        this.editedIndex = this.invoices.indexOf(item)
        this.editedItem = Object.assign({}, item)
        this.dialogDelete = true
      },

      deleteItemConfirm () {
        this.invoices.splice(this.editedIndex, 1)
         axios
          .get('role/delete/'+this.editedID)
          .then();

        this.closeDelete()
      },

      close () {
        this.dialog = false
        this.$nextTick(() => {
          //this.editedItem = Object.assign({}, this.defaultItem)
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
        this.sendData(this.form)
      },


        sendData(data) {
            axios
            .post("plan-subscription", { data: { applyData: data} })
            .then(response => {
                this.initialize ()
                this.apply = !this.apply;
                this.allerros = [];
                this.sucess = true;
                if (response.data.errors) {
                    //console.log(response.data.errors);
                    response.data.errors.forEach(error => { this.openNotification('error', 'Error on Save', error);});

                } else {

                    this.openNotification('success', 'Save', 'Your data has been stored successfully');

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
  }
</script>
