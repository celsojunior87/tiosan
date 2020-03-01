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
                    <v-btn icon x-large v-on="on">
                         <v-avatar
                        :tile="false"
                        size="50px"
                        color="black"
                        class="text-center center"
                    >
                        <img src="https://scontent.fbsb3-1.fna.fbcdn.net/v/t1.0-9/66618135_380208702640162_335163644163653632_n.jpg?_nc_cat=100&_nc_sid=85a577&_nc_ohc=Sv28ZoU1SB8AX_qhusK&_nc_ht=scontent.fbsb3-1.fna&oh=a89a46472a55d4bd08e7cb500f8d382c&oe=5EBE0BCC" alt="avatar">
                    </v-avatar>

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
