import axios from 'axios'
import store from '~/store'
import router from '~/router'
import swal from 'sweetalert2'

// Request interceptor
axios.interceptors.request.use(request => {
  const token = store.getters['getToken']
  if (token) {
    request.headers.common['Authorization'] = `Bearer ${token}`
  }

  const locale = store.getters['lang/locale']
  if (locale) {
    request.headers.common['Accept-Language'] = locale
  }

  // request.headers['X-Socket-Id'] = Echo.socketId()

  return request
})

// Response interceptor
axios.interceptors.response.use(response => response, error => {
  const { status } = error.response

  if (status >= 500) {
    swal({
      type: 'error',
      title: 'Error',
      text: 'Erro no servidor',
      reverseButtons: true,
      confirmButtonText: 'Ok',
      cancelButtonText: 'Cancelar'
    })
  }

  if (status === 401) {
    swal({
      type: 'warning',
      title: 'Sessão encerrada',
      text: 'Token expirado',
      reverseButtons: true,
      confirmButtonText: 'Ok',
      timer: 5000
    }).then(() => {
      store.dispatch('logout')
      router.push({ name: 'login' })
    })
  }

  return Promise.reject(error)
})
