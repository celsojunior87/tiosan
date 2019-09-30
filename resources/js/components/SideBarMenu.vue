<template>
    <v-list dense>
        <v-list-tile v-for="item in items" :key="item.text"  @click=""  :to="item.route" exact>
            <v-list-tile-action>
                <v-icon>{{ item.icon }}</v-icon>
            </v-list-tile-action>
            <v-list-tile-content>
                <v-list-tile-title>
                    {{ item.text }}
                </v-list-tile-title>
            </v-list-tile-content>
        </v-list-tile>
        <v-list-tile class="mt-3" @click="">
        </v-list-tile>
        <v-list-tile @click="">
            <v-list-tile-action>
            </v-list-tile-action>
        </v-list-tile>
    </v-list>
</template>

<script>
    export default {
        name:"SideBarMenu",
        data: () => ({

            drawer: null,
            items: [
                {icon: 'dashboard', text: 'Dashboard', route: '/dashboard'},
                { icon: 'supervisor_account', text: 'Clientes', route:'/clientes'},
                { icon: 'airport_shuttle', text: 'Tipo veiculos', route:'/tipo-veiculo' },
                { icon: 'directions_car', text: 'Veiculos', route:'/veiculo' },
                { icon: 'business_center', text: 'Tipo Serviços', route:'/tipo-servico' },
                { icon: 'local_car_wash', text: 'Serviços' ,route:'/servico' },
                { icon: 'print', text: 'Relatórios' ,route:'/relatorio' }
            ],
        }),
        props: {
            source: String
        },
        methods: {
            /**
             * Busca o nome do uusário
             * @returns {*}
             */
            getUserNameAuth() {
                return helper.getUserName()
            },
            /**
             * Busca a foto do usuário
             * @returns {*}
             */
            getUserAvatar() {
                return helper.getUserAvatar()
            },
            /**
             * Verifica se o usuário é admin
             * @returns {*|boolean}
             */
            isAdmin() {
                return helper.isAdmin()
            },
            /**
             * Verifica se usuário tem permissão para ver o item do menu
             * @param role
             * @returns {*|boolean}
             */
            hasPermission(role) {
                return helper.hasPermission(role)
            },
            getNameEmpresa() {
                return helper.getNameEmpresa()
            }
        }

    }
</script>


<style scoped>

</style>
