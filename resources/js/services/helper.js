import store from '../store'
import router from '../router'

export default {

    /*
     * Retorna a empresa do usuário logado
     */
    getNameEmpresa() {
        let empresa = this.getUserParam('empresa')
        return empresa.nome
    },

    /*
     * Retorna parâmetros do usuário logado
     */
    getUserParam(name) {
        let user = store.getters.getAuthUser
        return user[name]
    },

    /*
     * Retorna usuário logado
     */
    getAuthUser() {
        return store.getters.getAuthUser
    },

    /*
     * Retorna nome do usuário logado
     */
    getUserName() {
        return this.getUserParam('name')
    },

    /*
     * Retorna foto do usúario logado
     */
    getUserAvatar() {
        return this.getUserParam('photo_url')
    },

    /*
     * Checa se usuário logado é administrador
     */
    isAdmin() {
        return store.getters.isAdmin
    },

    /*
     * Retorna versão do sistema atual
     */
    getVersion() {
        return store.getters.getVersion
    },

    hasPermission(role) {
        if(role === 'admin') {
            return this.isAdmin()
        }
        return true;
    },

    // to append filter variables in the URL
    getFilterURL(data){
        let url = '';
        $.each(data, function(key,value) {
            url += (value) ? '&'+key+'='+encodeURI(value) : '';
        });
        return url;
    },

    // to get date in desired format
    formatDate(date){
        if(!date)
            return;

        return moment(date).format(this.getConfig('date_format'));
    },

    // to get date time in desired format
    formatDateTime(date){
        if(!date)
            return;
        var date_format = this.getConfig('date_format');
        var time_format = this.getConfig('time_format');

        return moment(date).format(date_format+' '+time_format);
    },

    // to get time from now
    formatDateTimeFromNow(datetime){
        if(!datetime) return;
        return moment(datetime).fromNow();
    },

    formatDateDiff(dateBegin, dateEnd) {
       var a = moment(dateBegin);
       var b = moment(dateEnd);

       return a.diff(b, 'days');
    },

    // to change first character of every word to upper case
    ucword(value){
        if(!value)
            return;

        return value.toLowerCase().replace(/\b[a-z]/g, function(value) {
            return value.toUpperCase();
        });
    },

    // to change string into human readable format
    toWord(value){
        if(!value)
            return;

        value = value.replace(/-/g, ' ');
        value = value.replace(/_/g, ' ');

        return value.toLowerCase().replace(/\b[a-z]/g, function(value) {
            return value.toUpperCase();
        });
    },

    // shows toastr notification for axios request
    showDataErrorMsg(error){
        this.setLastActivity();
        if(error.hasOwnProperty("error")){
            if (error.error.indexOf(' ') >= 0)
                toastr.error(error.error);
            else
                toastr.error(i18n.general[error.error]);

            if(error.error === 'token_expired')
                router.push('/login');
        } else if(error.hasOwnProperty("response") && error.response.status == 403) {
            toastr.error(i18n.general.permission_denied);
        } else if(error.hasOwnProperty("response") && error.response.status == 422 && error.response.data.hasOwnProperty("error")) {
            toastr.error(error.response.data.error);
        } else if(error.hasOwnProperty("response") && error.response.status == 404) {
            toastr.error(i18n.general.invalid_link);
        } else if(error.response.data.errors.hasOwnProperty("message"))
            toastr.error(error.response.data.errors.message[0]);
    },

    // returns error message for axios request
    fetchDataErrorMsg(error){
        return error.response.data.errors.message[0];
    },

    // shows toastr notification for axios form request
    showErrorMsg(error){
        this.setLastActivity();

        if(error.hasOwnProperty("error")){

            if (error.error.indexOf(' ') >= 0)
                toastr.error(error.error);
            else
                toastr.error(i18n.general[error.error]);

            if(error.error === 'token_expired')
                router.push('/login');
        } else if(error.hasOwnProperty("response") && error.response.status == 403) {
            toastr.error(i18n.general.permission_denied);
        } else if(error.hasOwnProperty("response") && error.response.status == 422 && error.response.data.hasOwnProperty("error")) {
            toastr.error(error.response.data.error);
        } else if(error.hasOwnProperty("response") && error.response.status == 404) {
            toastr.error(i18n.general.invalid_link);
        } else if(error.errors.hasOwnProperty("message")) {
            if (typeof error.errors.message[0] == 'undefined' ) {
                toastr.error(i18n.general.form_invalid);
            } else {
                toastr.error(error.errors.message[0]);

            }
        }
    },

    // returns error message for axios form request
    fetchErrorMsg(error){
        return error.errors.message[0];
    },

    // round numbers as given precision
    roundNumber(number, precision){
        precision = Math.abs(parseInt(precision)) || 0;
        var multiplier = Math.pow(10, precision);
        return (Math.round(number * multiplier) / multiplier);
    },

    // round numbers as given precision
    formatNumber(number,decimal_place){
        if (decimal_place === undefined)
            decimal_place = 2;
        return this.roundNumber(number,decimal_place);
    },

    // fill number with padding
    formatWithPadding(n, width, z){
        z = z || '0';
        n = n + '';
        return n.length >= width ? n : new Array(width - n.length + 1).join(z) + n;
    },

    // generates random string of certain length
    randomString(length) {
        if (length === undefined)
            length = 40;
        var chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        var result = '';
        for (var i = length; i > 0; --i) result += chars[Math.floor(Math.random() * chars.length)];
        return result;
    },
}
