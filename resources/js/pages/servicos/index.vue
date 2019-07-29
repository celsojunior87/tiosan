<template>
    <div>
        <v-dialog v-model="dialog" persistent max-width="1000px">
            <v-card>
                <v-card-title>
                    <span class="headline">Serviços</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs3>
                                <v-text-field label="Placa" v-on:change="buscarPorPlaca" v-model="formServico.placa" name="tipo_servico" required ></v-text-field>
                                <show-error :form-name="formServico" prop-name="placa"></show-error>
                            </v-flex>
                            <v-flex xs3>
                                <v-text-field label="Cliente" v-model="formServico.nome" name="cliente" required ></v-text-field>
                                <show-error :form-name="formServico" prop-name="cliente"></show-error>
                            </v-flex>
                            <v-flex xs3>
                                <v-text-field label="Modelo" v-model="formServico.modelo" name="modelo" required ></v-text-field>
                                <show-error :form-name="formServico" prop-name="modelo"></show-error>
                            </v-flex>
                        </v-layout>
                        <v-layout align-center>
                        </v-layout>
                        <!--<v-file-input-->
                                <!--:rules="rules"-->
                                <!--accept="image/png, image/jpeg, image/bmp"-->
                                <!--placeholder="Pick an avatar"-->
                                <!--prepend-icon="mdi-camera"-->
                                <!--label="Avatar"-->
                        <!--&gt;</v-file-input>-->
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
                 Serviços
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
                    :items="tipoServico"
                    :search="search"
                    rows-per-page-text="por página"
                    no-results-text="Nenhum registro encontrado"
                    :rows-per-page-items="rowsPerPageItems"
            >
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.tipo_servico }}</td>
                    <td class="text-xs-left">{{ props.item.cliente }}</td>
                    <td class="text-xs-left">{{ props.item.veiculo }}</td>
                    <td class="text-xs-left">{{ props.item.veiculo }}</td>

                    <td class="text-xs-center">
                        <v-btn small color="blue" @click="editar(props.item.id)">
                            <v-icon dark left>edit</v-icon>
                            Editar
                        </v-btn>
                        <v-btn small color="error" @click="remover(props.item.id)">
                            <v-icon dark left>clear</v-icon>
                            Excluir
                        </v-btn>
                        <v-btn small color="green" @click="(props.item.id)">
                            <v-icon dark left>send</v-icon>
                            Enviar para o cliente
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
            rules: [
                value => (value[0] || {}).size < 2000000 || 'Avatar size should be less than 2 MB!',
            ],
            includeFiles: true,
            enabled: false,
            masked: true,
            rowsPerPageItems: [10,25,{"text":"","value":10}],
            dialog: false,
            search: '',
            servico:[],
            tipoServico: [],
            cliente:[],
            headers: [
                {text: 'Tipo de Serviço', value: 'tipo_servico'},
                {text: 'Veiculo', value: 'tipo_servico'},
                {text: 'Cliente', value: 'Cliente'},
                {text: 'Data do Serviço', value: 'Cliente'},
                {text: 'Ações', value: '', align: 'center'},
            ],
            formServico: new Form({
                id: '',
                placa: '',
                nome: '',
                modelo:'',
            })
        }),
        methods: {
            buscarPorPlaca(){

                loading.show();
                axios
                    .get('/api/veiculo/buscar-cliente-por-placa/'+ this.formServico.placa)
                    .then((res) => {
                        this.formServico.modelo = res.data.modelo
                        this.formServico.nome = res.data.cliente.nome
                    })
                    .finally(() => {
                        loading.hide()
                    })

            },

            getTipoServico() {
                loading.show();
                axios
                    .get('/api/tipo-servico')
                    .then((res) => {
                        this.tipoServico = res.data;
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
                    .get('/api/tipo-servico/'+id)
                    .then((res) => {
                        this.formServico = res.data
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
                            .delete('/api/tipo-servico/' + id)
                            .then((response) => {
                                if (response.data.status == 'success') {
                                    this.$swal.fire(
                                        'Excluído!',
                                        '',
                                        'success'
                                    )
                                    this.getTipoServico();
                                } else {
                                    this.$swal.fire(
                                        'Tipo de Serviço não foi excluído',
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
                if(this.formServico.id) {
                    axios.put('/api/tipo-servico/'+this.formServico.id, this.formServico)
                        .then((response) => {
                            this.dialog = false
                            loading.hide();
                            this.$toasted.success(response.data.msg)
                            this.getTipoServico();
                        })
                        .catch((error) => {
                            loading.hide();
                            this.$toasted.error(error.msg)
                        })
                } else {
                    this.formServico.post('/api/tipo-servico')
                        .then((response) => {
                            this.dialog = false
                            loading.hide();
                            this.$toasted.success(response.msg)
                            this.getTipoServico();
                        })
                        .catch((error) => {
                            loading.hide();
                            this.$toasted.error(error.msg)
                        })
                }
            },
            resetForm() {
                this.formServico = new Form({
                    id: '',
                    placa: '',
                    nome: '',
                    modelo:'',
                })
            }
        },
        mounted() {
            this.getTipoServico()
        },



    }
</script>
