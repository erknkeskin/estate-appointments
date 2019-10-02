<template>
    <div>
        <top />
        <left />
        <div class="container-content">
            müşteriler
        </div>
    </div>
</template>
<script>
    import Left from "../../components/layout/Left";
    import Top from "../../components/layout/Top";

    export default {
        name: 'Customer',
        components: {
            Left,
            Top
        }
    };
</script>