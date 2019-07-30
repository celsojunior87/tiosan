<template>
    <div>
        <v-dialog v-model="dialog" persistent max-width="1000px">
            <v-card>
                <v-card-title>
                    <span class="headline">Veiculos</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs5>
                                <v-select
                                        v-if="tipoVeiculo"
                                        v-bind:items="tipoVeiculo"
                                        label="Tipo de Veiculo"
                                        item-text="nome"
                                        item-value="id"
                                        v-model="formVeiculo.id_tipo_veiculo"
                                        name="id_tipo_veiculo"
                                ></v-select>
                                <show-error :form-name="formVeiculo" prop-name="id_tipo_veiculo"></show-error>
                            </v-flex>
                            <v-flex xs5>
                                <v-autocomplete
                                        v-if="cliente"
                                        v-bind:items="cliente"
                                        label="Cliente"
                                        item-text="nome"
                                        item-value="id"
                                        v-model="formVeiculo.id_cliente"
                                        name="id_cliente"
                                ></v-autocomplete>
                                <show-error :form-name="formVeiculo" prop-name="id_cliente"></show-error>
                            </v-flex>
                            <v-flex xs5>
                                <v-text-field label="Marca" v-model="formVeiculo.marca" name="marca" required></v-text-field>
                                <show-error :form-name="formVeiculo" prop-name="marca"></show-error>
                            </v-flex>
                            <v-flex xs5>
                                <v-text-field label="Modelo" v-model="formVeiculo.modelo" name="modelo" required></v-text-field>
                                <show-error :form-name="formVeiculo" prop-name="modelo"></show-error>
                            </v-flex>
                            <v-flex xs5>
                                <v-text-field label="Cor" v-model="formVeiculo.cor" name="cor" required></v-text-field>
                                <show-error :form-name="formVeiculo" prop-name="cor"></show-error>
                            </v-flex>
                            <v-flex xs5>
                                <v-text-field label="Ano" v-model="formVeiculo.ano" name="ano" mask=" ####" required></v-text-field>
                                <show-error :form-name="formVeiculo" prop-name="ano"></show-error>
                            </v-flex>
                            <v-flex xs5>
                                <v-text-field label="Placa" v-model="formVeiculo.placa" name="placa"  required></v-text-field>
                                <show-error :form-name="formVeiculo" prop-name="placa"></show-error>
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
                Veículos
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
                    :items="veiculo"
                    :search="search"
                    rows-per-page-text="por página"
                    no-results-text="Nenhum registro encontrado"
                    :rows-per-page-items="rowsPerPageItems"
            >
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.tipo_veiculo.nome}}</td>
                    <td class="text-xs-left">{{ props.item.modelo }}</td>
                    <td class="text-xs-left">{{ props.item.cliente.nome }}</td>

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
            tipoVeiculo:[],
            veiculo:[],
            cliente:[],
            headers: [
                {text: 'Tipo de Veiculo', value: 'id_tipo_veiculo'},
                {text: 'Modelo', value: 'modelo'},
                {text: 'Cliente', value: 'id_cliente'},
                {text: 'Ações', value: '', align: 'center'},
            ],
            formVeiculo: new Form({
                id: '',
                marca: '',
                modelo: '',
                cor:'',
                ano: '',
                placa:'',
                id_tipo_veiculo: '',
                id_cliente:'',
            })
        }),
        methods: {
            getVeiculo() {
                loading.show();
                axios
                    .get('/api/veiculo')
                    .then((res) => {
                        this.veiculo = res.data;
                    })
                    .finally(() => {
                        loading.hide()
                    })
            },
            getTipoVeiculo() {
                axios
                    .get('/api/tipo-veiculo')
                    .then((res) => {
                        this.tipoVeiculo = res.data;
                    })
            },
            getCliente() {
                axios
                    .get('/api/cliente')
                    .then((res) => {
                        this.cliente = res.data;
                    })
            },
            novo() {
                this.resetForm()
                this.dialog = true
            },
            editar(id) {
                axios
                    .get('/api/veiculo/'+id)
                    .then((res) => {
                        this.formVeiculo = res.data
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
                            .delete('/api/veiculo/' + id)
                            .then((response) => {
                                if (response.data.status == 'success') {
                                    this.$swal.fire(
                                        'Excluído!',
                                        '',
                                        'success'
                                    )
                                    this.getVeiculo();
                                } else {
                                    this.$swal.fire(
                                        'Veiculo não foi excluído',
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
                if(this.formVeiculo.id) {
                    axios.put('/api/veiculo/'+this.formVeiculo.id, this.formVeiculo)
                        .then((response) => {
                            this.dialog = false
                            loading.hide();
                            this.$toasted.success(response.data.msg)
                            this.getTipoVeiculo();
                        })
                        .catch((error) => {
                            loading.hide();
                            this.$toasted.error(error.msg)
                        })
                } else {
                    this.formVeiculo.post('/api/veiculo')
                        .then((response) => {
                            this.dialog = false
                            loading.hide();
                            this.$toasted.success(response.msg)
                            this.getVeiculo();
                        })
                        .catch((error) => {
                            loading.hide();
                            this.$toasted.error(error.msg)
                        })
                }
            },
            resetForm() {
                this.formVeiculo = new Form({
                    id: '',
                    marca: '',
                    modelo: '',
                    cor:'',
                    ano: '',
                    placa:'',
                    id_tipo_veiculo: '',
                    id_cliente:'',
                })
            }
        },
        mounted() {
            this.getVeiculo()
            this.getCliente()
            this.getTipoVeiculo()
        },



    }
</script>
