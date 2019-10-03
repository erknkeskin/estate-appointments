<template>
    <div>
        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" id="formModal"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Yeni Randevu Ekle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <Map />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Kaydet</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                    </div>
                </div>
            </div>
        </div>
        <top/>
        <left/>
        <div class="container-content float-left">
            <div class="position-relative">
                <h1>Tüm Randevularım</h1>
                <a class="btn btn-success btn-new" data-toggle="modal" data-target="#formModal"><span
                        class="fas fa-plus"></span></a>
            </div>
            <div class="clearfix"></div>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Ad Soyad</th>
                    <th scope="col">Ev</th>
                    <th scope="col">Danışman</th>
                    <th scope="col">Randevu Zamanı</th>
                    <th scope="col"><span class="text-right d-block">İşlemler</span></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="appointment in appointmentsData">
                    <td scope="col">{{ appointment.customer_name }}</td>
                    <td scope="col">{{ appointment.home_title }}</td>
                    <td scope="col">{{ userName }}</td>
                    <td scope="col">{{ appointment.start | formatStartDate }}</td>
                    <td scope="col">
                        <ul class="process">
                            <li><a href="#"><span class="fas fa-edit"></span></a></li>
                            <li><a href="#"><span class="fas fa-trash"></span></a></li>
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import Left from "../../components/layout/Left";
    import Top from "../../components/layout/Top";
    import Map from "../../components/Map";
    import axios from 'axios'
    import moment from 'moment'

    export default {
        name: 'Appointment',
        components: {
            Left,
            Top,
            Map
        },
        filters: {
            formatStartDate: function (value) {
                if (value) {
                    return moment.unix(value).format('DD.MM.YYYY hh:mm');
                }
            }
        },
        methods: {
            me() {
                return axios.post('/auth/me', {}, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                    .then((response) => {
                        this.userName = response.data.name;
                    })
                    .catch((err)=>{
                        this.$router.replace('/')
                    })
            }
        },
        data() {
            return {
                appointmentsData: [],
                userName: null
            }
        },
        mounted() {

            this.me();

            axios.get('/appointments', {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
                .then((response) => {
                    //console.log(response.data)
                    let data = response.data;
                    for (let key in data) {
                        this.appointmentsData.push(data[key])
                    }
                })
        }
    };
</script>

<style scoped>
    h1 {
        line-height: 80px !important;
    }

    .btn-new {
        position: absolute;
        right: 0px;
        top: 0px;
        display: block;
        width: 80px;
        color: white;
        height: 80px;
        border-radius: 45px;
        line-height: 65px;
        font-size: 32px;
    }
</style>