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
						<button type="button" @click="removeHome" class="btn btn-danger">
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
							<input type="hidden" value="0" v-model="saveHomeData.id" />
							<div class="form-row mb-3">
								<GmapMap
									:center="{ lat: 40.99, lng: 28.65 }"
									:zoom="13"
									style="width:100%; height: 300px"
								>
									<GmapMarker
										:position="{ lat: this.saveHomeData.latitude, lng: this.saveHomeData.longitude }"
										:clickable="false"
										:draggable="true"
										@drag="selectHome"
									/>
								</GmapMap>
							</div>
							<div class="form-row mb-3">
								<input
									type="text"
									autocomplete="off"
									class="form-control"
									placeholder="Ev"
									v-model="saveHomeData.title"
								/>
							</div>
							<div class="form-row mb-3">
								<textarea
									placeholder="Notlar"
									v-model="saveHomeData.note"
									class="form-control"
								></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div
							v-html="saveFormWarning.icon + ' ' + saveFormWarning.message"
							:class="saveFormWarning.style"
						></div>
						<button type="button" class="btn btn-primary" @click="saveHome">
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
				<h1>Tüm Evler</h1>
				<a
					class="btn btn-success btn-new"
					data-toggle="modal"
					data-target="#formModal"
					><span class="fas fa-plus"></span
				></a>
			</div>
			<div class="clearfix"></div>
			<table class="table table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th scope="col">Ev</th>
						<th scope="col">
							<span class="text-right d-block">İşlemler</span>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="home in homesData">
						<td scope="col">{{ home.title }}</td>
						<td scope="col">
							<ul class="process">
								<li>
									<a @click="getSingleHome(home.id)"
										><span class="fas fa-edit"></span
									></a>
								</li>
								<li>
									<a @click="removeConfirmScreen(home.id)"
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

export default {
	name: "Home",
	components: {
		Left,
		Top
	},
	methods: {
		removeConfirmScreen(id) {
			this.deleteHomeId = id;
			$("#deleteModal").modal();
		},
		removeHome() {
			axios
				.delete("/homes/" + this.deleteHomeId, {
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
		getSingleHome(id) {
			axios
				.get("/homes/" + id, {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					this.saveHomeData.id = response.data.data.id;
					this.saveHomeData.title = response.data.data.title;
					this.saveHomeData.note = response.data.data.note;
					this.saveHomeData.latitude = parseFloat(response.data.data.latitude);
					this.saveHomeData.longitude = parseFloat(response.data.data.longitude);

					this.modalTitle = "Ev Güncelle";

					$("#formModal").modal();
				})
				.catch(error => {
					if (error.response.status === 401) {
						this.$store.dispatch("logout");
						this.$router.replace("/");
					}
				});
		},
		saveHome() {
			if (this.saveHomeData.title === '') {
				this.saveFormWarning.message = "Ev başlığı yazmalısınız";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			if (this.saveHomeData.note === '') {
				this.saveFormWarning.message = "Ev notu yazmalısınız";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			if (
				this.saveHomeData.latitude === '' &&
				this.saveHomeData.longitude === ''
			) {
				this.saveFormWarning.message = "Haritadan koordinat seçmelisiniz";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			this.saveFormWarning.message = "Kaydediliyor...";
			this.saveFormWarning.style = "badge badge-warning d-block";
			this.saveFormWarning.icon = '<i class="fas fa-check-circle"></i>';

			if (this.saveHomeData.id === 0) {
				delete this.saveHomeData.id; // new

				axios
					.post("/homes", this.saveHomeData, {
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
						}, 500);
					});
			} else {
				let updateId = this.saveHomeData.id;
				delete this.saveHomeData.id;
				axios
					.put("/homes/" + updateId, this.saveHomeData, {
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
						}, 500);
					});
			}
		},
		selectHome(location) {
			//this.mapsData.selectedHome.id = home.data.id;
			/*this.coordinates = {
                lat: location.latLng.lat(),
                lng: location.latLng.lng(),
            };*/
			this.saveHomeData.latitude = location.latLng.lat();
			this.saveHomeData.longitude = location.latLng.lng();
		},
		getAllHomes() {
			axios
				.get("/homes", {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					let data = response.data;
					for (let key in data) {
						this.homesData.push(data[key]);
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
				.then(response => {})
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
			modalTitle: "Yeni Ev Ekle",
			homesData: [], // all homes
			deleteHomeId: 0,
			saveHomeData: {
				id: 0,
				title: '',
				note: '',
				latitude: 40.99,
				longitude: 28.65
			},
			saveFormWarning: {
				style: "badge badge-danger d-none",
				icon: '<i class="fas fa-exclamation"></i>',
				message: ""
			}
		};
	},
	mounted() {
		this.me();
		this.getAllHomes();
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
