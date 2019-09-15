<template>
    <v-footer :inset="true"
              app
              color="grey darken-4"
              class="text--white text-white"
    >
        <span class="px-3">&copy; {{ new Date().getFullYear() }}</span>
        <span class="text-right right">V -2.0</span>
    </v-footer>
</template>

<script>
    export default {
        name: "Footer",
        data: () => ({

        }),
        methods: {
            getVersion() {
                return helper.getVersion()
            }
        }
    }
</script>

<style scoped>

</style>
