<template>
    <div class="top">
        <div class="logo-wrapper">
            <router-link to="/" tag="a" class="logo ml-2 mr-2"><img :src="this.$store.state.appData.logo"/>
                {{this.$store.state.appData.name}}
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Top"
    }
</script>

<style scoped>
    .top {
        height:50px;
        background-color:#282828;
        width:100%;
        position: fixed;
        left:0px;
        top:0px;
        z-index: 2;
    }
    .logo-wrapper {
        height: 50px;
        line-height: 50px;
        z-index: 2;
        position: fixed;
        top:0px;
        left:0px;
    }

    .logo {
        position: relative;
        font-size: 28px;
        color: white;
        font-family: 'Squada One', cursive;
        text-decoration: none;
    }

    .logo img {
        height: 25px;
    }
</style>