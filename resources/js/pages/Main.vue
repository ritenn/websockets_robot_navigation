<template>
    <manage-configurations  v-if="openManager" ></manage-configurations>
    <connect v-else></connect>
</template>

<script>
    import { mapState, mapActions } from 'vuex'

    export default {
        computed: {
            ...mapState('connections', ['openManager'])
        },
        mounted() {
        },
        data() {
            return {
                configurationManager: false
            }
        },
        methods: {

        }
    }
</script>
