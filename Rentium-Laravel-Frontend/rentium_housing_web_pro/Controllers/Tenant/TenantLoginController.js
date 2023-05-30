const TenantLogin =
{
	//values:
	serverSyncModel: null,
	tenant_email_or_phone_number: "",
	tenant_password: "",

	//states:
	clicked_state: false,
	is_all_null: false,
	update_success: false,

	LoginDashboard(targetClickElem) {
		//initialize:
		this.Init();

		$(targetClickElem).click((event) => {
			//event.preventDefault();

			this.Collectibles();
			console.log(this.tenant_email_or_phone_number);
			console.log(this.tenant_password);

			if (
				this.tenant_email_or_phone_number == "" ||
				this.tenant_password == ""
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

				//call the server sync:
				this.SyncLoginModel().then((serverModel) => {
					//sync model:
					this.serverSyncModel = serverModel;
					//set state for watchers
					this.clicked_state = false;
					//UI loading function:
					this.LoadingUI();

					//now start conditionals:
					if (
						(this.serverSyncModel.code === 1) &&
						(this.serverSyncModel.serverStatus === 'LoginSuccess!')
					) {
						console.log("Success");

						//save Token Received to Local Storage immediately to sync:
						this.PersistTokensAndStateLocal();

						//update state:
						this.update_success = true;
						//call reactors:
						this.UpdateUI();

						//now, redirect:
						this.RedirectToDashboard();
					}
					else if
						(
						(this.serverSyncModel.code === 0) &&
						(this.serverSyncModel.serverStatus === 'LoginFailure!')
					) {
						console.log("Error");
						//update state:
						this.update_success = false;
						//call reactors:
						this.UpdateUI();
					}
				});
			}
		});
	},

	Init() {
		//hide loading icon:
		$('div#loginLoadingIcon').hide();
		$('div#errorSuccessNotify').hide();
	},

	Collectibles() {
		this.tenant_email_or_phone_number = $('input#emailOrPhoneNumber').val();
		this.tenant_password = $('input#pwd-input').val();
	},

	SyncLoginModel() {
		let method = "PUT";
		let updateServerUrl = Env.TenantBaseAPI + 'auth/dashboard/login';
		//console.log("My email", this.tenant_email);
		//prepare the JSON model:
		let jsonRequestModel =
		{
			'tenant_email_or_phone_number': this.tenant_email_or_phone_number,
			'tenant_password': this.tenant_password,
		}

		let serverModel = AbstractModel(method, updateServerUrl, jsonRequestModel);
		return serverModel;
		//this.serverSyncModel = serverModel;
	},

	/*UpdateIsAllNullUI()
	{
		if(this.is_all_null)
		{
			$('div#errorSuccessNotifyTenantLogin').show();
			$('div#loginFetchSuccess').text('');
			$('div#loginFetchError').text('');
			$('div#loginFetchErrorDetails').text('');

			$('div#loginFetchError').text('Login Error!');
			$('div#loginFetchErrorDetails').text('Please fill up all fields!');
		}
		else if(!this.is_all_null)
		{
			$('div#errorSuccessNotifyTenantLogin').hide();
		}
	},*/

	LoadingUI() {
		if (this.clicked_state) {
			$('div#landlordTenantLoginBtns').hide();
			$('div#loginLoadingIcon').show();
			$('div#loginLoadingIcon').html(
				`<div class="spinner-border text-success w3-lime" role="status">
						<span class="sr-only">Loading...</span>
					</div>`
			);
		}
		else if (!this.clicked_state) {
			$('div#landlordTenantBtns').show();
			$('div#loginLoadingIcon').hide();
		}
	},

	UpdateUI() {
		if (this.update_success) {
			//clear all forms:
			$('form#loginForm').trigger('reset');
			$('input').hide();

			//clear first:
			$('div#errorSuccessNotify').show();
			$('div#errorSuccessNotify').text('');
			$('div#errorSuccessNotify').text('Authenticated! Redirecting to dashboard...');

			//Now show redirecting icon:
			$('div#loginLoadingIcon').show();
			$('div#loginLoadingIcon').empty();
			$('div#loginLoadingIcon').html(
				`<div class="spinner-grow w3-lime" role="status">
					<span class="sr-only">Loading...</span>
				</div>`
			);
		}
		else if (!this.update_success) {
			//clear first:
			$('div#redirectLoginNotify').hide();

			$('div#errorSuccessNotify').show();
			$('div#errorSuccessNotify').text('');

			//Update Error Message:
			//$('div#errorSuccessNotify').text('Login Error!');
			$('div#errorSuccessNotify').text(this.serverSyncModel.short_description);

			//Show Login Buttons again:
			$('div#landlordTenantLoginBtns').show();
		}
	},

	PersistTokensAndStateLocal() {
		//get the 2 tokens received from server: this will help make subsequent calls:
		const uniqueTenantID = this.serverSyncModel.uniqueTenantId;
		const tenantBasicAuthHeaderToken = this.serverSyncModel.authTenantToken;
		//persist into the local storage:
		window.localStorage.setItem('uniqueTenantID', uniqueTenantID);
		window.localStorage.setItem('tenantBasicAuthHeaderToken', tenantBasicAuthHeaderToken);
	},

	RedirectToDashboard() {

		//redirect to dashboard after waiting for 5millisecond:
		setTimeout(
			window.location.replace(Links.dashboard.tenant_dashboard), 10000
		);
	},

}

//call the object method:
if ($('body#loginPage').val() !== undefined) {
	//console.log("Not Absent")
	TenantLogin.LoginDashboard('button#tenantLoginBtn');
}


