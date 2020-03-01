<template>
    <div>
        profile
    </div>
</template>

<script>
    export default {
        middleware: 'guest',
        data: () => ({
            form: new Form({
                name: '',
                email: ''
            })
        }),

        methods: {
            async update() {
                const {data} = await this.form.patch('/api/settings/profile')

                this.$store.dispatch('auth/updateUser', {user: data})
            }
        }
    }
</script>
