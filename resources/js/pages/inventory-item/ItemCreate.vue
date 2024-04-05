<script setup>
import InventoryItemForm from "../../components/inventory-item/InventoryItemForm.vue";
</script>

<template>
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Inventory Item Create</h1>
            <router-link :to="{ name: 'inventoryItem', params: {inventoryId: $route.params.inventoryId}  }" class="btn btn-sm btn-warning"  title="Back"><i class="bi bi-arrow-left"></i> Back</router-link>
        </div>
        <InventoryItemForm operation="create" :inventoryId="$route.params.inventoryId"></InventoryItemForm>
    </div>
</template>

<style scoped>

</style>
