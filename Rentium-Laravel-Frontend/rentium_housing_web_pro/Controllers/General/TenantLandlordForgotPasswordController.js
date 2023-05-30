const TenantLandlordForgotPassword =
{
	//values:
	serverSyncModel: null,
	unique_id: "",
	reset_email: "",

	//states:
	clicked_state: false,
	update_success: false,

	async SendResetPassMail(targetClickElem) {
		//initialize:
		this.Init();

		//Flow 1: SendPassordResetToken
		//Flow 2: ImplementResetPassword

		$(targetClickElem).click(async (event) => {
			//event.preventDefault();

			this.Collectibles();
			console.log(this.reset_email);

			if (
				this.reset_email == ""
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

				//call the tenant server route:
				//sync model:
				this.serverSyncModel = await this.SyncPassResetTokenToTenantEmailModel();
				try {
					//now start conditionals:
					if (
						(this.serverSyncModel.code === 1) &&
						(this.serverSyncModel.serverStatus === 'PassResetTokenWasSent!')
					) {
						console.log("Success");

						//sync tokens received:
						this.unique_id = this.serverSyncModel.unique_tenant_id;
						if (this.reset_email !== this.serverSyncModel.tenant_email) {
							this.reset_email = this.serverSyncModel.tenant_email;
						}

						//Persist Tokens to local: This will be cleared later when the password is reset...
						this.PersistTokensToLocal();

						//update state:
						this.update_success = true;
						//call reactors:
						this.UpdateUI();
					}
					else if
						(
						(this.serverSyncModel.code === 0) /*&&
						(this.serverSyncModel.serverStatus === 'PassResetTokenNotSent!')*/
					) {
						//escape this and throw error to be handled by catch block
						throw new Error(this.serverSyncModel.short_description);
					}
				}
				catch (error) {
					//call the tenant server route:
					//sync model:
					this.serverSyncModel = await this.SyncPassResetTokenToLandlordEmailModel();
					if (
						(this.serverSyncModel.code === 1) &&
						(this.serverSyncModel.serverStatus === 'PassResetTokenWasSent!')
					) {
						console.log("Success");

						//sync tokens received:
						this.unique_id = this.serverSyncModel.unique_landlord_id;
						if (this.reset_email !== this.serverSyncModel.landlord_email) {
							this.reset_email = this.serverSyncModel.landlord_email;
						}

						//Persist Tokens to local: This will be cleared later when the password is reset...
						this.PersistTokensToLocal();

						//update state:
						this.update_success = true;
						//call reactors:
						this.UpdateUI();
					}
					else if
						(
						(this.serverSyncModel.code === 0) &&
						(this.serverSyncModel.serverStatus === 'PassResetTokenNotSent!')
					) {
						//update state:
						this.clicked_state = false;
						this.update_success = false;
						//call reactors:
						this.LoadingUI();
						this.UpdateUI();
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
		$('div#resetLoadingIcon').hide();
		$('div#errorSuccessNotify').hide();
		$('div#forgotPassFlow2').hide();
	},

	Collectibles() {
		this.reset_email = $('input#resetEmail').val();
	},

	async SyncPassResetTokenToTenantEmailModel() {
		let method = "PATCH";
		let sendMailTenantServerUrl = Env.TenantBaseAPI + 'auth/guest/send/reset/password/token';

		//console.log("My email", this.reset_email);
		//prepare the JSON model:
		let jsonRequestModel =
		{
			'tenant_email': this.reset_email,
		}

		let serverModel = await AbstractModel(method, sendMailTenantServerUrl, jsonRequestModel);

		return serverModel;
		//this.serverSyncModel = serverModel;
	},


	async SyncPassResetTokenToLandlordEmailModel() {
		let method = "PATCH";
		let sendMailLandlordServerUrl = Env.LandlordBaseAPI + 'auth/guest/send/reset/password/token';

		//console.log("My email", this.reset_email);
		//prepare the JSON model:
		let jsonRequestModel =
		{
			'landlord_email': this.reset_email,
		}

		let serverModel = await AbstractModel(method, sendMailLandlordServerUrl, jsonRequestModel);

		return serverModel;
		//this.serverSyncModel = serverModel;
	},

	PersistTokensToLocal() {
		//persist into the local storage:
		window.localStorage.setItem('uniqueTenantID', this.unique_id);
		window.localStorage.setItem('resetEmail', this.reset_email);
	},

	LoadingUI() {
		if (this.clicked_state) {
			//show and clean:
			$('div#resetLoadingIcon').show();
			$('div#resetLoadingIcon').empty();

			//populate:
			$('div#resetLoadingIcon').html(
				`<div class="spinner-border text-success w3-lime" role="status">
					<span class="sr-only">Loading...</span>
				</div>`
			);
		}
		else if (!this.clicked_state) {
			$('div#resetLoadingIcon').hide();
			$('div#errorSuccessNotify').hide();
		}
	},

	UpdateUI() {
		if (this.update_success) {

			$('div#sendRequestBtn').hide();
			$('div#errorSuccessNotify').show();
			$('div#errorSuccessNotify').text('');
			$('div#errorSuccessNotify').text('Password Reset Token Sent! Redirecting...');

			//now, hide this view and change the view to Flow2:
			$('div#forgotPassFlow1').hide();
			$('div#forgotPassFlow2').show();
		}
		else if (!this.update_success) {
			//clear first:
			$('div#redirectLoginNotify').hide();

			$('div#errorSuccessNotify').show();
			$('div#errorSuccessNotify').text('Error! Password Reset Token Not Sent!');
		}
	},

	HandleOtherUnexpectedErrors(errorMessage = 'Error! Not Found!') {
		$('div#resetLoadingIcon').hide();
		$('div#errorSuccessNotify').show();
		$('div#errorSuccessNotify').text('');
		$('div#errorSuccessNotify').text(errorMessage);
	},

	RedirectToLogin() {

		//redirect to dashboard after waiting for 5millisecond:
		setTimeout(() => {
			window.location.replace('./../../Views/Auth/login.html'), 3000
		});
	},
}

//call the object method:
if ($('body#forgotPassPage').val() !== undefined) {
	//console.log("Not Absent")
	TenantLandlordForgotPassword.SendResetPassMail('button#sendRequestBtn');
}


