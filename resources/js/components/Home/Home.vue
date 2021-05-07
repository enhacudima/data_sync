<template>
    <div>
        <v-row>
            <v-col cols="4">
                <graf/>
            </v-col>
            <v-col cols="4">
                <graf/>
            </v-col>
            <v-col cols="4">
                <graf/>
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
import subscriptions from './subscriptions.vue';
export default {
    components:{graf,subscriptions}


}
</script>
