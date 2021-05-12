<template>
<div class="text-center">
    <v-dialog
      v-model="showDialogoPlan"
      width="1200"

    >

      <v-card >
        <v-card-title class="headline grey lighten-2">
        {{$t('subscriptions')}}
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
                            {{$t('name')}}
                        </th>
                        <th class="text-left">
                            {{$t('created_at')}}
                        </th>
                        <th class="text-left">
                            {{$t('updated_at')}}
                        </th>
                        <th class="text-left">
                            {{$t('starts_at')}}
                        </th>
                        <th class="text-left">
                            {{$t('ends_at')}}
                        </th>
                        <th class="text-left">
                            {{$t('trial_ends_at')}}
                        </th>
                        <th class="text-left">
                            {{$t('canceled_at')}}
                        </th>

                        <th class="text-left" v-if="$can('cancel_subscription')">
                            {{$t('actions')}}
                        </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                        v-for="item in plans"
                        :key="item.id"
                        >
                        <td>{{ item.id }}</td>
                        <td>{{ item.name }}</td>
                        <td>{{formatDate(item.created_at)}}</td>
                        <td> {{formatDate(item.updated_at)}}</td>
                        <td>{{formatDate(item.starts_at)}}</td>
                        <td>{{formatDate(item.ends_at)}}</td>
                        <td>{{formatDate(item.trial_ends_at)}}</td>
                        <td>{{formatDate(item.canceled_at)}}</td>
                        <td v-if="$can('cancel_subscription')">
                            <v-btn
                            small
                            color="#e1b80d"
                            @click="dialogApply(item.id,item.slug)"
                            >
                                <v-icon
                                    v-if="item.canceled_at != null"
                                >
                                    mdi-close-octagon-outline
                                </v-icon>
                                <template v-else>
                                    Cancel
                                </template>
                            </v-btn>

                        </td>
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

    <v-dialog v-model="showConfimation" max-width="500px">
        <v-card>
        <v-card-title class="headline">Are you sure you want to cancel this subscription?</v-card-title>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="now">Yes Rigth now</v-btn>
            <v-btn color="blue darken-1" text @click="yes">Yes</v-btn>
            <v-btn color="blue darken-1" text @click="showConfimation=!showConfimation">No</v-btn>
            <v-spacer></v-spacer>
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
            showConfimation: false,
            id:null,
            subscription:null,

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
        dialogApply(id, slug){
            this.id =id,
            this.subscription = slug;
            this.showConfimation= !this.showConfimation
        },
        yes(){
        axios
            .get('plan-subscription-renew/cancel/'+this.subscription+'/'+this.user)
            .then(
                response => (this.showConfimation= !this.showConfimation, this.getData())
            );

        },
        now(){
        axios
            .get('plan-subscription-renew/cancelRigthNow/'+this.subscription+'/'+this.user)
            .then(
                response => (this.showConfimation= !this.showConfimation, this.getData())
            );

        },
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
