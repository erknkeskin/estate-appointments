<template>
    <div>
        <nav :class="[ isMobile ? 'leftContentMobileView' : 'leftContent' ]">
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
    @import url('https://fonts.googleapis.com/css?family=Squada+One&display=swap');

    .leftContent {
        width: 250px;
        float: left;
        position: fixed;
        top:50px;
        background-color: #e1e1e1;
        height: 100%;
    }

    .leftContentMobileView {

    }

    nav ul {
        margin: 20px 0px;
        padding: 0px;
    }

    nav ul li {
        list-style: none;
        height: 50px;
        line-height: 50px;
        padding-left: 20px;
        display: block;
        cursor: pointer;
    }

    nav ul li:hover {
        background-color: #ffffff;
    }

    nav ul li a {
        font-size: 14px;
        color: #282828;
        display: block;
        width: 100%;
        height:100%;
        text-decoration: none;
    }

    nav ul li.active {
        background-color: #ffffff;
    }
</style>