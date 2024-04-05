<script setup>
import { ref, onMounted, defineProps } from 'vue';
import { useRouter } from 'vue-router';
import {toast} from "vue3-toastify";
import {useAuthStore} from '../../stores/authStore';

const authStore = useAuthStore()
const router = useRouter();
const props = defineProps(['operation', 'inventoryId', 'id']);

const isLoading = ref(false)
const inventoryItemForm = ref({'name': '', 'quantity': '', 'image': '', 'show_image': '', 'description': ''})
const errors = ref([])

// lifecycle hook
onMounted(()=>{
  if (props.id) {
    getInventoryItem()
  }
})

// methods
function handleSubmit() {
  // Form data
  let itemData = new FormData();
  itemData.append('name', inventoryItemForm.value.name);
  itemData.append('quantity', inventoryItemForm.value.quantity);
  itemData.append('description', inventoryItemForm.value.description);
  itemData.append('image', inventoryItemForm.value.image);

  let apiUrl = `/inventories/${props.inventoryId}/inventoryItems`
  if (props.inventoryId && props.id) {
      apiUrl = `/inventories/${props.inventoryId}/inventoryItems/${props.id}`
      itemData.append('_method','PUT');
  }

  isLoading.value = true

  axios.post(apiUrl, itemData, {headers: authStore.reqHeader}).then(res => {
      inventoryItemForm.value = {}
      router.push(`/inventory/${props.inventoryId}/item`).then(() => toast.success(res?.data?.message, {theme: 'colored'}))
  }).catch(errors => {
      setError(errors.response.data.errors);
  }).finally(() => isLoading.value = false)
}
function getInventoryItem() {
    isLoading.value = true
    axios.get(`/inventories/${props.inventoryId}/inventoryItems/${props.id}`, {headers: authStore.reqHeader}).then(res => {
        const {name, description, quantity, image} = res.data.data
        inventoryItemForm.value.name = name
        inventoryItemForm.value.quantity = quantity
        inventoryItemForm.value.show_image = image
        inventoryItemForm.value.description = description
    }).catch(errors => {
        setError(errors.response.data.errors);
    }).finally(() => isLoading.value = false)
}
function setError(e) {
  return errors.value = e;
}
function getError(key) {
    return !!this.errors && this.errors[key] !== undefined ? this.errors[key][0] : null;
}
</script>

<template>
    <div class="form-crud w-100 m-auto">
        <div class="mb-2">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Name" v-model="inventoryItemForm.name">
            <span class="text-danger" v-if="getError('name')">{{ getError('name') }}</span>
        </div>
        <div class="mb-2">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" placeholder="Quantity" v-model="inventoryItemForm.quantity">
            <span class="text-danger" v-if="getError('quantity')">{{ getError('quantity') }}</span>
        </div>
        <div class="mb-2">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" id="image" @change="(e) => inventoryItemForm.image = e.target.files[0]">
            <span class="text-danger" v-if="getError('image')">{{ getError('image') }}</span>
            <img :src="inventoryItemForm.show_image" class="img-fluid w-25 mt-1" alt="Item image" v-if="inventoryItemForm.show_image">
        </div>
        <div class="mb-2">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" rows="3" placeholder="Description"
                      v-model="inventoryItemForm.description"></textarea>
            <span class="text-danger" v-if="getError('description')">{{ getError('description') }}</span>
        </div>

        <button type="button" class="btn btn-primary my-2 ml-auto" @click.prevent="handleSubmit">Submit</button>
    </div>
</template>

<style scoped>

</style>
