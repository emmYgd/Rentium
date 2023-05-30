
const TenantLandlordImplementEmailVerify =
{
	//values:
	serverSyncModel: null,
	register_choice: "",
	unique_tenant_id: "",
	unique_landlord_id: "",
	verify_token: "",

	//states:
	clicked_state: false,
	update_success: false,

	async ImplementEmailverify() {
		//initialize:
		this.Init();

		$('button#verifyEmailBtn').click(async (event) => {
			//event.preventDefault();

			this.Collectibles();
			console.log(this.verify_token);

			if (
				(this.verify_token == "" ||
					this.verify_token == null ||
					this.verify_token == undefined
				)
				||
				(this.register_choice == "" ||
					this.register_choice == null ||
					this.register_choice == undefined
				)
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
				this.serverSyncModel = await this.SyncTenantLandlordImplementResetPassModel();

				//now start conditionals:
				if (
					(this.serverSyncModel.code === 1) &&
					(this.serverSyncModel.serverStatus === 'VerifiedSuccess!')
				) {
					console.log("Success");

					//set state to true for watchers
					this.clicked_state = false;
					//UI loading function:
					this.LoadingUI();

					//update state:
					this.update_success = true;
					//call reactors:
					this.UpdateUI();

					//Clear later when the email is verified:
					this.DeleteAllTokensFromLocal();

					//redirect to login Page:
					this.RedirectToLogin();
				}
				else if
					(
					(this.serverSyncModel.code === 0) &&
					(this.serverSyncModel.serverStatus === 'VerifiedFailure!')
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
				}
				else if (this.serverSyncModel.code === 0) {
					console.log("Failure");

					//set state to true for watchers
					this.clicked_state = false;
					//UI loading function:
					this.LoadingUI();

					//update state:
					this.update_success = false;
					//call reactors:
					this.UpdateUI();

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

					//update state:
					this.HandleOtherErrorConditions();

				}
			}
		});
	},

	Init() {
		//test condition:
		//try getting tokens persisted:
		const register_choice = window.localStorage.getItem('register-choice');
		if(!register_choice)
		{
			//redirect to signup:
			this.RedirectToSignUp();
		}

		//hide loading icon:
		$('div#resetLoadingIcon').hide();
		$('div#errorSuccessNotify').hide();
	},

	Collectibles() {
		this.verify_token = $('input.verifyToken').val();
		this.CollectFromLocalPersist();
	},

	CollectFromLocalPersist() {
		//collect persisted tokens to memory
		const register_choice = window.localStorage.getItem('register-choice');
		const unique_tenant_id = window.localStorage.getItem('unique-tenant-id');
		const unique_landlord_id = window.localStorage.getItem('unique-landlord-id');

		//assign:
		this.register_choice = register_choice;

		if (unique_tenant_id) {
			this.unique_tenant_id = unique_tenant_id
		}

		if (unique_landlord_id) {
			this.unique_landlord_id = unique_landlord_id;
		}
	},

	async SyncTenantLandlordImplementResetPassModel() {
		const method = "PUT";
		let verifyServerUrl = "";
		let jsonRequestModel = null;
		if (
			(this.register_choice == 'tenant')
			&&
			(this.unique_tenant_id)
		) {
			verifyServerUrl = Env.TenantBaseAPI + 'auth/verifications/verify';
			//console.log("My email", this.reset_email);
			//prepare the JSON model:
			jsonRequestModel =
			{
				'unique_tenant_id': this.unique_tenant_id,
				'verify_token': this.verify_token,
			}
		}

		if (
			(this.register_choice == 'landlord')
			&&
			(this.unique_landlord_id)
		) {
			verifyServerUrl = Env.LandlordBaseAPI + 'auth/verifications/verify';
			//console.log("My email", this.reset_email);
			//prepare the JSON model:
			jsonRequestModel =
			{
				'unique_landlord_id': this.unique_landlord_id,
				'verify_token': this.verify_token,
			}
		}

		let serverModel = await AbstractModel(method, verifyServerUrl, jsonRequestModel);

		return serverModel;
	},

	DeleteAllTokensFromLocal() {
		window.localStorage.clear();
	},

	LoadingUI() {
		if (this.clicked_state) {
			//show and clean:
			$('div#verifyLoadingIcon').show();
			$('div#verifyLoadingIcon').empty();

			//populate:
			$('div#verifyLoadingIcon').html(
				`<div class="spinner-border text-success w3-lime" role="status">
					<span class="sr-only">Loading...</span>
				</div>`
			);
		}
		else if (!this.clicked_state) {
			$('div#verifyLoadingIcon').hide();
			//$('div#errorSuccessNotify2').hide();
		}
	},

	UpdateUI() {
		if (this.update_success) {
			//hide components:
			$('div#verifyInstructions').hide()
			$('div.form-group').hide();
			
			//show components:
			$('div#errorSuccessNotify').show();
			$('div#errorSuccessNotify').text('');
			$('div#errorSuccessNotify').text('Account Email Verified Successfully! Redirecting to login...');

			//show redirecting loading:
			$('div#verifyLoadingIcon').show();
			$('div#verifyLoadingIcon').empty();

			//populate:
			$('div#verifyLoadingIcon').html(
				`<div class="spinner-border text-success w3-lime" role="status">
					<span class="sr-only">Loading...</span>
				</div>`
			);
		}
		else if (!this.update_success) {
			//clear first:
			$('div#errorSuccessNotify').show();
			$('div#errorSuccessNotify').text('');
			$('div#errorSuccessNotify').text(this.serverSyncModel.short_description);
		}
	},

	HandleOtherErrorConditions()
	{
		//clear first:
		$('div#errorSuccessNotify').show();
		$('div#errorSuccessNotify').text('');
		$('div#errorSuccessNotify').text(this.serverSyncModel.short_description);
	},

	RedirectToLogin() {
		//redirect to login after waiting for 5millisecond:
		setTimeout(() => {
			window.location.replace('./login.html'), 5000
		});
	},

	RedirectToSignUp()
	{
		//redirect to signup after waiting for 5millisecond:
		setTimeout(() => {
			window.location.replace('./signup.html'), 5000
		});
	}
}

//call the object method:
if ($('body#forgotPassPage').val() !== undefined) {
	//console.log("Not Absent")
	//TenantLandlordImplementEmailVerify.Init();
	TenantLandlordImplementEmailVerify.ImplementEmailverify();
}