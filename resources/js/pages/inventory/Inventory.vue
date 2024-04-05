<script setup>
import {ref, onMounted} from 'vue';
import Pagination from "../../components/Pagination.vue";
import {toast} from "vue3-toastify";
import {useAuthStore} from '../../stores/authStore';

const authStore = useAuthStore()
const inventories = ref('')
const pagination = ref()

  // lifecycle hook
  onMounted(()=>{
    getAllInventories()
  })

// methods
  function getAllInventories(page = 1) {
    axios
    .get('/inventories', {headers: authStore.reqHeader, params: {page}})
    .then(res => {
      let {data, ...rest} = res.data.data
      inventories.value = data
      pagination.value = rest
    }).catch(errors => {
      // handle error
    })
  }
  function deleteInventory(id) {
    if (confirm('Are you sure to delete?')) {
      axios.delete(`/inventories/${id}`, {headers: authStore.reqHeader})
        .then(res => {
          toast.success(res?.data?.message, {theme: 'colored'})
          this.getAllInventories()
        }).catch(errors => {
          //
      })
    }
  }
</script>

<template>
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Inventory</h1>
            <router-link to="/inventory/create" class="btn btn-sm btn-primary" title="Create"><i
                class="bi bi-plus-lg"></i> Create
            </router-link>
        </div>
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr v-for="(inventory, i) in inventories" :key="i">
                        <td>{{inventory.id}}</td>
                        <td>{{inventory.name}}</td>
                        <td>{{inventory.description}}</td>
                        <td>
                          <router-link :to="{ name: 'UpdateInventory', params: {id: inventory?.id} }"
                                      class="btn btn-sm btn-info me-2" title="Edit"><i class="bi bi-pencil-square"></i>
                              Edit
                          </router-link>
                          <button type="button" class="btn btn-sm btn-danger" title="Delete"
                                  @click="deleteInventory(inventory?.id)">
                              <i class="bi bi-trash"></i> Delete
                          </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination v-if="pagination" :currentPageIndex="pagination.current_page" :totalRecords="pagination.total"
                        :recordsPerPage="pagination.per_page" @pageChanged="getAllInventories"></Pagination>
        </div>
    </div>
</template>

<style scoped>

</style>
