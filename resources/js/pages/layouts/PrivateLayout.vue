<template>
    <Navbar/>
    <div class="container-fluid">
        <div class="row">
            <Sidebar />
            <slot/>
        </div>
    </div>
</template>

<script setup>
    import Navbar from "../Navbar.vue";
    import Sidebar from "../Sidebar.vue";
</script>
<style scoped>

</style>
