<template>
	<div>
		<div class="modal" tabindex="-1" role="dialog" id="deleteModal">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Silinecektir</h5>
						<button
							type="button"
							class="close"
							data-dismiss="modal"
							aria-label="Close"
						>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Kayıt silinecektir. Onaylıyor musunuz ?</p>
					</div>
					<div class="modal-footer">
						<button
							type="button"
							@click="removeAppointment"
							class="btn btn-danger"
						>
							Sil
						</button>
						<button type="button" class="btn btn-info" data-dismiss="modal">
							İptal
						</button>
					</div>
				</div>
			</div>
		</div>
		<div
			class="modal fade bd-example-modal-lg"
			tabindex="-1"
			role="dialog"
			aria-labelledby="formModalLabel"
			id="formModal"
			aria-hidden="true"
		>
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">{{ modalTitle }}</h5>
						<button
							type="button"
							class="close"
							data-dismiss="modal"
							aria-label="Close"
						>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="modalNewForm">
							<div class="form-row mb-3">
								<input
									type="hidden"
									value="0"
									v-model="saveAppointmentData.id"
								/>
								<select
									class="form-control"
									v-model="saveAppointmentData.customer_id"
								>
									<option :value="null">Müşteri Seçiniz</option>
									<option v-for="customer in customers" :value="customer.id">{{
										customer.fullname
									}}</option>
								</select>
							</div>
							<div class="form-row mb-3">
								<GmapMap
									:center="{ lat: 40.99, lng: 28.65 }"
									:zoom="11"
									style="width:100%; height: 300px"
								>
									<GmapMarker
										:key="index"
										v-for="(m, index) in mapsData.markers"
										:position="m.position"
										:title="m.label"
										:clickable="true"
										:draggable="false"
										@click="selectHome(m)"
									/>
								</GmapMap>
							</div>
							<div class="form-row mb-3">
								<span :class="mapsData.selectedHome.style">{{
									mapsData.selectedHome.title
								}}</span>
							</div>
							<div class="form-row mb-3">
								<input
									type="text"
									autocomplete="off"
									class="form-control"
									placeholder="Randevu Başlığı"
									v-model="saveAppointmentData.title"
								/>
							</div>
							<div class="form-row mb-3">
								<textarea
									placeholder="Notlar"
									v-model="saveAppointmentData.note"
									class="form-control"
								></textarea>
							</div>
							<div class="form-row mb-3">
								<date-picker
									v-model="saveAppointmentData.start"
									:config="datePicker.options"
								></date-picker>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div
							v-html="saveFormWarning.icon + ' ' + saveFormWarning.message"
							:class="saveFormWarning.style"
						></div>
						<button
							type="button"
							class="btn btn-primary"
							@click="saveAppointment"
						>
							Kaydet
						</button>
						<button
							type="button"
							class="btn btn-secondary"
							data-dismiss="modal"
						>
							İptal
						</button>
					</div>
				</div>
			</div>
		</div>
		<top />
		<left />
		<div class="container-content float-left">
			<div class="position-relative">
				<h1>Tüm Randevularım</h1>
				<a
					class="btn btn-success btn-new"
					data-toggle="modal"
					data-target="#formModal"
					@click="getCustomers"
					><span class="fas fa-plus"></span
				></a>
			</div>
			<div class="clearfix"></div>
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Ad Soyad</th>
						<th scope="col">Ev</th>
						<th scope="col">Randevu Başlık</th>
						<th scope="col">Danışman</th>
						<th scope="col">Randevu Zamanı</th>
						<th scope="col">
							<span class="text-right d-block">İşlemler</span>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="appointment in appointmentsData">
						<td scope="col">{{ appointment.customer_name }}</td>
						<td scope="col">{{ appointment.home_title }}</td>
						<td scope="col">{{ appointment.appointment_title }}</td>
						<td scope="col">{{ userName }}</td>
						<td scope="col">{{ appointment.start | formatStartDate }}</td>
						<td scope="col">
							<ul class="process">
								<li>
									<a @click="getSingleAppointment(appointment.id)"
										><span class="fas fa-edit"></span
									></a>
								</li>
								<li>
									<a @click="removeConfirmScreen(appointment.id)"
										><span class="fas fa-trash"></span
									></a>
								</li>
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
import axios from "axios";
import moment from "moment";
import datePicker from "vue-bootstrap-datetimepicker";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";

export default {
	name: "Appointment",
	components: {
		Left,
		Top,
		datePicker
	},
	computed: {
		getHomesForMap() {
			// get homes for map markers
			axios
				.get("/homes", {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					for (let i = 0; i < response.data.length; i++) {
						this.mapsData.markers.push({
							data: {
								id: response.data[i].id,
								title: response.data[i].title
							},
							position: {
								lat: parseFloat(response.data[i].latitude),
								lng: parseFloat(response.data[i].longitude)
							}
						});
					}
				})
				.catch(error => {
					if (error.response.status === 401) {
						this.$store.dispatch("logout");
						this.$router.replace("/");
					}
				});
		}
	},
	filters: {
		formatStartDate: function(value) {
			// display for gridlist date change timestamp to date
			if (value) {
				return moment.unix(value).format("DD.MM.YYYY hh:mm");
			}
		}
	},
	methods: {
		getSingleHome(id) {
			axios
				.get("/homes/" + id, {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					this.mapsData.selectedHome.id = response.data.data.id;
					this.mapsData.selectedHome.title = response.data.data.title;
				})
				.catch(error => {
					if (error.response.status === 401) {
						this.$store.dispatch("logout");
						this.$router.replace("/");
					}
				});
		},
		removeConfirmScreen(id) {
			this.deleteAppointmentId = id;
			$("#deleteModal").modal();
		},
		removeAppointment() {
			axios
				.delete("/appointments/" + this.deleteAppointmentId, {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					$("#deleteModal").modal("hide");
					setTimeout(() => {
						window.location.reload();
					}, 500);
				})
				.catch(error => {
					if (error.response.status === 401) {
						this.$store.dispatch("logout");
						this.$router.replace("/");
					}
				});
		},
		getSingleAppointment(id) {
			axios
				.get("/appointments/" + id, {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					//console.log(response.data.data)
					this.getCustomers();
					this.saveAppointmentData.id = response.data.data.id;
					this.saveAppointmentData.customer_id = response.data.data.customer_id;
					this.saveAppointmentData.home_id = response.data.data.home_id;
					this.saveAppointmentData.user_id = response.data.data.user_id;
					this.saveAppointmentData.title = response.data.data.title;
					this.saveAppointmentData.note = response.data.data.note;
					this.saveAppointmentData.start = moment
						.unix(response.data.data.start)
						.format("DD.MM.YYYY H:m:ss");

					this.modalTitle = "Randevuyu Güncelle";

					this.getSingleHome(response.data.data.home_id);

					$("#formModal").modal();
				})
				.catch(error => {
					if (error.response.status === 401) {
						this.$store.dispatch("logout");
						this.$router.replace("/");
					}
				});
		},
		saveAppointment() {
			if (this.saveAppointmentData.customer_id === null || this.saveAppointmentData.customer_id == '') {
				this.saveFormWarning.message = "Müşteri seçmelisiniz";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			if (this.saveAppointmentData.home_id === '') {
				this.saveFormWarning.message = "Ev seçmelisiniz";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			if (this.saveAppointmentData.title === '') {
				this.saveFormWarning.message = "Randevu başlığı yazmalısınız";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			if (this.saveAppointmentData.note === '') {
				this.saveFormWarning.message = "Randevu notu yazmalısınız";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			if (this.saveAppointmentData.start === '') {
				this.saveFormWarning.message = "Randevu zamanı seçmelisiniz";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			this.saveFormWarning.message = "Kaydediliyor...";
			this.saveFormWarning.style = "badge badge-warning d-block";
			this.saveFormWarning.icon = '<i class="fas fa-check-circle"></i>';

			if (this.saveAppointmentData.id === 0) {

				delete this.saveAppointmentData.id; // new

				axios
					.post("/appointments", this.saveAppointmentData, {
						headers: {
							Accept: "application/json",
							"Content-Type": "application/json"
						}
					})
					.then(response => {
						this.saveFormWarning.message = "Kaydedildi";
						this.saveFormWarning.style = "badge badge-success d-block";
						this.saveFormWarning.icon = '<i class="fas fa-check-circle"></i>';
						this.saveFormWarning.message = "";
						this.saveFormWarning.style = "d-none";
						this.saveFormWarning.icon = "";
						$("#formModal").modal("hide");
						setTimeout(() => {
							window.location.reload();
						}, 1000);
					});
			} else {
				let updateId = this.saveAppointmentData.id;
				delete this.saveAppointmentData.id;
				axios
					.put("/appointments/" + updateId, this.saveAppointmentData, {
						headers: {
							Accept: "application/json",
							"Content-Type": "application/json"
						}
					})
					.then(response => {
						this.saveFormWarning.message = "Kaydedildi";
						this.saveFormWarning.style = "badge badge-success d-block";
						this.saveFormWarning.icon = '<i class="fas fa-check-circle"></i>';
						this.saveFormWarning.message = "";
						this.saveFormWarning.style = "d-none";
						this.saveFormWarning.icon = "";
						$("#formModal").modal("hide");

						setTimeout(() => {
							window.location.reload();
						}, 1000);
					});
			}
		},
		selectHome(home) {
			//this.mapsData.selectedHome.id = home.data.id;
			this.mapsData.selectedHome.title = home.data.title; // display title in form
			this.saveAppointmentData.home_id = home.data.id; // for save
		},
		getCustomers() {
			// all customers
			axios
				.get("/customers", {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					for (let i = 0; i < response.data.length; i++) {
						this.customers.push({
							id: response.data[i].id,
							fullname: response.data[i].fullname
						});
					}
				})
				.catch(error => {
					if (error.response.status === 401) {
						this.$store.dispatch("logout");
						this.$router.replace("/");
					}
				});
		},
		getAllAppointments() {
			axios
				.get("/appointments", {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					let data = response.data;
					for (let key in data) {
						this.appointmentsData.push(data[key]);
					}
				});
		},
		me() {
			// my user data
			axios
				.post(
					"/auth/me",
					{},
					{
						headers: {
							Accept: "application/json",
							"Content-Type": "application/json"
						}
					}
				)
				.then(response => {
					this.userName = response.data.name;
					this.saveAppointmentData.user_id = response.data.id;
				})
				.catch(error => {
					if (error.response.status === 401) {
						this.$store.dispatch("logout");
						this.$router.replace("/");
					}
				});
		}
	},
	data() {
		return {
			modalTitle: "Yeni Randevu Ekle",
			appointmentsData: [], // all appointments
			userName: null, // for gridlist
			customers: [], // for select
			homes: [], // for maps
			deleteAppointmentId: 0,
			datePicker: {
				options: {
					format: "DD.MM.YYYY H:m:ss",
					useCurrent: false,
					icons: {
						time: "far fa-clock",
						date: "far fa-calendar",
						up: "fas fa-arrow-up",
						down: "fas fa-arrow-down",
						previous: "fas fa-chevron-left",
						next: "fas fa-chevron-right",
						today: "fas fa-calendar-check",
						clear: "far fa-trash-alt",
						close: "far fa-times-circle"
					}
				}
			},
			saveAppointmentData: {
				// for save
				id: 0,
				customer_id: null,
				user_id: '',
				home_id: '',
				title: '',
				note: '',
				start: ''
			},
			saveFormWarning: {
				style: "badge badge-danger d-none",
				icon: '<i class="fas fa-exclamation"></i>',
				message: ""
			},
			mapsData: {
				//for maps
				markers: [],
				selectedHome: {
					// selected with click marker
					id: 0,
					title: null,
					style: "badge badge-success"
				}
			}
		};
	},
	mounted() {
		this.me();
		this.getAllAppointments();
		this.getHomesForMap;
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
	color: white !important;
	cursor: pointer;
	height: 80px;
	border-radius: 45px;
	line-height: 65px;
	font-size: 32px;
}
</style>
