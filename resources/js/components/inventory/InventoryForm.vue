<script setup>
import { ref, onMounted, defineProps } from 'vue';
import { useRouter } from 'vue-router';
import {toast} from "vue3-toastify";
import {useAuthStore} from '../../stores/authStore';

const authStore = useAuthStore()
const router = useRouter();
const props = defineProps(['operation', 'id']);

const isLoading = ref(false)
const inventoryForm = ref({'name': '', 'description': ''})
const errors = ref([])

// lifecycle hook
onMounted(()=>{
  if (props.id) {
    getInventory()
  }
})

// methods
function handleSubmit() {
  let apiUrl = `/inventories`
  if (props.id) {
      apiUrl = `/inventories/${props.id}`
      inventoryForm.value._method = 'PUT'
  }
  isLoading.value = true
  axios.post(apiUrl, inventoryForm.value, {headers: authStore.reqHeader}).then(res => {
      inventoryForm.value = {}
      router.push('/inventory').then(() => toast.success(res?.data?.message, {theme: 'colored'}))
  }).catch(errors => {
      setError(errors?.response?.data?.errors);
  }).finally(() => isLoading.value = false)
}
function getInventory() {
  isLoading.value = true
  axios.get(`/inventories/${props.id}`, {headers: authStore.reqHeader}).then(res => {
      const {name, description} = res.data.data
      inventoryForm.value.name = name
      inventoryForm.value.description = description
  }).catch(errors => {
      setError(errors?.response?.data?.errors);
  }).finally(() => isLoading.value = false)
}
function setError(e) {
  return errors.value = e;
}
function getError(key) {
  return !!errors.value && errors.value[key] !== undefined ? errors.value[key][0] : null;
}
</script>

<template>
    <div class="form-crud w-100 m-auto">
        <div class="mb-2">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Name" v-model="inventoryForm.name">
            <span class="text-danger" v-if="getError('name')">{{ getError('name') }}</span>
        </div>
        <div class="mb-2">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3" placeholder="Description"
                      v-model="inventoryForm.description"></textarea>
            <span class="text-danger" v-if="getError('description')">{{ getError('description') }}</span>
        </div>

        <button type="button" class="btn btn-primary my-2 ml-auto" @click.prevent="handleSubmit" :disabled="isLoading">Submit</button>
    </div>
</template>

<style scoped>

</style>
