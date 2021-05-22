<template>
    <div>
        <v-row>
            <v-col
            xs="12"
            sm="6"
            md="6"
            lg="6"
            xl="6">
                <graf/>
            </v-col>
            <v-col
            xs="12"
            sm="6"
            md="6"
            lg="6"
            xl="6">
                <grafPostRead/>
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12">
                <subscriptions/>
            </v-col>
        </v-row>
    </div>
</template>
<script>
import graf from './graf.vue';
import grafPostRead from './grafPostRead.vue';
import subscriptions from './subscriptions.vue';
export default {
    components:{graf,subscriptions,grafPostRead}


}
</script>
