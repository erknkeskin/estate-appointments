<template>
    <div class="content">
        <left class="mr-2"/>
        <main>
            <top/>
            <div class="wrapper">
                randevular
            </div>
        </main>

    </div>
</template>
<script>
    import Left from "../../components/layout/Left";
    import Top from "../../components/layout/Top";

    export default {
        name: 'Appointment',
        components: {
            Left,
            Top
        },
        mounted() {
            if (!this.$store.getters.isAuth) {
                this.$router.replace('/login')
            }
        }
    };
</script>

<style scoped>
    .top {
        background-color: #282828;
    }
</style>