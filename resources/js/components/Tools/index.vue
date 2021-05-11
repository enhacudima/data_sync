<template>
    <div>
        <v-row>
            <v-col cols="4">
                <graf/>
            </v-col>
            <v-col cols="4">
                <grafPostsReads/>
            </v-col>
            <v-col cols="4">
                <grafUser/>
            </v-col>
        </v-row>
        <v-row>
            <v-tabs class="pt-6" >
                <v-tab>
                    <v-icon left>
                    mdi-receipt
                    </v-icon>
                    Invoices
                </v-tab>
                <v-tab>
                    <v-icon left>
                    mdi-playlist-check
                    </v-icon>
                    Plans Maneger
                </v-tab>
                <v-tab>
                    <v-icon left>
                    mdi-account-supervisor-outline
                    </v-icon>
                    Users
                </v-tab>
                <v-tab>
                    <v-icon left>
                    mdi-script-text-outline
                    </v-icon>
                    Roles
                </v-tab>
                <v-tab>
                    <v-icon left>
                    mdi-wrench-outline
                    </v-icon>
                    Options
                </v-tab>
                <v-tab>
                    <v-icon left>
                    mdi-email-outline
                    </v-icon>
                    Messages
                </v-tab>

                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                        <subscriptions/>
                    </v-card-text>
                    </v-card>
                </v-tab-item>

                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                        <plans/>
                    </v-card-text>
                    </v-card>
                </v-tab-item>

                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                        <users/>
                    </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                        <roles/>
                    </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat>
                        <chefConf/>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat>
                        <messages/>
                    </v-card>
                </v-tab-item>
                </v-tabs>
        </v-row>
    </div>
</template>
<script>
    import chefConf from './ChefConf/index.vue';
    import users from './Users/index.vue';
    import roles from './Permissions/rolos.vue';
    import graf from './graf/graf.vue';
    import grafPostsReads from './graf/grafPostsReads.vue';
    import grafUser from './graf/grafUser.vue';
    import subscriptions from './invoices/invoicePlan.vue';
    import plans from './Plans/plans.vue';
    import messages from './messages/messages.vue';
export default {
    components: { users,chefConf,roles,graf,grafPostsReads,grafUser, subscriptions, plans, messages },
    data() {
        return {
            tab:null,

        }
    },
    methods: {

        },
    mounted() {

    },

    watch: {
    }
}
</script>
