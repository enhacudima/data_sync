<template>
<div class="text-center">
    <v-dialog
      v-model="showDialogoPlan"
      width="1200"

    >

      <v-card >
        <v-card-title class="headline grey lighten-2">
        Subscriptions
        </v-card-title>

        <v-card-text>
            <v-row justify="center"
                    class="pa-6">
                <v-simple-table
                    fixed-header
                    height="300px"
                >
                    <template v-slot:default>
                    <thead>
                        <tr>
                        <th class="text-left">
                            #
                        </th>
                        <th class="text-left">
                            name
                        </th>
                        <th class="text-left">
                            slug
                        </th>
                        <th class="text-left">
                            created_at
                        </th>
                        <th class="text-left">
                            updated_at
                        </th>
                        <th class="text-left">
                            starts_at
                        </th>
                        <th class="text-left">
                            ends_at
                        </th>
                        <th class="text-left">
                            trial_ends_at
                        </th>
                        <th class="text-left">
                            canceled_at
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                        v-for="item in plans"
                        :key="item.name"
                        >
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{ item.slug }}</td>
                        <td>{{formatDate(item.created_at)}}</td>
                        <td> {{formatDate(item.updated_at)}}</td>
                        <td>{{formatDate(item.starts_at)}}</td>
                        <td>{{formatDate(item.ends_at)}}</td>
                        <td>{{formatDate(item.trial_ends_at)}}</td>
                        <td>{{formatDate(item.canceled_at)}}</td>
                        </tr>
                    </tbody>
                    </template>
                </v-simple-table>
            </v-row>
        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="primary"
            text
            @click="showDialogoPlan= !showDialogoPlan"
          >
            Close
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
  export default {
    components: { },
    props: {
        user:Number,
        value: Boolean,
        show: {
            type:Boolean
        },
    },
    created () {
        //console.log(555)
    },
    data() {
        return {
            showDialogoPlanPlan:false,
            plans: null,

        }
    },

    computed: {
        showDialogoPlan: {
        get () {
            return this.value
        },
        set (value) {
             this.$emit('update:show', value)
        }
        },
    },
    methods: {

        formatDate(date) {
            return moment(date).format('DD-MM-YYYY HH:mm:ss');
        },
        close(){
            this.$emit('update:show', false)
        },

        getData(){
        axios
            .get('plan-get-user-plan/'+this.user)
            .then(
                response => (this.plans = response.data)
            );
        },
    },

    watch:{

        showDialogoPlan(val){
            this.getData()
        },
        user(val){
            //console.log(val)
        }
    }
  }
</script>
