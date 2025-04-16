import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from 'axios'

import App from './App.vue'
import router from './router'

//import ErrorMessage from './components/common/ErrorMessage.vue'

const app = createApp(App)

app.use(createPinia())
app.use(router)

const apiDomain = import.meta.env.VITE_API_DOMAIN

// Default Axios configuration
axios.defaults.baseURL = `http://${apiDomain}/api`


app.provide('serverBaseUrl', apiDomain)

app.mount('#app')

