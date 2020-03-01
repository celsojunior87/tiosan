<template>
    <v-app id="app">
        <v-content>
            <v-container fluid pa-0>
                <div class="background-shapes-wrapper">
                    <div class="background-shapes-container">
                        <div class="background-shape circle-one"></div>
                        <div class="background-shape circle-two"></div>
                        <div class="background-shape square-one"></div>
                        <div class="background-shape square-two"></div>
                        <div class="background-shape square-three"></div>
                        <div class="background-shape triangle-two"></div>
                        <div class="background-shape triangle-three"></div>
                        <div class="background-shape rectangle-one"></div>
                        <div class="background-shape rectangle-two"></div>
                    </div>
                </div>
                <v-layout row wrap>
                    <v-flex xs12 sm4 id="sign-in-text-wrapper" v-bind:class="{ switch: isSwitch }">
                        <v-layout column align-center justify-center fill-height pa-3>
                            <div class="login-wrapper text-xs-center mb-3 pa-5">
                                <div class="display-1 font-weight-black mb-3"
                                     v-if="isSwitch">
                                    Já tem conta?
                                </div>
                                <div class="display-1 font-weight-black mb-3"
                                     v-else>
                                    É novo aqui?
                                </div>
                                <span class="subheading"
                                      v-if="isSwitch">
                                    Clique aqui e faça seu login.
                                </span>
                                <span class="subheading"
                                      v-else>
                                    Clique aqui e faça seu cadastro.
                                </span>
                            </div>
                            <v-btn round outline large dark ripple
                                   class="btn-pulse"
                                   v-if="isSwitch"
                                   id="sign-up"
                                   @click="isSwitch = !isSwitch">
                                Logar
                            </v-btn>
                            <v-btn round outline large dark ripple v-else
                                   class="btn-pulse"
                                   id="sign-in"
                                   @click="isSwitch = !isSwitch">
                                Registrar
                            </v-btn>
                        </v-layout>
                    </v-flex>
                    <v-flex xs12 sm8 id="sign-up-form-wrapper" class="active" v-bind:class="{ switch: isSwitch}"
                            v-if="isSwitch">
                        <v-form v-model="valid">
                            <v-layout column align-center justify-center pa-3 mt-5>
                                <v-flex xs12 mb-3 mt-5>
                                    <div class="login-wrapper text-xs-center">
                                        <div class="display-1 font-weight-black">Cadastro</div>
                                    </div>
                                </v-flex>
<!--                                <v-flex xs12 class="form-wrapper">-->
<!--                                    <v-text-field v-model="formNew.empresa"-->
<!--                                                  prepend-icon="business_center"-->
<!--                                                  required-->
<!--                                                  box full-width single-line-->
<!--                                                  label="Empresa"-->
<!--                                                  background-color="#f4f8f7"-->
<!--                                                  color="grey darken-2"-->
<!--                                                  prepend-inner-icon="mdi-email-outline">-->
<!--                                    </v-text-field>-->
<!--                                    <v-text-field v-model="form.email"-->
<!--                                                  :rules="emailRules"-->
<!--                                                  prepend-icon="email"-->
<!--                                                  required-->
<!--                                                  box full-width single-line-->
<!--                                                  label="E-mail"-->
<!--                                                  background-color="#f4f8f7"-->
<!--                                                  color="grey darken-2"-->
<!--                                                  prepend-inner-icon="mdi-email-outline">-->
<!--                                    </v-text-field>-->
<!--                                    <v-text-field v-model="form.email"-->
<!--                                                  :rules="emailRules"-->
<!--                                                  prepend-icon="person"-->
<!--                                                  required-->
<!--                                                  box full-width single-line-->
<!--                                                  label="Nome"-->
<!--                                                  background-color="#f4f8f7"-->
<!--                                                  color="grey darken-2"-->
<!--                                                  prepend-inner-icon="mdi-email-outline">-->
<!--                                    </v-text-field>-->
<!--                                    <v-text-field v-model="form.password"-->
<!--                                                  :rules="passwordRules"-->
<!--                                                  prepend-icon="lock"-->
<!--                                                  required-->
<!--                                                  :append-icon="show1 ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"-->
<!--                                                  type="password" box full-width single-line-->
<!--                                                  label="Password" background-color="#f4f8f7" color="grey darken-2"-->
<!--                                                  prepend-inner-icon="mdi-lock-outline">-->
<!--                                    </v-text-field>-->
<!--                                </v-flex>-->
                                <v-btn round large ripple
                                       :loading="btnLoading"
                                       :disabled="!valid"
                                       color="primary"
                                       disabled
                                       @click="login">
                                    Registrar
                                </v-btn>
                            </v-layout>
                        </v-form>
                    </v-flex>
                    <v-flex xs12 sm8 id="sign-up-form-wrapper" class="active" v-bind:class="{ switch: isSwitch}" v-else>
                        <v-form v-model="valid">
                            <v-layout column align-center justify-center pa-3 mt-5>
                                <v-flex xs12 mb-3 mt-5>
                                    <div class="login-wrapper text-xs-center">
                                        <div class="display-1 font-weight-black">Login</div>
                                    </div>
                                    <br/>
                                    <div class="text-xs-center" v-if="isEmailExists">
                                        <v-avatar size="120px">
                                            <img :src="getAvatarUser()" alt="avatar">
                                        </v-avatar>
                                    </div>
                                </v-flex>
                                <v-flex xs12 class="form-wrapper">
                                    <v-text-field v-model="form.email"
                                                  :rules="emailRules"
                                                  :disabled="disabledEmail"
                                                  prepend-icon="email"
                                                  required
                                                  box full-width single-line
                                                  label="E-mail"
                                                  background-color="#f4f8f7"
                                                  color="grey darken-2"
                                                  prepend-inner-icon="mdi-email-outline">
                                    </v-text-field>
                                    <v-text-field v-model="form.password"
                                                  v-if="isEmailExists"
                                                  :rules="passwordRules"
                                                  prepend-icon="lock"
                                                  required
                                                  :append-icon="show1 ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"
                                                  type="password" box full-width single-line
                                                  label="Password" background-color="#f4f8f7" color="grey darken-2"
                                                  prepend-inner-icon="mdi-lock-outline">
                                    </v-text-field>
                                </v-flex>
                                <div>
                                    <v-btn flat small color="primary" @click="resetForm">
                                        Limpar
                                    </v-btn>
                                    <v-btn round large ripple
                                           v-if="!isEmailExists"
                                           :loading="btnLoading"
                                           :disabled="!valid"
                                           color="primary"
                                           @click="checkEmail">
                                        Verificar e-mail
                                    </v-btn>
                                    <v-btn round large ripple
                                           v-else
                                           :loading="btnLoading"
                                           :disabled="!valid"
                                           color="primary"
                                           @click="login">
                                        Entrar
                                    </v-btn>
                                </div>
                            </v-layout>
                        </v-form>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
    import Form from 'vform'

    export default {
        layout: 'none',
        middleware: 'guest',
        metaInfo() {
            return {title: 'Login'}
        },
        data: () => ({
            user: null,
            isEmailExists: false,
            disabledEmail: false,
            show1: false,
            isSwitch: false,
            btnLoading: false,
            valid: false,
            invalidForm: false,
            emailRules: [
                v => !!v || 'E-mail é obrigatório',
                v => /.+@.+/.test(v) || 'Precisa ser um e-mail válido'
            ],
            passwordRules: [
                v => !!v || 'Senha é obrigatória',
            ],
            form: new Form({
                email: '',
                password: ''
            }),
            formNew: new Form({
                email: '',
                password: '',
                confirmPassword: '',
                empresa: ''
            }),
            drawer: null
        }),
        methods: {
            async checkEmail() {
                try {
                    this.btnLoading = true
                    let res = await this.form.post('/api/check-email')
                    this.user = res.data.user
                    this.btnLoading = false
                    this.isEmailExists = true
                    this.disabledEmail = true
                } catch (err) {
                    err.response.data.error.msg.forEach((errors) => {
                        this.$toasted.error(errors);
                    })
                    this.btnLoading = false
                }

            },
            async login() {
                if (!this.valid) {
                    return
                }
                this.btnLoading = true
                try {
                    const {data} = await this.form.post('/api/login')
                    this.$store.dispatch('setToken', {
                        token: data.token
                    })

                    // Fetch the user.
                    await this.$store.dispatch('setUser')
                    this.$router.push({name: 'dashboard'})
                    this.$toasted.success('Bem vindo, ' + helper.getUserName('name'));
                } catch (err) {
                    this.btnLoading = false
                    this.$toasted.error('Senha inválida');
                }
                this.btnLoading = false
            },
            preencherLogin() {
                this.form.email = 'admin@admin.com'
                this.form.password = '123456';
            },
            getVersion() {
                return helper.getVersion()
            },
            resetForm() {
                this.form = new Form({
                    email: '',
                    password: ''
                })
                this.btnLoading = false
                this.isEmailExists = false
                this.disabledEmail = false
            },
            getAvatarUser() {
                return this.user.photo_url
            }
        },
        props: {
            source: String
        }
    }
</script>

<style scoped>
    @keyframes shadow-pulse {
        0% {
            box-shadow: 0 0 0 0px rgba(0, 0, 0, 0.2);
        }
        100% {
            box-shadow: 0 0 0 35px rgba(0, 0, 0, 0);
        }
    }

    @keyframes shadow-pulse-big {
        0% {
            box-shadow: 0 0 0 0px rgba(0, 0, 0, 0.1);
        }
        100% {
            box-shadow: 0 0 0 70px rgba(0, 0, 0, 0);
        }
    }
    .btn-pulse {
        animation: shadow-pulse 2s infinite;
    }
    .container {
        min-height: 530px;
        height: 100vh;
        width: 100vw;
        background-image: linear-gradient(253deg, rgba(87, 85, 87, 0.82) 0, #575557 100%);
        color: white;
    }

    .form-wrapper {
        min-width: 50%;
    }

    .layout.wrap {
        height: 100vh;
    }

    .active {
        background: #fff;
        color: #575557;
    }

    #sign-in,
    .switch #sign-up {
        /*width: 60%;*/
    }

    #sign-up,
    .switch #sign-in {
        min-width: 25%;
        width: auto;
    }

    .form-wrapper .v-input__control > .v-input__slot {
        background: rgba(244, 248, 247, 1);
    }

    .form-wrapper .v-text-field.v-text-field--enclosed .v-text-field__details {
        margin-bottom: 0px;
        height: 0px;
    }

    #sign-in-text-wrapper {
        background-image: linear-gradient(253deg, #575557 0, #807e80 100%);
        position: absolute;
        animation: 0.75s linear slide-back-left;
        left: 0;
        right: auto;
        height: 100vh;
        width: 33%;
    }

    #sign-up-form-wrapper {
        position: absolute;
        animation: 0.75s linear slide-back-right;
        right: 0;
        left: auto;
        height: 100vh;
        width: 67%;
    }

    #sign-in-text-wrapper.switch {
        background-image: linear-gradient(253deg, #575557 0, #807e80 100%);
        right: 0;
        left: auto;
        animation: 0.75s linear slide-right;
        -webkit-animation-fill-mode: both;
    }

    #sign-up-form-wrapper.switch {
        left: 0;
        animation: 0.75s linear slide-left;
    }

    @keyframes slide-left {
        0% {
            left: 33%;
            opacity: 0;
        }
        50% {
            left: 25%;
            opacity: 0;
        }
        100% {
            left: 0;
            opacity: 1;
        }
    }

    @keyframes slide-right {
        0% {
            right: 100%;
            width: 33%;
            z-index: 1;
        }
        20% {
            right: 75%;
            width: 60%;
            max-width: 60%;
            z-index: 1;
        }
        100% {
            right: 0;
            width: 33%;
            max-width: 35%;
            z-index: 1;
        }
    }

    @keyframes slide-back-left {
        0% {
            left: 67%;
            width: 33%;
            z-index: 1;
        }
        20% {
            left: 50%;
            width: 60%;
            max-width: 60%;
            z-index: 1;
        }
        100% {
            left: 0;
            width: 33%;
            z-index: 1;
        }
    }

    @keyframes slide-back-right {
        0% {
            left: 0;
            opacity: 0;
        }
        50% {
            left: 25%;
            opacity: 0;
        }
        100% {
            left: 33%;
            opacity: 1;
        }
    }

    .background-shapes-wrapper {
        position: absolute;
        width: 100vw;
        height: 100%;
        top: 0;
        overflow: hidden;
    }

    .background-shapes-container {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .background-shape {
        position: absolute;
        background-color: rgba(255, 255, 255, 0.1);
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        z-index: 10;
    }

    .square-one {
        width: 30px;
        height: 30px;
        top: 15%;
        left: 20%;
        -webkit-transform: rotate(-65deg);
        transform: rotate(-65deg);
    }

    .square-two {
        width: 25px;
        height: 25px;
        top: 55%;
        right: 1%;
        -webkit-transform: rotate(-65deg);
        transform: rotate(-65deg);
    }

    .square-three {
        width: 50px;
        height: 50px;
        top: 30%;
        left: 45%;
        -webkit-transform: rotate(-65deg);
        transform: rotate(-65deg);
    }

    .circle-one {
        width: 250px;
        height: 250px;
        border-radius: 100%;
        bottom: -125px;
        left: -125px;
    }

    .circle-two {
        width: 30px;
        height: 30px;
        bottom: 20%;
        right: 25%;
        border-radius: 100%;
    }

    .triangle-one {
        width: 0;
        height: 0;
        border-top: 69px solid transparent;
        border-bottom: 48px solid transparent;
        border-left: 90px solid rgba(255, 255, 255, 0.08);
        top: 45%;
        left: 30%;
        background-color: transparent;
        -webkit-transform: rotate(-100deg);
        transform: rotate(-100deg);
    }

    .triangle-two {
        width: 0;
        height: 0;
        border-top: 200px solid transparent;
        border-bottom: 130px solid transparent;
        border-left: 180px solid rgba(255, 255, 255, 0.1);
        top: -150px;
        right: -80px;
        background-color: transparent;
        -webkit-transform: rotate(-80deg);
        transform: rotate(-80deg);
    }

    .triangle-three {
        width: 0;
        height: 0;
        border-top: 68px solid transparent;
        border-bottom: 49px solid transparent;
        border-left: 90px solid rgba(255, 255, 255, 0.08);
        right: 10%;
        bottom: 1%;
        background-color: transparent;
        transform: rotate(-170deg);
    }

    .rectangle-one {
        width: 25px;
        height: 50px;
        top: 80%;
        left: 25%;
        -webkit-transform: rotate(-55deg);
        transform: rotate(-55deg);
    }

    .rectangle-two {
        width: 15px;
        height: 30px;
        top: 42%;
        right: 23%;
        -webkit-transform: rotate(-55deg);
        transform: rotate(-55deg);
    }

</style>
