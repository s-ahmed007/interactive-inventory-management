<script setup>
  import {ref} from 'vue';
  import { useRouter } from 'vue-router';
  import {useAuthStore} from '../stores/authStore';

  const authStore = useAuthStore()
  const router = useRouter();
  const loginForm = ref({email: '', password: ''});
  const errors = ref([]);

// methods
  function logIn() {
    axios.post('/login', loginForm.value).then(res => {
      const {token, user} = res.data.data

      localStorage?.setItem('token', token)
      localStorage?.setItem('user', JSON.stringify(user))
      authStore.setAuthInfo(user, token)
      loginForm.value = {}
      router.push('/inventory')
    }).catch(errors => {
      setError(errors?.response?.data?.errors);
    })
  }
  function setError(e) {
    return errors.value = e;
  }
  function getError(key) {
    return !!errors.value && errors.value[key] !== undefined ? errors.value[key][0] : null;
  }
</script>

<template>
    <div class="form-signin w-100 m-auto">
        <h2 class="h3 mb-3 fw-normal">Please sign in</h2>
        <div class="mb-2">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" placeholder="Email" v-model="loginForm.email">
            <span class="text-danger" v-if="getError('email')">{{ getError('email') }}</span>
        </div>
        <div class="mb-2">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Password"
                   v-model="loginForm.password">
            <span class="text-danger" v-if="getError('password')">{{ getError('password') }}</span>
        </div>

        <button type="button" class="btn btn-primary w-100 my-2" @click.prevent="logIn">Sign in</button>

        <p class="my-5 text-center">New member?
            <router-link to="/register">Register</router-link>
        </p>
    </div>
</template>

<style scoped>

</style>
