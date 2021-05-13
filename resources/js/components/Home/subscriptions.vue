<template>
  <v-data-table
    :headers="headers"
    :items="invoices"
    sort-by="crated_at"
    class="elevation-1"
  >
    <template v-slot:top>
      <v-toolbar
        flat
      >

        <v-toolbar-title>{{$t('invoices')}}</v-toolbar-title>
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
              color="#867666"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >
              {{$t('new_invoice')}}
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
                    <v-autocomplete
                        v-model="editedItem.plans"
                        :items="plans"
                        label="Plan"
                        item-text="name"
                        item-value="id"
                        outlined
                        dense

                    >
                        <template v-slot:item="{ item }">
                            {{item.name}} - {{item.description}} [{{item.price}}{{item.currency}},{{item.invoice_period}} {{item.invoice_interval}}, Trial {{item.trial_period}} {{item.trial_interval}}]

                        </template>

                    </v-autocomplete>
                  </v-col>
                  <v-col>
                    <a-form-item :label="$t('pdf_file')">
                        <a-upload
                            name="file"
                            action="/data_sync/public/api/fileOtherFormat"
                            :before-upload="beforeUpload"
                            @change="handleChange"
                            :loading="loading"
                            :multiple="false"
                        >
                            <a-button> <a-icon type="upload" /> {{$t('upload_pdf')}} </a-button>
                        </a-upload>
                    </a-form-item>
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
                {{$t('cancel')}}
              </v-btn>
              <v-btn
                color="blue darken-1"
                text
                @click="save"
              >
                {{$t('save')}}
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
    <template v-slot:item.invoice_interval="{ item }">
        {{uperfirst(item.plan.invoice_interval)}}
    </template>
    <template v-slot:item.grace_interval="{ item }">
        {{uperfirst(item.plan.grace_interval)}}
    </template>
    <template v-slot:item.status_name="{ item }">
        {{uperfirst(item.status_name.name)}}
    </template>

  </v-data-table>
</template>

<script>

function getBase64(img, callback) {
  const reader = new FileReader();
  reader.addEventListener('load', () => callback(reader.result));
  reader.readAsDataURL(img);
}
function hasErrors(fieldsError) {
  return Object.keys(fieldsError).some(field => fieldsError[field]);
}
  export default {
    data: () => ({
      loading: false,
      fileInfo:'',
      selected:[],
      plans:[],
      invoices:[],
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'Date',
          align: 'start',
          sortable: false,
          value: 'created_at',
        },
        { text: 'File', value: 'pdf_file' },
        { text: 'Plan', value: 'plan.name' },
        { text: 'Description', value: 'plan.description' },
        { text: 'Price', value: 'plan.price' },
        { text: 'Currency', value: 'plan.currency' },
        { text: 'Period', value: 'invoice_interval' },
        { text: 'Grace Period', value: 'plan.grace_period' },
        { text: 'Grace Interval', value: 'grace_interval' },
        { text: 'Reference', value: 'reference' },
        { text: 'Status', value: 'status_name'},
        { text: 'Actions', value: 'actions', sortable: false },
        { text: 'Note', value: 'note'},
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
        this.getPlans()
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
        uperfirst(l){
            return (l).charAt(0).toUpperCase()+(l).slice(1)
        },
        formatBrithDate(date) {
            return moment(date).format('DD-MM-YYYY');
        },
      initialize () {
         axios
          .get('plan-get-invoice')
          .then(response => (this.invoices = response.data));
        this.getPlans()
      },
      getPlans(){
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
        this.editedItem.file=this.fileInfo;
        this.sendData(this.editedItem)
        this.initialize ()
        this.close()
      },


        sendData(data) {
            axios
            .post("plan-pre-subscription", { data: { roleData: data,roleDatID: this.editedID} })
            .then(response => {
                this.initialize ()
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

        handleChange(info) {
        if (info.file.status === 'uploading') {
            this.loading = true;
            return;
        }
        if (info.file.status === 'done') {
            this.fileInfo=info.file.response;
            // Get this url from response in real world.
            getBase64(info.file.originFileObj, imageUrl => {
            this.imageUrl = imageUrl;
            this.loading = false;
            });
        }
        },
        beforeUpload(file) {
        const isJpgOrPng = file.type === 'application/pdf' || file.type === 'application/pdf';
        if (!isJpgOrPng) {
            this.$message.error('You can only upload PDF file!');
        }
        const isLt2M = file.size / 1024 / 1024 < 20;
        if (!isLt2M) {
            this.$message.error('Image must smaller than 20MB!');
        }
        return isJpgOrPng && isLt2M;
        },
        handleConfirmBlur(e) {
        const value = e.target.value;
        this.confirmDirty = this.confirmDirty || !!value;
        },
    },
  }
</script>
