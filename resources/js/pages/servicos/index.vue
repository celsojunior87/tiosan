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
                            <v-flex xs4>
                                <v-text-field label="Placa" v-model="formServico.placa"
                                              v-on:change="buscarPorPlaca" name="placa"   :disabled="isDisabled"   required ></v-text-field>
                                <show-error :form-name="formServico" prop-name="placa"></show-error>
                            </v-flex>
                            <v-flex xs8>
                                <v-text-field label="Cliente" v-model="formServico.nome"
                                              :disabled="isDisabled"     required></v-text-field>
                                <show-error :form-name="formServico" ></show-error>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="Modelo" v-model="formServico.modelo"
                                              :disabled="isDisabled"    required></v-text-field>
                            </v-flex>
                            <v-flex xs8>
                                <v-select
                                        v-if="tipoServico"
                                        v-bind:items="tipoServico"
                                        label="Tipo de Serviço"
                                        item-text="tipo_servico"
                                        item-value="id"
                                        v-model="formServico.id_tipo_servico"
                                        name="id_tipo_servico"
                                ></v-select>
                                <show-error :form-name="formServico" prop-name="id_tipo_servico"></show-error>
                            </v-flex>
                            <v-flex xs4>
                                <v-dialog
                                        ref="dialog"
                                        v-model="dialogDate"
                                        lazy
                                        full-width
                                        width="290px"
                                >
                                    <template v-slot:activator="{ on }">
                                        <v-text-field
                                                v-model="computedDateFormatted"
                                                label="Data do Serviço"
                                                prepend-icon="event"
                                                readonly
                                                v-on="on"
                                                name="data_servico"
                                        ></v-text-field>
                                    </template>
                                    <v-date-picker
                                            v-model="formServico.data_servico"
                                            scrollable
                                            locale="ptbr"
                                            :max="new Date().toISOString().substr(0, 10)"
                                    >
                                        <v-spacer></v-spacer>
                                        <v-btn flat color="primary" @click="dialogDate = false">Cancel</v-btn>
                                        <v-btn flat color="primary" @click="dialogDate = false">OK</v-btn>
                                    </v-date-picker>
                                </v-dialog>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="Hora da Entrada" v-model="formServico.hora_entrada"
                                             return-masked-value  mask=" ##:##"  required></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-text-field label="Hora de Saida" v-model="formServico.hora_saida"
                                              return-masked-value mask=" ##:##"   required></v-text-field>
                            </v-flex>
                            <v-flex xs4>
                                <v-select
                                        v-if="tipoPagamento"
                                        v-bind:items="tipoPagamento"
                                        label="Tipo de Pagamento"
                                        item-text="text"
                                        item-value="value"
                                        v-model="formServico.tipo_pagamento"
                                        name="tipo_pagamento"
                                ></v-select>
                                <show-error :form-name="formServico" prop-name="tipo_pagamento"></show-error>
                            </v-flex>
                            <v-flex xs4>
                                <v-select
                                        v-if="categoriaServico"
                                        v-bind:items="categoriaServico"
                                        label="Tipo de Categoria"
                                        item-text="text"
                                        item-value="value"
                                        v-model="formServico.categoria"
                                        name="categoria"
                                ></v-select>
                                <show-error :form-name="formServico" prop-name="categoria"></show-error>
                            </v-flex>
                            <v-flex xs4>
                                <v-currency-field label="Preço" v-bind="currency_config"
                                                  v-model="formServico.preco"></v-currency-field>
                                <show-error :form-name="formServico" prop-name="preco"></show-error>
                            </v-flex>
                            <v-flex xs4>
                                <v-currency-field label="Preço Adicional" v-bind="currency_config" v-if="enabled"
                                                  v-model="formServico.preco_adc"></v-currency-field>
                                <show-error :form-name="formServico" prop-name="preco_adc"></show-error>
                            </v-flex>
                        </v-layout >
                        <v-layout>
                            <v-layout align-center>
                                <v-checkbox
                                        v-model="enabled"
                                        hide-details
                                        class="shrink mr-2 mt-0"
                                ></v-checkbox>
                                <v-text-field
                                        v-model="formServico.obs_adicionais"
                                        :disabled="!enabled"
                                        label="Possui Serviço Adicionais?"
                                ></v-text-field>
                            </v-layout>
                        </v-layout>
                        <v-layout>
                            <v-layout align-center>
                                <v-checkbox
                                        v-model="enabledAvaria"
                                        hide-details
                                        class="shrink mr-2 mt-0"
                                ></v-checkbox>
                                <v-text-field
                                        v-model="formServico.obs_avarias"
                                        :disabled="!enabledAvaria"
                                        label="O Veiculo Possui Avarias?"
                                ></v-text-field>
                            </v-layout>
                        </v-layout>
                        <v-layout align-center>
                            <v-flex xs6>
                                <v-text-field v-model="formServico.image" v-if="enabledAvaria" type="file" label="Fotos" multiple>

                                </v-text-field>
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
                    :items="servico"
                    :search="search"
                    rows-per-page-text="por página"
                    no-results-text="Nenhum registro encontrado"
                    :rows-per-page-items="rowsPerPageItems"
            >
                <template v-slot:items="props">
                    <td class="text-xs-left">{{ props.item.data_servico | formatDate}}</td>
                    <td class="text-xs-left">{{ props.item.hora_entrada}}</td>
                    <td class="text-xs-left">{{ props.item.cliente.hora_saida }}</td>
                    <td class="text-xs-left">{{ props.item.tipo_servico.tipo_servico }}</td>
                    <td class="text-xs-left">{{ props.item.veiculo.modelo }}</td>
                    <td class="text-xs-left">{{ props.item.veiculo.cor }}</td>

                    <td class="text-xs-center">
                        <v-btn small color="blue" @click="editar(props.item.id)">
                            <v-icon dark left>edit</v-icon>
                            Editar Serviço
                        </v-btn>
                        <v-btn small color="green" @click="enviarEmail(props.item.id)">
                            <v-icon dark left>send</v-icon>
                            Finalizar Serviço
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
    import moment from 'moment'
    import {VMoney} from 'v-money'

    export default {
        components: {Field},
        directives: {mask, moment, VMoney},
        name: "index",
        data: vm => ({
            currency_config: {
                decimal: ',',
                thousands: '.',
                prefix: 'R$ ',
                suffix: '',
                precision: 2,
                masked: false,
                allowBlank: false,
                min: Number.MIN_SAFE_INTEGER,
                max: Number.MAX_SAFE_INTEGER
            },
            masked: true,
            rowsPerPageItems: [10,25,{"text":"","value":10}],
            dialog: false,
            dialogDate: false,
            enabled: false,
            isDisabled:true,
            enabledAvaria:false,
            search: '',
            cliente: [],
            tipoPagamento:[
                {text: 'Dinheiro', value: 'D'},
                {text: 'Cartão de Debito', value: 'CD'},
                {text: 'Cartão de Credito', value: 'CC'},
            ],
            categoriaServico:[
                {text: 'Particular', value: 'P'},
                {text: 'Uber', value: 'U'},
                {text: 'Empresa', value: 'E'},
            ],
            servico: [],
            tipoServico:[],
            veiculo:[],
            date: new Date().toISOString().substr(0, 10),
            dateFormatted: moment(moment).format('DD/MM/YYYY'),

            headers: [
                {text: 'Data da Lavagem', value: 'data_servico'},
                {text: 'Hora da Entrada', value: 'hora_entrada'},
                {text: 'Hora da Saída', value: 'hora_saida'},
                {text: 'Tipo de Serviço', value: 'id_tipo_servico'},
                {text: 'Cor', value: 'cor'},
                {text: 'Veiculo', value: 'modelo'},
                {text: 'Ações', value: '', align: 'center'},
            ],
            formServico: new Form({
                id: '',
                placa: '',
                nome: '',
                modelo:'',
                id_cliente:'',
                id_veiculo:'',
                id_tipo_servico:'',
                hora_entrada:'',
                data_servico:'',
                data_saida:'',
                preco_adc:'',
                tipo_pagamento:'',
                obs_adicionais:'',
                obs_avarias:'',
                categoria:'',
                preco:'',
                image:'',
                cor:'',
            })
        }),
        methods: {

            enviarEmail(){


            },


            buscarPorPlaca(){
                loading.show();
                axios
                    .get('/api/veiculo/buscar-cliente-por-placa/'+ this.formServico.placa)
                    .then((res) => {
                        this.formServico.modelo = res.data.modelo
                        this.formServico.nome = res.data.cliente.nome
                        this.formServico.id_cliente = res.data.id_cliente
                        this.formServico.id_veiculo = res.data.id

                    })
                    //Pega o erro do backend
                    .catch((error) => {
                        const _this = this
                        error.response.data.error.msg.map(function (value, key) {
                            _this.$toasted.info(value)
                        })
                    })

                    .finally(() => {
                        loading.hide()
                    })
            },
            getServico() {
                loading.show();
                axios
                    .get('/api/servico')
                    .then((res) => {
                        this.servico = res.data;
                    })
                    .finally(() => {
                        loading.hide()
                    })
            },
            getTipoServico() {
                axios
                    .get('/api/tipo-servico')
                    .then((res) => {
                        this.tipoServico = res.data;
                    })
            },
            getCliente() {
                axios
                    .get('/api/cliente')
                    .then((res) => {
                        this.cliente = res.data;
                    })
            },
            getVeiculo() {
                axios
                    .get('/api/veiculo')
                    .then((res) => {
                        this.veiculo = res.data;
                    })
            },

            novo() {
                this.resetForm()
                this.dialog = true
            },
            editar(id) {
                axios
                    .get('/api/servico/'+id)
                    .then((res) => {
                        this.formServico = res.data
                        this.formServico.placa = res.data.veiculo.placa
                        this.formServico.modelo = res.data.veiculo.modelo
                        this.formServico.nome = res.data.cliente.nome
                        this.isDisabled = true
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
                            .delete('/api/servico/' + id)
                            .then((response) => {
                                if (response.data.status == 'success') {
                                    this.$swal.fire(
                                        'Excluído!',
                                        '',
                                        'success'
                                    )
                                    this.getServico();
                                } else {
                                    this.$swal.fire(
                                        'Serviço não foi excluído',
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
                    axios.put('/api/servico/'+this.formServico.id, this.formServico)
                        .then((response) => {
                            this.dialog = false
                            loading.hide();
                            this.$toasted.success(response.data.msg)
                            this.getServico();
                        })
                        .catch((error) => {
                            loading.hide();
                            this.$toasted.error(error.msg)
                        })
                } else {
                    this.formServico.post('/api/servico')
                        .then((response) => {
                            this.dialog = false
                            loading.hide();
                            this.$toasted.success(response.msg)
                            this.getServico();
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
                    id_cliente:'',
                    id_veiculo:'',
                    id_tipo_servico:'',
                    categoria:'',
                    data_servico: new Date().toISOString().substr(0, 10),
                    hora_entrada:'',
                    hora_saida:'',
                    tipo_pagamento:'',
                    preco_adc:'',
                    obs_adicionais:'',
                    obs_avarias:'',
                    preco:'',
                    cor:'',
                })
            },
            formatDate (date) {

                if (!date) return null

                const [year, month, day] = date.split('-')

                return `${day}/${month}/${year}`
            },
            parseDate (date) {
                if (!date) return null

                const [month, day, year] = date.split('/')
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            },
        },
        mounted() {
            this.getCliente()
            this.getServico()
            this.getTipoServico()
            this.getVeiculo()
        },
        computed: {
            computedDateFormatted () {
                return this.formatDate(this.formServico.data_servico)
            },
        },
        watch: {
            formServico: {
                handler: function() {
                    this.dateFormatted = this.formatDate(this.formServico.data_servico)
                },
                deep: true
            }
        },
    }
</script>
