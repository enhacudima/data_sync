<template>
    <div>
        <v-row>
            <v-col cols="6">
                <graf/>
            </v-col>
            <v-col cols="6">
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
