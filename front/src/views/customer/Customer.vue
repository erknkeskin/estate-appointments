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
							@click="removeCustomer"
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
							<input type="hidden" value="0" v-model="saveCustomerData.id" />
							<div class="form-row mb-3">
								<input
									type="text"
									autocomplete="off"
									class="form-control"
									placeholder="Ad Soyad"
									v-model="saveCustomerData.fullname"
								/>
							</div>
							<div class="form-row mb-3">
								<input
									type="email"
									autocomplete="off"
									class="form-control"
									placeholder="E-mail"
									v-model="saveCustomerData.email"
								/>
							</div>
							<div class="form-row mb-3">
								<input
									type="tel"
									autocomplete="off"
									class="form-control"
									placeholder="Telefon"
									v-model="saveCustomerData.phone"
								/>
							</div>
							<div class="form-row mb-3">
								<textarea
									placeholder="Adres"
									v-model="saveCustomerData.address"
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
						<button type="button" class="btn btn-primary" @click="saveCustomer">
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
				<h1>Tüm Müşteriler</h1>
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
						<th scope="col">Ad Soyad</th>
						<th scope="col">E-Posta</th>
						<th scope="col">Telefon</th>
						<th scope="col">
							<span class="text-right d-block">İşlemler</span>
						</th>
					</tr>
				</thead>
				<tbody>
					<tr v-for="customer in customersData">
						<td scope="col">{{ customer.fullname }}</td>
						<td scope="col">{{ customer.email }}</td>
						<td scope="col">{{ customer.phone }}</td>
						<td scope="col">
							<ul class="process">
								<li>
									<a @click="getSingleCustomer(customer.id)"
										><span class="fas fa-edit"></span
									></a>
								</li>
								<li>
									<a @click="removeConfirmScreen(customer.id)"
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
	name: "Customer",
	components: {
		Left,
		Top
	},
	methods: {
		validEmail: function(email) {
			var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			return re.test(email);
		},
		removeConfirmScreen(id) {
			this.deleteCustomerId = id;
			$("#deleteModal").modal();
		},
		removeCustomer() {
			axios
				.delete("/customers/" + this.deleteCustomerId, {
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
		getSingleCustomer(id) {
			axios
				.get("/customers/" + id, {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					this.saveCustomerData.id = response.data.data.id;
					this.saveCustomerData.fullname = response.data.data.fullname;
					this.saveCustomerData.email = response.data.data.email;
					this.saveCustomerData.phone = response.data.data.phone;
					this.saveCustomerData.address = response.data.data.address;

					this.modalTitle = "Müşteri Güncelle";

					$("#formModal").modal();
				})
				.catch(error => {
					if (error.response.status === 401) {
						this.$store.dispatch("logout");
						this.$router.replace("/");
					}
				});
		},
		saveCustomer() {
			if (this.saveCustomerData.fullname === "") {
				this.saveFormWarning.message = "Ad soyad yazmalısınız";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			if (!this.validEmail(this.saveCustomerData.email)) {
				this.saveFormWarning.message = "E-posta hatalı";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			if (this.saveCustomerData.phone === "") {
				this.saveFormWarning.message = "Telefon yazmalısınız";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			if (this.saveCustomerData.address === "") {
				this.saveFormWarning.message = "Adres yazmalısınız";
				this.saveFormWarning.style = "badge badge-danger d-block";
				return false;
			}

			this.saveFormWarning.message = "Kaydediliyor...";
			this.saveFormWarning.style = "badge badge-warning d-block";
			this.saveFormWarning.icon = '<i class="fas fa-check-circle"></i>';

			if (this.saveCustomerData.id === 0) {
				delete this.saveCustomerData.id; // new

				axios
					.post("/customers", this.saveCustomerData, {
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
				let updateId = this.saveCustomerData.id;
				delete this.saveCustomerData.id;
				axios
					.put("/customers/" + updateId, this.saveCustomerData, {
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
		getAllCustomers() {
			axios
				.get("/customers", {
					headers: {
						Accept: "application/json",
						"Content-Type": "application/json"
					}
				})
				.then(response => {
					let data = response.data;
					for (let key in data) {
						this.customersData.push(data[key]);
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
			modalTitle: "Yeni Müşteri Ekle",
			customersData: [], // all homes
			deleteCustomerId: 0,
			saveCustomerData: {
				id: 0,
				fullname: "",
				email: "",
				phone: "",
				address: ""
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
		this.getAllCustomers();
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
