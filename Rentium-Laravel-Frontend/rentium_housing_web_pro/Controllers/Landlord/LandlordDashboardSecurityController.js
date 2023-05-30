//safe-guards the dashboard:
const LandlordDashboardSecurity =
{
	server_confirm_model: null,
	unique_landlord_id: null,
	landlord_basic_auth_header_token: null,
	server_confirm_model: null,

	confirmed: true,

	SecureDashboard() {
		//console.log("Hihi")
		this.Init();
		this.EnsureLoginFrontend();
		if(this.confirmed)
		{
			this.EnsureLoginBackend();
		}
		else{
			this.UpdateUI();
			this.Redirect();
		}
	},

	Init() {
		//Hide Loading and notification icons:
		$('section#notifySection').hide();

		//get landlord id and bearer token:
		this.unique_landlord_id = window.localStorage.getItem('uniqueLandlordID');
		this.landlord_basic_auth_header_token = window.localStorage.getItem('landlordBasicAuthHeaderToken');
		console.log(this.unique_landlord_id);
		console.log(this.landlord_basic_auth_header_token);
	},

	//By first checking their local storage ID:
	EnsureLoginFrontend() {
		//console.log("I am here!");
		//if id is empty and token are empty, redirect to login:
		if (
			(this.unique_landlord_id === undefined ||
				this.unique_landlord_id === null ||
				this.unique_landlord_id === "")
			&&
			(this.landlord_basic_auth_header_token === undefined ||
				this.landlord_basic_auth_header_token === null ||
				this.landlord_basic_auth_header_token === "")
		) {
			//window.location.replace('login.html');
			//console.log("Absent")
			this.confirmed = false;
		}

		//if all tokens are not empty->continue...
		//this.confirmed = ;
	},

	async EnsureLoginBackend() {
		let method = "PATCH";
		let confirmServerUrl = Env.LandlordBaseAPI + 'auth/confirm/login/state';

		let jsonRequestModel = {
			'unique_landlord_id': this.unique_landlord_id,
		};

		let reqAuthHeader = this.landlord_basic_auth_header_token;

		//console.log("InitJson", jsonRequestModel);

		let serverModel = await AbstractModelWithAuthHeader(method, confirmServerUrl, jsonRequestModel, reqAuthHeader);
		console.log("SyncModel", serverModel);

		this.server_confirm_model = serverModel;
		//console.log("ConfirmModel", this.server_confirm_model);

		//if it isn't logged in on the server:
		if (
			(this.server_confirm_model.code == 0) &&
			(this.server_confirm_model.serverStatus == "ConfirmationFailure!")
		) {
			this.confirmed = false;
			this.UpdateUI();
			this.Redirect();
		}
		//else:
		//otherwise continue...*/
	},

	UpdateUI() {

		if (!this.confirmed) {
			//hide all page elems:
			$('section.user-dashboard').hide();
			//show modal to signify redirecting:
			$('section#notifySection').show();
			$('section#notifySection').empty();
			//inject html elems:
			$('section#notifySection').html(
				`<!-- Warning start -->
				<br/>
				<br/>
				<div class="w3-container w3-card-4 w3-center w3-padding w3-margin w3-round-xxlarge">
					<br/>
					<b class="w3-large"><span class="fa fa-door-closed"></span> You're not Authenticated!</b>
					<hr class="w3-lime"/>
					<div>
						<h5>You are not logged in yet. Please log in to continue with the dashboard!</h5>
					</div>
					<br/>
					<div class="spinner-border w3-lime" role="status">
						<span class="sr-only">Loading...</span>
					</div>
					<div><h5><b>Redirecting...</b></h5></div>
					<br/>
					<br/>
				</div>
				<!-- Warning ends -->`
			);
		}
	},

	Redirect()
	{
		//redirect back to the login page:
		setTimeout(() => {
			window.location.replace(Links.common.login_link);
		}, 3000
		);
	}
}

//call the object method:
if ($('body#dashboardPage').val() !== undefined) {
	//console.log("Not Absent")
	LandlordDashboardSecurity.SecureDashboard();
}




