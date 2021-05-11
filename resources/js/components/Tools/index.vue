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
                    mdi-playlist-check
                    </v-icon>
                    Invoices
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
                        <Users/>
                    </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat>
                    <v-card-text>
                        <Roles/>
                    </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item>
                    <v-card flat>
                        <!---->
                        <ChefConf/>
                    </v-card>
                </v-tab-item>
                </v-tabs>
        </v-row>
    </div>
</template>
<script>
    import ChefConf from './ChefConf/index.vue';
    import Users from './Users/index.vue';
    import Roles from './Permissions/rolos.vue';
    import graf from './graf.vue';
    import grafPostsReads from './grafPostsReads.vue';
    import grafUser from './grafUser.vue';
    import subscriptions from './invoices/invoicePlan.vue';
export default {
    components: { Users,ChefConf,Roles,graf,grafPostsReads,grafUser, subscriptions },
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
