<template>
    <v-app id="inspire"
           dark
    >
        <v-navigation-drawer
                v-model="drawer"
                :clipped="$vuetify.breakpoint.lgAndUp"
                fixed
                app
        >
            <side-bar-menu/>
        </v-navigation-drawer>
        <v-toolbar
                :clipped-left="$vuetify.breakpoint.lgAndUp"
                color="red"
                dark
                app
                fixed
        >
            <v-toolbar-title style="width: 300px" class="ml-0 pl-3">
                <v-toolbar-side-icon @click.stop="drawer = !drawer"></v-toolbar-side-icon>
                <span class="hidden-sm-and-down">TIOSAN LAVA JATO
                </span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu offset-y>
                <template v-slot:activator="{ on }">
                    <v-btn icon large v-on="on">
                        <v-img size="2px" tile>
                            <img height="50px"
                                    src="https://scontent.fbsb3-1.fna.fbcdn.net/v/t1.0-1/p200x200/66618135_380208702640162_335163644163653632_n.jpg?_nc_cat=100&_nc_oc=AQnml6R-1DtnrY1OOx18Q3vel2_JFyo8YIqT0MnbugmQ8WbB83rqDmw8IXY0lHUsag3-OTRkUrr01JIYyKnvKFe5&_nc_ht=scontent.fbsb3-1.fna&oh=97a04cdb057034461b3cc1106f434643&oe=5DADBA44"
                                    alt="tiosan"
                            >
                        </v-img>
                    </v-btn>
                </template>
                <v-list>
                    <v-list-tile @click="logout">
                        <v-list-tile-title>Sair</v-list-tile-title>
                    </v-list-tile>
                </v-list>
            </v-menu>
        </v-toolbar>
        <v-content>
            <v-container>
                <child/>
            </v-container>
        </v-content>
        <Footer/>
    </v-app>
</template>


<script>
    import SideBarMenu from '../components/SideBarMenu'
    import Footer from '../components/Footer'

    export default {
        components: {
            SideBarMenu,
            Footer
        },
        data: () => ({
            logo: './sass/img/tiosan.png',
            drawer: null,
        }),
        methods: {
            async logout() {
                // Log out the user.
                await this.$store.dispatch('logout')

                // Redirect to login.
                this.$router.push({name: 'login'})
            },
            getUserAvatar() {
                return helper.getUserAvatar()
            },
        },
        props: {
            source: String
        }
    }
</script>
