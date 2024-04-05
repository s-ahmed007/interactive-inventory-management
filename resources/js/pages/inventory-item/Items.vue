<script setup>
import {ref, onMounted} from 'vue';
import Pagination from "../../components/Pagination.vue";
import {toast} from "vue3-toastify";
import {useAuthStore} from '../../stores/authStore';
import { useRoute } from 'vue-router';

const route = useRoute();
const authStore = useAuthStore()
const isLoading = ref(false)
const inventory = ref('')
const inventoryItems = ref('')
const pagination = ref()

  // lifecycle hook
  onMounted(()=>{
    getInventoryItems()
  })

//   methods
function getInventoryItems(page = 1) {
  isLoading.value = true
  axios.get(`/inventories/${route.params.inventoryId}/inventoryItems`, {headers: authStore.reqHeader, params: {page}})
    .then(res => {
      inventory.value = res?.data?.data
      let {items} = res?.data?.data
      let {data, ...rest} = items
      inventoryItems.value = data
      pagination.value = rest
    }).finally(() => isLoading.value = false)
  }
  function deleteInventoryItem(id) {
    if (confirm('Are you sure to delete?')) {
      isLoading.value = true
      axios.delete(`/inventories/${inventory.value.inventory.id}/inventoryItems/${id}`, {headers: authStore.reqHeader})
        .then(res => {
          toast.success(res?.data?.message, {theme: 'colored'})
          getInventoryItems()
        }).finally(() => isLoading.value = false)
    }
  }
</script>

<template>
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Inventory Items</h1>
            <div>
              <router-link :to="{ name: 'inventoryItemCreate', params: {inventoryId: $route.params.inventoryId} }"
                            class="btn btn-sm btn-primary me-2" title="Create"><i
                  class="bi bi-plus-lg"></i> Create
              </router-link>
            <router-link to="/inventory" class="btn btn-sm btn-warning"><i class="bi bi-arrow-left"></i> Back</router-link>
            </div>

        </div>
        <div class="table-responsive small" v-if="!isLoading">
            <table class="table table-striped table-sm text-center">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Description</th>
                    <th scope="col" style="width: 15%">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(inventoryItem, i) in inventoryItems" :key="i">
                    <td>{{ inventoryItem?.id }}</td>
                    <td>{{ inventoryItem?.name }}</td>
                    <td><img :src="inventoryItem?.image" alt="Inventory item img" class="img-fluid w-25" ></td>
                    <td>{{ inventoryItem?.quantity }}</td>
                    <td>{{ inventoryItem?.description }}</td>
                    <td>
                        <router-link
                            :to="{ name: 'inventoryItemUpdate', params: { inventoryId: $route.params.inventoryId, id: inventoryItem?.id} }"
                            class="btn btn-sm btn-info me-2" title="Edit"><i class="bi bi-pencil-square"></i>
                            Edit
                        </router-link>
                        <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                @click="deleteInventoryItem(inventoryItem?.id)">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
            <Pagination v-if="pagination" :currentPageIndex="pagination.current_page" :totalRecords="pagination.total" :recordsPerPage="pagination.per_page" @pageChanged="getInventoryItems"></Pagination>
        </div>
      </div>
</template>

<style scoped>

</style>
