<template>
    <div>
        <v-dialog v-model="dialog" persistent max-width="1000px">
            <v-card>
                <v-card-title>
                    <span class="headline">Tipo Veiculos</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            <v-flex xs12>
                                <v-text-field label="Nome" v-model="formTipoVeiculo.nome" name="nome" required ></v-text-field>
                                <show-error :form-name="formTipoVeiculo" prop-name="nome"></show-error>
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
                Tipo Veiculos
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
                    :items="tipoVeiculo"
                    :search="search"
                    rows-per-page-text="por página"
                    no-results-text="Nenhum registro encontrado"
                    :rows-per-page-items="rowsPerPageItems"
            >
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.nome }}</td>

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
            tipoVeiculo: [],
            headers: [
                {text: 'Nome', value: 'nome'},
                {text: 'Ações', value: '', align: 'center'},
            ],
            formTipoVeiculo: new Form({
                id: '',
                nome: '',
            })
        }),
        methods: {
            getTipoVeiculo() {
                loading.show();
                axios
                    .get('/api/tipo-veiculo')
                    .then((res) => {
                        this.tipoVeiculo = res.data;
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
                    .get('/api/tipo-veiculo/'+id)
                    .then((res) => {
                        this.formTipoVeiculo = res.data
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
                            .delete('/api/tipo-veiculo/' + id)
                            .then((response) => {
                                if (response.data.status == 'success') {
                                    this.$swal.fire(
                                        'Excluído!',
                                        '',
                                        'success'
                                    )
                                    this.getTipoVeiculo();
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
                if(this.formTipoVeiculo.id) {
                    axios.put('/api/tipo-veiculo/'+this.formTipoVeiculo.id, this.formTipoVeiculo)
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
                    this.formTipoVeiculo.post('/api/tipo-veiculo')
                        .then((response) => {
                            this.dialog = false
                            loading.hide();
                            this.$toasted.success(response.msg)
                            this.getTipoVeiculo();
                        })
                        .catch((error) => {
                            loading.hide();
                            this.$toasted.error(error.msg)
                        })
                }
            },
            resetForm() {
                this.formTipoVeiculo = new Form({
                    id: '',
                    nome: '',
                })
            }
        },
        mounted() {
            this.getTipoVeiculo()
        },



    }
</script>
