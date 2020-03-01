import Cookies from 'js-cookie'

const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)
const AuthProfile = () => import('~/pages/auth/profile').then(m => m.default || m)
const Dashboard = () => import('~/pages/dashboard').then(m => m.default || m)
const Cliente = () => import('~/pages/clientes').then(m => m.default || m)
const TipoVeiculo = () => import('~/pages/tipo-veiculos').then(m => m.default || m)
const Veiculo = () => import('~/pages/veiculos').then(m => m.default || m)
const TipoServico = () => import('~/pages/tipo-servicos').then(m => m.default || m)
const Servico = () => import('~/pages/servicos').then(m => m.default || m)
const Relatorio = () => import('~/pages/relatorio').then(m => m.default || m)
const isAuth = (to, from, next) => {
    if (Cookies.get('token')) {
        next()
        return
    }
    next('/login')
}

export default [
    {
        path: '/',
        name: 'login',
        component: Login
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        beforeEnter: isAuth
    },
    {
        path: '/clientes',
        name: 'cliente',
        component: Cliente,
        beforeEnter: isAuth
    },
    {
        path: '/tipo-veiculo',
        name: 'tipo-veiculo',
        component: TipoVeiculo,
        beforeEnter: isAuth
    },
    {
        path: '/tipo-servico',
        name: 'tipo-servico',
        component: TipoServico,
        beforeEnter: isAuth
    },
    {
        path: '/servico',
        name: 'servico',
        component: Servico,
        beforeEnter: isAuth
    },
    {
        path: '/veiculo',
        name: 'veiculo',
        component: Veiculo,
        beforeEnter: isAuth
    },
    {
        path: '/relatorio',
        name: 'relatorio',
        component: Relatorio,
        beforeEnter: isAuth
    },

    {
        path: '/auth/profile',
        name: 'auth.profile',
        component: AuthProfile,
        beforeEnter: isAuth
    },
  { path: '*', component: NotFound }
]
