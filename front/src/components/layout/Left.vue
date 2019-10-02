<template>
    <div>
        <div class="logo-wrapper">
            <router-link to="/" tag="a" class="logo ml-2 mr-2"><img :src="this.$store.state.appData.logo"/>
                {{this.$store.state.appData.name}}
            </router-link>
        </div>
        <nav :style="{height:window.height+'px'}" :class="[ isMobile ? 'leftContentMobileView' : 'leftContent' ]">
            <ul>
                <router-link active-class="active" to="/" exact tag="li"><a href="#"><span
                        class="fas fa-tachometer-alt"></span> Kontrol Paneli</a>
                </router-link>
                <router-link active-class="active" to="/appointments" tag="li"><a href="#"><span
                        class="fas fa-calendar"></span>
                    Randevular</a></router-link>
                <router-link active-class="active" to="/homes" tag="li"><a href="#"><span class="fas fa-home"></span>
                    Evler</a></router-link>
                <router-link active-class="active" to="/customers" tag="li"><a href="#"><span
                        class="fas fa-user-alt"></span> Müşteriler</a>
                </router-link>
                <router-link active-class="active" to="/offices" tag="li"><a href="#"><span
                        class="fas fa-building"></span> Ofisler</a>
                </router-link>
                <router-link active-class="active" to="/logout" tag="li"><a href="#"><span
                        class="fas fa-sign-out-alt"></span> Güvenli Çıkış</a>
                </router-link>
            </ul>
        </nav>
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

                this.window.width = document.documentElement.clientWidth;
                this.window.height = document.documentElement.clientHeight;

                if (document.documentElement.clientWidth < 768)
                    this.isMobile = true
                else
                    this.isMobile = false
            }
        }
    }
</script>

<style scoped>
    @import url('https://fonts.googleapis.com/css?family=Squada+One&display=swap');

    .leftContent {
        width: 250px;
        float: left;
        position: absolute;
        background-color: #e1e1e1;
        padding-top: 20px;
    }

    .leftContentMobileView {

    }

    nav ul {
        margin: 0px;
        padding: 0px;
    }

    nav ul li {
        list-style: none;
        height: 50px;
        line-height: 50px;
        padding-left: 10px;
    }

    nav ul li:hover {
        background-color: #ffffff;
        cursor: pointer;
    }

    nav ul li:hover a {
        color: #282828;
        display: block;
        height: 100%;
        width: 100%;
    }

    nav ul li a {
        text-decoration: none;
        color: #282828;
        font-size: 14px;
    }

    nav ul li.active {
        background-color: #ffffff;
    }

    nav ul li.active a {
        color: #282828 !important;
    }

    .logo-wrapper {
        height: 50px;
        line-height: 50px;
        z-index: 2;
        position: relative;
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