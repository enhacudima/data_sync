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
              New Role
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
                      label="Role name"
                      outlined
                    ></v-text-field>
                  </v-col>
                  <v-col
                    cols="12"
                  >
                    <v-autocomplete
                        v-model="editedItem.permissions"
                        :items="permissions"
                        label="Permissions"
                        item-text="name"
                        item-value="id"
                        return-object
                        outlined
                        dense
                        multiple
                    >
                        <template v-slot:selection="{ item }">
                            <v-chip
                                class="ma-2"
                                small>
                                {{ item.name.replaceAll('_', ' ').toUpperCase() }}
                            </v-chip>

                        </template>

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
        small
        @click="deleteItem(item)"
      >
        mdi-delete
      </v-icon>
    </template>
    <template v-slot:item.permissions="{ item }">
        <v-chip
        v-for="(permission) in item.permissions"
        :key="permission.id"
        class="ma-2"
        small
        >
        {{ permission.name.replaceAll('_', ' ')}}
        </v-chip>
    </template>
    <template v-slot:item.name="{ item }">
        {{item.name.toUpperCase()}}
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
      selected:[],
      permissions:[],
      roles:[],
      dialog: false,
      dialogDelete: false,
      headers: [
        {
          text: 'Role',
          align: 'start',
          sortable: false,
          value: 'name',
        },
        { text: 'Permissions', value: 'permissions' },
        { text: 'Actions', value: 'actions', sortable: false },
      ],
      desserts: [],
      editedID:null,
      editedIndex: -1,
      editedItem: {
        name: '',
        permissions: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
      defaultItem: {
        name: '',
        permissions: 0,
        fat: 0,
        carbs: 0,
        protein: 0,
      },
    }),

    computed: {
      formTitle () {
        return this.editedIndex === -1 ? 'New Item' : 'Edit Item'
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
      initialize () {
         axios
          .get('getRoles')
          .then(response => (this.roles = response.data));

         axios
          .get('getPermissions')
          .then(response => (this.permissions = response.data));
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
          .get('role/delete/'+this.editedID)
          .then();

        this.closeDelete()
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
        this.initialize ()
        this.close()
      },


        sendData(data) {
            axios
            .post("role/create", { data: { roleData: data,roleDatID: this.editedID} })
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
    },
  }
</script>
