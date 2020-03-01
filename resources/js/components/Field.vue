<template>
    <div class="inline field">
        <the-mask :mask="mask" :tokens="tokens" v-model="editableValue" disabled :placeholder="placeholder" :masked="masked" :type="type || 'tel'"></the-mask>
    </div>
</template>

<script>
    import {TheMask} from 'vue-the-mask'
    export default {
        name: 'field',
        components: {TheMask},
        props: ['label', 'mask', 'placeholder', 'masked', 'type', 'tokens', 'value'],
        data () {
            return {
                editableValue: this.value
            }
        }
    }
</script>

<style lang="css">
    .ui.form .inline.field label {
        width: 90px;
    }
</style>
