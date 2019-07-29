<template>
    <div id="pageDashboard">
        <v-container grid-list-xl fluid>
            <v-layout row wrap>
                <!-- mini statistic start -->
                <v-flex lg3 sm6 xs12>
                    <mini-statistic
                            icon="contacts"
                            :title="totalCliente"
                            sub-title="Clientes"
                            color="red"
                    >
                    </mini-statistic>
                </v-flex>
                <v-flex lg3 sm6 xs12>
                    <mini-statistic
                            icon="attach_money"
                            :title="totalVeiculos"
                            sub-title="Compras"
                            color="green"
                    >
                    </mini-statistic>
                </v-flex>
                <v-flex lg3 sm6 xs12>
                    <mini-statistic
                            icon="fastfood"
                            :title="totalProdutos"
                            sub-title="Produtos"
                            color="light-blue"
                    >
                    </mini-statistic>
                </v-flex>
                <v-flex lg3 sm6 xs12>
                    <mini-statistic
                            icon="business"
                            :title="totalEstabelecimentos"
                            sub-title="Estabelecimentos"
                            color="purple"
                    >
                    </mini-statistic>
                </v-flex>
                <!-- mini statistic  end -->

            </v-layout>
        </v-container>
    </div>
</template>

<script>
    import MiniStatistic from '~/widgets/statistic/MiniStatistic';
    import Material from 'vuetify/es5/util/colors';
    import CircleStatistic from '~/widgets/statistic/CircleStatistic';

    export default {
        components: {
            MiniStatistic,
            CircleStatistic,
        },
        data: () => ({
            chartOptions: {
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },

                xaxis: {
                    categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun'],
                },
                yaxis: {
                    title: {
                        text: '$ (thousands)'
                    }
                },
                fill: {
                    opacity: 1

                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return "$ " + val + " thousands"
                        }
                    }
                }
            },
            options: {
                chart: {
                    id: 'vuechart-example'
                },
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998],
                }
            },
            series2: [{
                name: 'series-1',
                data: [30, 40, 45, 50, 49, 60, 70, 91]
            }],
            series: [44, 55, 41, 17, 15],
            totalFornecedores: '0',
            totalVeiculos: '0',
            totalProdutos: '0',
            totalEstabelecimentos: '0',
            totalCliente:'0',
            color: Material,
            trending: [
                {
                    subheading: 'Email',
                    headline: '15+',
                    caption: 'email opens',
                    percent: 15,
                    icon: {
                        label: 'email',
                        color: 'info'
                    },
                    linear: {
                        value: 15,
                        color: 'info'
                    }
                },
                {
                    subheading: 'Tasks',
                    headline: '90%',
                    caption: 'tasks completed.',
                    percent: 90,
                    icon: {
                        label: 'list',
                        color: 'primary'
                    },
                    linear: {
                        value: 90,
                        color: 'success'
                    }
                },
                {
                    subheading: 'Issues',
                    headline: '100%',
                    caption: 'issues fixed.',
                    percent: 100,
                    icon: {
                        label: 'bug_report',
                        color: 'primary'
                    },
                    linear: {
                        value: 100,
                        color: 'error'
                    }
                },
            ],
        }),
        methods: {
            getTotalFornecedores() {
                axios
                    .get('/api/fornecedor')
                    .then((res) => {
                        this.totalFornecedores = res.data.length.toString();
                    })
            },
            getTotalCompras() {
                axios
                    .get('/api/compra')
                    .then((res) => {
                        this.totalCompras = res.data.length.toString();
                    })
            },
            getTotalProdutos() {
                axios
                    .get('/api/produto')
                    .then((res) => {
                        this.totalProdutos = res.data.length.toString();
                    })
            },
            getTotalCliente() {
                axios
                    .get('/api/cliente')
                    .then((res) => {
                        this.totalCliente = res.data.length.toString();
                    })
            },
            getTotalEstabelecimentos() {
                axios
                    .get('/api/estabelecimento')
                    .then((res) => {
                        this.totalEstabelecimentos = res.data.length.toString();
                    })
            },
        },
        mounted() {
            this.getTotalFornecedores()
            this.getTotalCompras()
            this.getTotalProdutos()
            this.getTotalEstabelecimentos()
            this.getTotalCliente()
        },
    };
</script>
