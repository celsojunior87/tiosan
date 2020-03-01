<template>
  <div class="text-xs-center">
    <v-btn round color="success" @click="gerarPdf()" dark>Gerar Relatório</v-btn>
  </div>
</template>

<script>
import Field from "../../components/Field";
import { mask } from "vue-the-mask";

export default {
  components: { Field },
  directives: { mask },
  data: () => ({
    masked: true,
    rowsPerPageItems: [10, 25, { text: "", value: 10 }],
    dialog: false,
    search: "",

  }),
  methods: {
    gerarPdf() {
      axios
        .get("/api/relatorio")
        .then(res => {
        })
        .catch(() => {});

    }
  }
};
</script>

