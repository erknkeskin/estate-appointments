<template>
    <div>
        <top/>
        <left/>
        <div class="container-content float-left">
            <h1>Tüm Randevularım</h1>
            <div class="clearfix"></div>
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Ad Soyad</th>
                    <th scope="col">Ev</th>
                    <th scope="col">Danışman</th>
                    <th scope="col">Randevu Zamanı</th>
                    <th scope="col">Durum</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="appointment in appointmentsData">
                    <td scope="col">{{ appointment.customer_name }}</td>
                    <td scope="col">{{ appointment.home_title }}</td>
                    <td scope="col">{{ userName }}</td>
                    <td scope="col">Randevu Zamanı</td>
                    <td scope="col">Durum</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    import Left from "../../components/layout/Left";
    import Top from "../../components/layout/Top";
    import axios from 'axios'

    export default {
        name: 'Appointment',
        components: {
            Left,
            Top
        },
        methods: {
            me(){
                return axios.post('/auth/me', {}, {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                    .then((response) => {
                        this.userName = response.data.name;
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