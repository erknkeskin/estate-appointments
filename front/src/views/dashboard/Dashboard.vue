<template>
    <div>
        <top/>
        <left/>
        <div class="container-content">
            dashboard
        </div>
    </div>
</template>
<script>
    import Left from "../../components/layout/Left";
    import Top from "../../components/layout/Top";

    export default {
        name: 'Dashboard',
        components: {
            Left,
            Top
        }
    };
</script>