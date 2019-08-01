<template>
    <div>
        <v-dialog v-model="dialog" persistent max-width="1000px">
            <v-card>
                <v-card-title>
                    <span class="headline">Clientes</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs8>
                                <v-text-field label="Nome" v-model="formCliente.nome" name="nome" required ></v-text-field>
                                <show-error :form-name="formCliente" prop-name="nome"></show-error>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="Telefone" v-model="formCliente.telefone" mask=" (##) #####-####"
                                              required></v-text-field>
                                <show-error :form-name="formCliente" prop-name="telefone"></show-error>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="Email" v-model="formCliente.email" required></v-text-field>
                                <show-error :form-name="formCliente" prop-name="email"></show-error>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="Cep" @change="buscarCep" v-model="formCliente.cep"
                                              required></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="UF" v-model="formCliente.uf"
                                              required></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="Cidade" v-model="formCliente.cidade"
                                              required></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="Bairro" v-model="formCliente.bairro"
                                              required></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="Complemento" v-model="formCliente.complemento"
                                              required></v-text-field>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="dialog = false">Fechar</v-btn>
                    <v-btn color="red" @click="salvar">Salvar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-card>
            <v-card-title>
                <v-btn fab dark color="red" @click="novo">
                    <v-icon dark>add</v-icon>
                </v-btn>
                Clientes
                <v-spacer></v-spacer>
                <v-text-field
                        v-model="search"
                        append-icon="search"
                        label="Pesquisar"
                        single-line
                        hide-details
                ></v-text-field>
            </v-card-title>
            <v-data-table
                    :headers="headers"
                    :items="cliente"
                    :search="search"
                    rows-per-page-text="por página"
                    no-results-text="Nenhum registro encontrado"
                    :rows-per-page-items="rowsPerPageItems"
            >
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.nome }}</td>
                    <td class="text-xs-left">{{ props.item.email }}</td>
                    <td class="text-xs-left">
                        <field mask="(##) #####-####" :value="props.item.telefone" :masked="masked"></field>
                    </td>

                    <td class="text-xs-center">
                        <v-btn small color="blue" @click="editar(props.item.id)">
                            <v-icon dark left>edit</v-icon>
                            Editar
                        </v-btn>
                        <v-btn small color="error" @click="remover(props.item.id)">
                            <v-icon dark left>clear</v-icon>
                            Excluir
                        </v-btn>
                    </td>
                </template>
                <v-alert v-slot:no-results :value="true" color="error" icon="warning">
                    Your search for "{{ search }}" found no results.
                </v-alert>
            </v-data-table>
        </v-card>
    </div>
</template>

<script>
    import Field from '../../components/Field'
    import {mask} from 'vue-the-mask'

    export default {
        components: {Field},
        directives: {mask},
        name: "index",
        data: () => ({
            masked: true,
            rowsPerPageItems: [10,25,{"text":"","value":10}],
            dialog: false,
            search: '',
            cliente: [],
            headers: [
                {text: 'Nome', value: 'nome'},
                {text: 'Email', value: 'email'},
                {text: 'Telefone', value: 'email'},
                {text: 'Ações', value: '', align: 'center'},
            ],
            formCliente: new Form({
                id: '',
                nome: '',
                telefone: '',
                email:'',
                cep:'',
                uf:'',
                cidade:'',
                bairro:'',
                complemento:'',
            })
        }),
        methods: {

            buscarCep(){

                axios
                    .get('https://viacep.com.br/ws/72005195/json/'+ this.cliente.cep)
                        console.log(this.formCliente.cep)
            },
            getCliente() {
                loading.show();
                axios
                    .get('/api/cliente')
                    .then((res) => {
                        this.cliente = res.data;
                    })
                    .finally(() => {
                        loading.hide()
                    })
            },


            novo() {
                this.resetForm()
                this.dialog = true
            },
            editar(id) {
                axios
                    .get('/api/cliente/'+id)
                    .then((res) => {
                        this.formCliente = res.data
                        this.dialog = true
                    })
            },
            remover(id) {
                this.$swal({
                    title: 'Deseja excluir?',
                    text: "Cuidado, exclusão permanente",
                    type: 'warning',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim'
                }).then((result) => {
                    if (result.value) {
                        axios
                            .delete('/api/cliente/' + id)
                            .then((response) => {
                                if (response.data.status == 'success') {
                                    this.$swal.fire(
                                        'Excluído!',
                                        '',
                                        'success'
                                    )
                                    this.getCliente();
                                } else {
                                    this.$swal.fire(
                                        'Cliente não foi excluído',
                                        '',
                                        'error'
                                    )
                                }
                            })
                    }
                })
            },
            salvar() {
                loading.show();
                if(this.formCliente.id) {
                    axios.put('/api/cliente/'+this.formCliente.id, this.formCliente)
                        .then((response) => {
                            this.dialog = false
                            loading.hide();
                            this.$toasted.success(response.data.msg)
                            this.getCliente();
                        })
                        .catch((error) => {
                            loading.hide();
                            this.$toasted.error(error.msg)
                        })
                } else {
                    this.formCliente.post('/api/cliente')
                        .then((response) => {
                            this.dialog = false
                            loading.hide();
                            this.$toasted.success(response.msg)
                            this.getCliente();
                        })
                        .catch((error) => {
                            loading.hide();
                            this.$toasted.error(error.msg)
                        })
                }
            },
            resetForm() {
                this.formCliente = new Form({
                    id: '',
                    nome: '',
                    telefone: '',
                    email:'',
                    cep:'',
                    uf:'',
                    cidade:'',
                    bairro:'',
                    complemento:'',
                })
            }
        },
        mounted() {
            this.getCliente()
        },
    }
</script>
