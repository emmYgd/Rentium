
const TenantLandlordImplementResetPassword =
{
	//values:
	serverSyncModel: null,
	reset_email: "",
	unique_id: "",
	reset_token: "",
	new_password: "",

	//states:
	clicked_state: false,
	update_success: false,

	async ImplementPassReset(targetClickElem) {
		//initialize:
		this.Init();

		//Flow 1: SendPassordResetToken
		//Flow 2: ImplementResetPassword

		$(targetClickElem).click(async (event) => {
			//event.preventDefault();

			this.Collectibles();
			console.log(this.reset_email);

			if (
				(this.reset_token == "" ||
					this.reset_token == null ||
					this.reset_token == undefined)
				||
				(this.new_password == "" ||
					this.new_password == null ||
					this.new_password == undefined)
			) {
				//This will be handled by the bootstrap, so, there's no need...
			}
			else {
				event.preventDefault();

				/*this.is_all_null = false;
				this.UpdateIsAllNullUI();*/

				//set state to true for watchers
				this.clicked_state = true;
				//UI loading function:
				this.LoadingUI();

				//first fetch data from local storage:
				this.FetchTokensFromLocal()

				//call the tenant server route:
				//sync model:
				this.serverSyncModel = await this.SyncTenantImplementResetPassModel();
				try {
					
					//now start conditionals:
					if (
						(this.serverSyncModel.code === 1) &&
						(this.serverSyncModel.serverStatus === 'PassResetSuccess!')
					) {
						console.log("Success");

						//update state:
						this.update_success = true;
						//call reactors:
						this.UpdateUI();

						//Clear later when the password is reset:
						this.DeleteAllTokensFromLocal()

						//redirect to login Page:
						this.RedirectToLogin();
					}
					else if
						(
						(this.serverSyncModel.code === 0) /*&&
						(this.serverSyncModel.serverStatus === 'PassResetFailure!')*/
					) {
						//console.log('Error!!!')
						//escape this and throw error to be handled by catch block
						throw new Error(this.serverSyncModel.short_description);
					}
				}
				catch (error) {
					//call the tenant server route:
					//sync model:
					this.serverSyncModel = await this.SyncLandlordImplementResetPassModel();
					if (
						(this.serverSyncModel.code === 1) &&
						(this.serverSyncModel.serverStatus === 'PassResetSuccess!')
					) {
						console.log("Success");

						//update state:
						this.update_success = true;
						//call reactors:
						this.UpdateUI();

						//Clear later when the password is reset:
						this.DeleteAllTokensFromLocal()

						//redirect to login Page:
						this.RedirectToLogin();
					}
					else if
						(
						(this.serverSyncModel.code === 0) &&
						(this.serverSyncModel.serverStatus === 'PassResetFailure!')
					) {
						console.log("Failure");

						//set state to true for watchers
						this.clicked_state = false;
						//UI loading function:
						this.LoadingUI();

						//update state:
						this.update_success = false;
						//call reactors:
						this.UpdateUI();

						//Clear later when the password is reset:
						this.DeleteAllTokensFromLocal()

						//refresh forget password Page:
						//this.RefreshPage();
					}
					else if
						(
						(this.serverSyncModel.code === 0)
					) {
						//set state to true for watchers
						this.clicked_state = false;
						//UI loading function:
						this.LoadingUI();

						if (this.serverSyncModel.short_description) {
							//handle others:
							this.HandleOtherUnexpectedErrors();
						}
						else if (error) {
							//handle others:
							this.HandleOtherUnexpectedErrors(error.message);
						}

					}
				}
			}
		});
	},

	Init() {
		//hide loading icon:
		$('div#resetLoadingIcon2').hide();
		$('div#errorSuccessNotify2').hide();
	},

	Collectibles() {
		this.reset_token = $('input#pwd-input-1').val();
		this.new_password = $('input#pwd-input').val();
	},

	async SyncTenantImplementResetPassModel() {
		let method = "PATCH";
		let sendMailTenantServerUrl = Env.TenantBaseAPI + 'auth/guest/reset/password';

		//console.log("My email", this.reset_email);
		//prepare the JSON model:
		let jsonRequestModel =
		{
			'unique_tenant_id': this.unique_id,
			'tenant_email': this.reset_email,
			'tenant_new_password': this.new_password,
			'pass_reset_token': this.reset_token,
		}

		let serverModel = await AbstractModel(method, sendMailTenantServerUrl, jsonRequestModel);

		return serverModel;
		//this.serverSyncModel = serverModel;
	},

	async SyncLandlordImplementResetPassModel() {
		let method = "PATCH";
		let sendMailLandlordServerUrl = Env.LandlordBaseAPI + 'auth/guest/reset/password';

		//console.log("My email", this.reset_email);
		//prepare the JSON model:
		let jsonRequestModel =
		{
			'unique_landlord_id': this.unique_id,
			'landlord_email': this.reset_email,
			'landlord_new_password': this.new_password,
			'pass_reset_token': this.reset_token,
		}

		let serverModel = await AbstractModel(method, sendMailLandlordServerUrl, jsonRequestModel);

		return serverModel;
		//this.serverSyncModel = serverModel;
	},

	FetchTokensFromLocal() {
		//fetch from the local storage:
		this.unique_id = window.localStorage.getItem('uniqueTenantID');
		this.reset_email = window.localStorage.getItem('resetEmail');
	},

	DeleteAllTokensFromLocal() {
		window.localStorage.clear();
	},

	LoadingUI() {
		if (this.clicked_state) {
			//show and clean:
			$('div#resetLoadingIcon2').show();
			$('div#resetLoadingIcon2').empty();

			//populate:
			$('div#resetLoadingIcon2').html(
				`<div class="spinner-border text-success w3-lime" role="status">
					<span class="sr-only">Loading...</span>
				</div>`
			);
		}
		else if (!this.clicked_state) {
			$('div#resetLoadingIcon2').hide();
			//$('div#errorSuccessNotify2').hide();
		}
	},

	UpdateUI() {
		if (this.update_success) {
			//hide components:
			$('div#resetPasswordInstruction').hide()
			$('div.form-group').hide();
			$('button#resetPasswordBtn').hide();
			//show components:
			$('div#errorSuccessNotify2').show();
			$('div#errorSuccessNotify2').text('');
			$('div#errorSuccessNotify2').text('Password Changed Successfully! Redirecting...');
		}
		else if (!this.update_success) {
			//clear first:
			$('div#redirectLoginNotify').hide();

			$('div#errorSuccessNotify2').show();
			$('div#errorSuccessNotify2').text('Error! Password Not Changed Successfully!');
		}
	},

	HandleOtherUnexpectedErrors(errorMessage = 'Error! Not Found!') {
		$('div#resetLoadingIcon2').hide();
		$('div#errorSuccessNotify2').show();
		$('div#errorSuccessNotify2').text('');
		$('div#errorSuccessNotify2').text(errorMessage);
	},

	RefreshPage() {
		//redirect to dashboard after waiting for 5millisecond:
		setTimeout(() => {
			window.location.replace('forgot-password.html'), 7000
		});
	},

	RedirectToLogin() {
		//redirect to login after waiting for 5millisecond:
		setTimeout(() => {
			window.location.replace('login.html'), 5000
		});
	},
}

//call the object method:
if ($('body#forgotPassPage').val() !== undefined) {
	//console.log("Not Absent")
	TenantLandlordImplementResetPassword.ImplementPassReset('button#resetPasswordBtn');
}