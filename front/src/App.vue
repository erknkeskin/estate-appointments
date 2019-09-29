<template>
    <div id="app">
        <router-view/>
    </div>
</template>

<script>
    export default {
        created(){
            let token = localStorage.getItem('token')

            if (token) {
                this.$store.commit('setToken', token)
            }
        }
    }
</script>