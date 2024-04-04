<script setup>
import {onMounted} from 'vue';
import PrivateLayout from "./layouts/PrivateLayout.vue";
import DefaultLayout from "./layouts/DefaultLayout.vue";
import {useAuthStore} from '../stores/authStore';

const authStore = useAuthStore()

  // lifecycle hook
  onMounted(()=>{
    // set auth info on page refresh from localstorage
    if (localStorage?.getItem('user')){
      authStore.setAuthInfo(JSON.parse(localStorage?.getItem('user')), localStorage?.getItem('token'))
    }
  })
</script>

<template>
    <PrivateLayout v-if="authStore.token">
        <router-view/>
    </PrivateLayout>
    <DefaultLayout v-else>
        <router-view/>
    </DefaultLayout>
</template>

<style scoped>

</style>
