<script setup>
  import {ref} from 'vue';
  import { useRouter } from 'vue-router';
  import {useAuthStore} from '../stores/authStore';

  const authStore = useAuthStore()
  const router = useRouter();
  const registerForm = ref({name: '', email: '', password: ''});
  const errors = ref([]);

  // methods
  function register() {
      axios.post('/register', registerForm.value).then(res => {
          const {token, user} = res.data.data
          localStorage?.setItem('token', token)
          localStorage?.setItem('user', user)
          authStore.setAuthInfo(user, token)
          registerForm.value = {}
          router.push('/inventory')
      }).catch(errors => {
          setError(errors.response.data.errors);
      })
  }
  function setError(e) {
    return errors.value = e;
  }
  function getError(key) {
    return !!this.errors && this.errors[key] !== undefined ? this.errors[key][0] : null;
  }
</script>
<template>
    <div class="form-signin w-100 m-auto">
        <h2 class="h3 mb-3 fw-normal">Please register</h2>
        <div class="mb-2">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Name" v-model="registerForm.name">
            <span class="text-danger" v-if="getError('name')">{{ getError('name') }}</span>
        </div>
        <div class="mb-2">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="Email" v-model="registerForm.email">
            <span class="text-danger" v-if="getError('email')">{{ getError('email') }}</span>
        </div>
        <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password" v-model="registerForm.password">
            <span class="text-danger" v-if="getError('password')">{{ getError('password') }}</span>
        </div>
        <button class="btn btn-primary w-100 my-2" type="button" @click.prevent="register">Register</button>

        <p class="my-5 text-center">Already have an account?
            <router-link to="/login">Login</router-link>
        </p>
    </div>
</template>


<style scoped>

</style>
