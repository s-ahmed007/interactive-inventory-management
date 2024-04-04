<script setup>
import PrivateLayout from "./layouts/PrivateLayout.vue";
import DefaultLayout from "./layouts/DefaultLayout.vue";
import {ref} from 'vue';

const token = ref(localStorage.getItem('token'));
</script>

<template>
    <PrivateLayout v-if="token">
        <router-view/>
    </PrivateLayout>
    <DefaultLayout v-else>
        <router-view/>
    </DefaultLayout>
</template>

<style scoped>

</style>
