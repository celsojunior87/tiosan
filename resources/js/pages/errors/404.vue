<template>
  <card class="text-center">
    <h3 class="mb-4">Página não encontrada</h3>

    <div class="links">
      <router-link :to="{ name: 'home' }">
        clique para ir para a página inicial
      </router-link>
    </div>
  </card>
</template>

<script>
export default {
  middleware: 'auth',
  name: 'NotFound'
}
</script>
