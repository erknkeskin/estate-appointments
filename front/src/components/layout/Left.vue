<template>
    <div :class="[ isMobile ? 'leftContentMobileView' : 'leftContent' ]">
        <div class="header">
            <a class="logo text-center d-block"><img src="../../assets/img/logo.png" height="25"
                                                     class="ml-2 mr-2"/><span>{{ this.$store.state.appData.name }}</span></a>
        </div>
        <div class="navigation" :style="{height:window.height+'px'}">
            <nav>
                <ul>
                    <router-link to="/" tag="li"><a class="ml-3"><span class="fas fa-tachometer-alt"></span>
                        Dashboard</a></router-link>
                    <router-link to="/appointments" tag="li"><a class="ml-3"><span class="fas fa-calendar"></span>
                        Randevular</a></router-link>
                    <router-link to="/homes" tag="li"><a class="ml-3"><span class="fas fa-home"></span> Evler</a>
                    </router-link>
                    <router-link to="/offices" tag="li"><a class="ml-3"><span class="fas fa-building"></span>
                        Ofisler</a></router-link>
                    <router-link to="/logout" tag="li"><a class="ml-3"><span class="fas fa-sign-out-alt"></span> Güvenli
                        Çıkış</a></router-link>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Left",
        data() {
            return {
                window: {
                    width: 0,
                    height: 0
                },
                isMobile: false
            }
        },
        created() {
            window.addEventListener('resize', this.changeWidthForMobile)
            this.changeWidthForMobile();
            if (this.window.width < 768)
                this.isMobile = true
            else
                this.isMobile = false
        },
        destroyed() {
            window.removeEventListener('resize', this.changeWidthForMobile)
        },
        methods: {
            changeWidthForMobile() {
                this.window.width = window.innerWidth;
                this.window.height = window.innerHeight;

                if (window.innerWidth < 768)
                    this.isMobile = true
                else
                    this.isMobile = false

            }
        }
    }
</script>

<style scoped>

    @import url('https://fonts.googleapis.com/css?family=Righteous&display=swap');

    .leftContent {
        width: 250px;
        float: left;
        position: relative;
    }

    .leftContentMobileView {

    }

    .header {
        height: 50px;
        background-color: #282828;
    }

    .header .logo {
        font-family: 'Righteous', cursive;
        color: white;
        line-height: 50px;
        font-size: 26px;
    }

    .header .logo:hover {
        color: white;
    }

    .header .logo img {
        position: relative;
        top: -5px;
    }

    .navigation {
        background-color: #e1e1e1;
    }

    nav {

    }

    nav ul {
        margin: 0px;
        padding: 0px;
    }

    nav ul li {
        list-style: none;
        line-height: 50px;
        cursor: pointer;
    }

    nav ul li:hover {
        background-color: #495057;
    }

    nav ul li:hover a {
        color:white;
    }

    nav ul li a {
        text-decoration: none;
        font-weight: bold;
        color:#555;
        width: 100%;
    }

    nav ul li a span {

    }
</style>