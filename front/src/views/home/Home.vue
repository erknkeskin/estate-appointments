<template>
    <div>
        <top />
        <left />
        <div class="container-content">
            evler
        </div>
    </div>
</template>
<script>
    import Left from "../../components/layout/Left";
    import Top from "../../components/layout/Top";

    export default {
        name: 'Home',
        components: {
            Left,
            Top
        }
    };
</script>