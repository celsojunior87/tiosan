export default {

    loading: null,

    show() {
        this.loading = Vue.$loading.show()
    },

    hide() {
        this.loading.hide()
    }
}
