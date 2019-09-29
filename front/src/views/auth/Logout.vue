<template></template>
<script>
    export default {
        name: 'Logout',
        created() {
            this.$store.dispatch('logout')
        }
    }
</script>