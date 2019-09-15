<template>
  <v-container fluid grid-list-md>
    <v-layout child-flex wrap>
      <v-card-text style="height: 100px; position: relative">
        <v-fab-transition>
          <v-btn color="pink" dark fixed bottom right fab @click="abrirForm()">
            <v-icon>add</v-icon>
          </v-btn>
        </v-fab-transition>
      </v-card-text>
      <v-dialog v-model="showForm" width="1500">
        <v-card>
          <v-card-title class="headline red lighten-2" primary-title>
            Passo-a-Passo de serviço
          </v-card-title>

          <v-stepper v-model="e1">
            <v-stepper-header>
              <v-stepper-step :complete="e1 > 1" step="1">Cliente</v-stepper-step>
              <v-divider></v-divider>
              <v-stepper-step :complete="e1 > 2" step="2">Veículo</v-stepper-step>
              <v-divider></v-divider>
              <v-stepper-step step="3">Serviço</v-stepper-step>
            </v-stepper-header>

            <v-stepper-items>
              <v-stepper-content step="1">
                <v-card class="mb-5" height="400px">
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs8>
                        <v-text-field label="Nome" v-model="form.cliente.nome" name="nome" required></v-text-field>
                        <show-error :form-name="form.cliente" prop-name="nome"></show-error>
                      </v-flex>
                      <v-flex xs4>
                        <v-text-field label="Telefone" v-model="form.cliente.telefone" mask=" (##) #####-####" required></v-text-field>
                        <show-error :form-name="form.cliente" prop-name="telefone"></show-error>
                      </v-flex>
                      <v-flex xs4>
                        <v-text-field label="Email" v-model="form.cliente.email" required></v-text-field>
                        <show-error :form-name="form.cliente" prop-name="email"></show-error>
                      </v-flex>
                      <v-flex xs4>
                        <v-text-field label="Cep" v-model="form.cliente.cep" required></v-text-field>
                      </v-flex>
                      <v-flex xs4>
                        <v-text-field label="UF" v-model="form.cliente.uf" required></v-text-field>
                      </v-flex>
                      <v-flex xs4>
                        <v-text-field label="Cidade" v-model="form.cliente.cidade" required></v-text-field>
                      </v-flex>
                      <v-flex xs4>
                        <v-text-field label="Bairro" v-model="form.cliente.bairro" required></v-text-field>
                      </v-flex>
                      <v-flex xs4>
                        <v-text-field label="Complemento" v-model="form.cliente.complemento" required></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>

                <v-btn color="primary" @click="salvarCliente()">
                  Próximo
                </v-btn>
              </v-stepper-content>

              <v-stepper-content step="2">
                <v-card class="mb-5" height="400px">
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs5>
                        <v-select  v-if="tipoVeiculo" v-bind:items="tipoVeiculo" label="Tipo de Veiculo" item-text="nome" item-value="id" v-model="form.veiculo.id_tipo_veiculo" name="id_tipo_veiculo"></v-select>
                        <show-error :form-name="form.veiculo" prop-name="id_tipo_veiculo"></show-error>
                      </v-flex>

                      <v-flex xs5>
                        <v-text-field label="Marca" v-model="form.veiculo.marca" name="marca" required></v-text-field>
                        <show-error :form-name="form.veiculo" prop-name="marca"></show-error>
                      </v-flex>
                      <v-flex xs5>
                        <v-text-field label="Modelo" v-model="form.veiculo.modelo" name="modelo" required></v-text-field>
                        <show-error :form-name="form.veiculo" prop-name="modelo"></show-error>
                      </v-flex>
                      <v-flex xs5>
                        <v-text-field label="Cor" v-model="form.veiculo.cor" name="cor" required></v-text-field>
                        <show-error :form-name="form.veiculo" prop-name="cor"></show-error>
                      </v-flex>
                      <v-flex xs5>
                        <v-text-field label="Ano" v-model="form.veiculo.ano" name="ano" mask=" ####" required></v-text-field>
                        <show-error :form-name="form.veiculo" prop-name="ano"></show-error>
                      </v-flex>
                      <v-flex xs5>
                        <v-text-field label="Placa" v-model="form.veiculo.placa" name="placa" required></v-text-field>
                        <show-error :form-name="form.veiculo" prop-name="placa"></show-error>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>

                <v-btn color="primary" @click="salvarVeiculo()">
                  Próximo
                </v-btn>

              </v-stepper-content>

              <v-stepper-content step="3">
                <v-card class="mb-5" height="400px">
                  <v-container grid-list-md>
                    <v-layout wrap>
                      <v-flex xs4>
                        <v-select v-if="tipoServico" v-bind:items="tipoServico" label="Tipo de Serviço" item-text="tipo_servico" item-value="id" v-model="form.servico.id_tipo_servico" name="id_tipo_servico"></v-select>
                        <show-error :form-name="form.servico" prop-name="id_tipo_servico"></show-error>
                      </v-flex>
                      <v-flex xs4>
                        <v-dialog ref="dialog" v-model="dialogDate" lazy full-width width="290px">
                          <template v-slot:activator="{ on }">
                            <v-text-field v-model="computedDateFormatted" label="Data do Serviço" prepend-icon="event" readonly v-on="on" name="data_servico"></v-text-field>
                          </template>
                          <v-date-picker v-model="form.servico.data_servico" scrollable locale="ptbr" :max="new Date().toISOString().substr(0, 10)">
                            <v-spacer></v-spacer>
                            <v-btn flat color="primary" @click="dialogDate = false">Cancel</v-btn>
                            <v-btn flat color="primary" @click="dialogDate = false">OK</v-btn>
                          </v-date-picker>
                        </v-dialog>
                      </v-flex>
                      <v-flex xs3>
                        <v-text-field label="Hora da Entrada" v-model="form.servico.hora_entrada" return-masked-value mask=" ##:##" required></v-text-field>
                        <show-error :form-name="form.servico" prop-name="hora_entrada"></show-error>
                      </v-flex>
                      <v-flex xs3>
                        <v-text-field label="Hora de Saida" v-model="form.servico.hora_saida" return-masked-value mask=" ##:##" required></v-text-field>
                      </v-flex>
                      <v-flex xs4>
                        <v-select v-if="tipoPagamento" v-bind:items="tipoPagamento" label="Tipo de Pagamento" item-text="text" item-value="value" v-model="form.servico.tipo_pagamento" name="tipo_pagamento"></v-select>
                        <show-error :form-name="form.servico" prop-name="tipo_pagamento"></show-error>
                      </v-flex>
                      <v-flex xs4>
                        <v-select v-if="categoriaServico" v-bind:items="categoriaServico" label="Tipo de Categoria" item-text="text" item-value="value" v-model="form.servico.categoria" name="categoria"></v-select>
                        <show-error :form-name="form.servico" prop-name="categoria"></show-error>
                      </v-flex>
                      <v-flex xs4>
                        <v-select v-if="funcionarioServico" v-bind:items="funcionarioServico" label="Funcionario" item-text="text" item-value="value" v-model="form.servico.funcionario" name="funcionario"></v-select>
                        <show-error :form-name="form.servico" prop-name="funcionario"></show-error>
                      </v-flex>

                      <v-flex xs4>
                         <v-currency-field
                            label="Preço"
                            v-bind="currency_config"
                             v-model="form.servico.preco"
                             ></v-currency-field>
                                <show-error :form-name="form.servico" prop-name="preco"></show-error>
                      </v-flex>
                      <v-flex xs4>
                        <v-currency-field label="Preço Adicional" v-bind="currency_config" v-if="enabled" v-model="form.servico.preco_adc"></v-currency-field>
                        <show-error :form-name="form.servico" prop-name="preco_adc"></show-error>
                      </v-flex>
                    </v-layout>
                    <v-layout>
                      <v-layout align-center>
                        <v-checkbox v-model="enabled" hide-details class="shrink mr-2 mt-0"></v-checkbox>
                        <v-text-field v-model="form.servico.obs_adicionais" :disabled="!enabled" label="Possui Serviço Adicionais?"></v-text-field>
                      </v-layout>
                    </v-layout>
                    <v-layout>
                      <v-layout align-center>
                        <v-checkbox v-model="enabledAvaria" hide-details class="shrink mr-2 mt-0"></v-checkbox>
                        <v-text-field v-model="form.servico.obs_avarias" :disabled="!enabledAvaria" label="O Veiculo Possui Avarias?"></v-text-field>
                      </v-layout>
                    </v-layout>
                    <v-layout align-center>
                      <v-flex xs6>
                        <v-text-field v-model="form.servico.image" v-if="enabledAvaria" type="file" label="Fotos" multiple></v-text-field>
                      </v-flex>
                    </v-layout>
                  </v-container>
                </v-card>

                <v-btn color="primary" @click="salvarServico()">
                  Finalizar
                </v-btn>
              </v-stepper-content>
            </v-stepper-items>
          </v-stepper>
          <v-divider></v-divider>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" flat @click="showForm = false">
              Fechar
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-layout>
  </v-container>
</template>
<script>
import Field from "../../components/Field";
import { mask } from "vue-the-mask";

export default {
  components: { Field },
  directives: { mask },
  name: "index",
  data: () => ({
    currency_config: {
      errors: {},
      decimal: ",",
      thousands: ".",
      prefix: "R$",
      suffix: "",
      precision: 2,
      //toFixed: 2,
      allowBlank: false,
      min: Number.MIN_SAFE_INTEGER,
      max: Number.MAX_SAFE_INTEGER
    },
    showForm: false,
    enabledAvaria: false,
    enabled: false,
    isDisabled: true,
    dialogDate: false,
    tipoVeiculo: [],
    cliente: [],
    veiculo:[],
    idCliente:'',
    tipoServico: [],
    tipoPagamento: [{ text: "Dinheiro", value: "D" }, { text: "Cartão de Debito", value: "CD" }, { text: "Cartão de Credito", value: "CC" }],
    categoriaServico: [{ text: "Particular", value: "P" }, { text: "Uber", value: "U" }, { text: "Empresa", value: "E" }],
    funcionarioServico: [{ text: "Maiko", value: "Maiko" }, { text: "Danilo", value: "Danilo" }, { text: "Kaique", value: "Kaique" }, { text: "Sanley", value: "Sanley" }],
    e1: 0,

    servico : {},

    form: new Form({
      cliente: {
        id:"",
        nome: "",
        telefone: "",
        email: "",
        cep: "",
        uf: "",
        cidade: "",
        bairro: "",
        complemento: ""
      },
      veiculo: {
        marca: "",
        modelo: "",
        cor: "",
        ano: "",
        placa: "",
        id_tipo_veiculo: "",
        id_cliente: ""
      },
      servico: {
        placa: "",
        nome: "",
        modelo: "",
        id_cliente: "",
        id_veiculo: "",
        id_tipo_servico: "",
        categoria: "",
        data_servico: new Date().toISOString().substr(0, 10),
        hora_entrada: "",
        hora_saida: "",
        tipo_pagamento: "",
        preco_adc: "",
        obs_adicionais: "",
        obs_avarias: "",
        preco: "",
        cor: "",
        funcionario: ""
      }
    })
  }),
  methods: {
    abrirForm() {
      this.resetForm();
      this.e1 = 1;
      this.showForm = true;
    },
    finalizar() {
      console.info(this.form);
    },
    buscarPorPlaca() {
      loading.show();
      axios
        .get("/api/veiculo/buscar-cliente-por-placa/" + this.form.servico.placa)
        .then(res => {
          this.form.servico.modelo = res.data.modelo;
          this.form.servico.nome = res.data.cliente.nome;
          this.form.servico.id_cliente = res.data.id_cliente;
          this.form.servico.id_veiculo = res.data.id;
        })
        .catch(error => {
          const _this = this;
          error.response.data.error.msg.map(function(value, key) {
            _this.$toasted.info(value);
          });
        })
        .finally(() => {
          loading.hide();
        });
    },

    salvarCliente() {
      if ((this.form.cliente.nome == "") & (this.form.cliente.modelo == "") & (this.form.cliente.telefone == "")) {
        this.$toasted.error("Você precisa preencher");
      } else {
        axios
          .post("/api/cliente", this.form.cliente)
          .then(response => {
            this.$toasted.success(response.msg);
            this.idCliente = response.data.id;
            this.e1 = 2;
          })
          .catch(error => {
            this.$toasted.error(error.response.data.errors.telefone);
            console.log(error);
          });
      }
    },
    salvarVeiculo() {
      this.form.veiculo.id_cliente = this.idCliente;
       if ((this.form.veiculo.id_cliente == "") &
      (this.form.veiculo.marca == "") &
      (this.form.veiculo.modelo == "") &
      (this.form.veiculo.placa == "") &
      (this.form.veiculo.cor == "") &
      (this.form.veiculo.ano == "")) {
        this.$toasted.error("Você precisa preencher os dados Obrigatório");
      } else {
        axios
          .post("/api/veiculo", this.form.veiculo)
          .then(response => {
            this.$toasted.success(response.msg);
            this.form.veiculo.id_cliente = this.idCliente;
            this.servico = response.data;
            console.log(this.servico);

            this.e1 = 3;
          })
          .catch(error => {
            this.$toasted.error(error.response.data.errors.placa);
            console.log(error);
          });
      }
    },
    salvarServico() {
        this.form.servico.placa = this.servico.placa;
        this.form.servico.modelo = this.servico.modelo;
        this.form.servico.id_cliente = this.servico.id_cliente;
        this.form.servico.id_veiculo = this.servico.id;

     if ((this.form.servico.placa == "") &
      (this.form.servico.id_cliente == "") &
      (this.form.servico.id_veiculo == "") &
      (this.form.servico.id_tipo_servico  == "") &
      (this.form.servico.data_servico  == "")&
      (this.form.servico.hora_entrada  == "")&
      (this.form.servico.tipo_pagamento  == "")&
      (this.form.servico.categoriaServico  == "") &
     (this.form.servico.funcionarioServico  == "")&
     (this.form.servico.preco  == "")){
        this.$toasted.error("Você precisa preencher");
      } else {
        axios
          .post("/api/servico", this.form.servico)
          .then(response => {
            this.$toasted.success(response.msg);
            this.e1 = 3;
            this.showForm = false;
          })
          .catch(error => {
            this.$toasted.error(error.response.data.errors.telefone);
            console.log(error);
          });
      }
    },
    getVeiculo() {
     axios
        .get("/api/veiculo")
        .then(res => {
          this.veiculo = res.data;
        })
        .finally(() => {

        });
    },
    getTipoVeiculo() {
      loading.show();
      axios
        .get("/api/tipo-veiculo")
        .then(res => {
          this.tipoVeiculo = res.data;
        })
        .finally(() => {

        });
    },
          getTipoServico() {
                     axios
                    .get('/api/tipo-servico')
                    .then((res) => {
                        this.tipoServico = res.data;
                    })
                    .finally(() => {
                        loading.hide()
                    })
            },
        getServico() {
                axios
              .get("/api/servico")
              .then(res => {
                this.servico = res.data;
                this.servico.preco = (parseFloat(res.data.preco));

              })
              .finally(() => {
              })
         },
    formatDate(date) {
      if (!date) return null;

      const [year, month, day] = date.split("-");

      return `${day}/${month}/${year}`;
    },
    parseDate(date) {
      if (!date) return null;

      const [month, day, year] = date.split("/");
      return `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`;
    },
    resetForm() {
      this.form = new Form({
        cliente: {
          nome: "",
          telefone: "",
          email: "",
          cep: "",
          uf: "",
          cidade: "",
          bairro: "",
          complemento: ""
        },
        veiculo: {
          marca: "",
          modelo: "",
          cor: "",
          ano: "",
          placa: "",
          id_tipo_veiculo: "",
          id_cliente: ""
        },
        servico: {
          placa: "",
          nome: "",
          modelo: "",
          id_cliente: "",
          id_veiculo: "",
          id_tipo_servico: "",
          categoria: "",
          data_servico: new Date().toISOString().substr(0, 10),
          hora_entrada: "",
          hora_saida: "",
          tipo_pagamento: "",
          preco_adc: "",
          obs_adicionais: "",
          obs_avarias: "",
          preco: "",
          cor: "",
          funcionario: ""
        }
      });
    }
  },
  mounted() {
    this.getTipoVeiculo();
    this.getTipoServico();
    this.getVeiculo();
  },
  computed: {
    computedDateFormatted() {
      return this.formatDate(this.form.servico.data_servico);

    }
  }
};
</script>

