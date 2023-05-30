const LandlordRegister =
{
	//init values:
	serverSyncModel: null,
	landlord_full_name: "",
	landlord_email: "",
	landlord_phone_number: "",
	landlord_password: "",

	//states:
	is_all_null: false,
	clicked_state: false,
	update_success: false,

	DisplayFormsOnClick()
	{
		$('button#landlordChoiceRegister').click((event) => 
		{
			$('section#landlordTenantChoiceBtns').hide();
			$('section#landlord-form').show();
			//persist tenant choice to local:
			this.PersistChoiceToLocal();
		});
	},

	RegisterLandlord() {
		//initialize:
		this.Init();

		$('button#registerLandlordBtn').click((event) => {
			
			this.Collectibles();

			if (
				this.landlord_first_name == "" ||
				this.landlord_last_name == "" ||
				this.landlord_email == "" ||
				this.landlord_password == ""
			) {
				//This will be handled by the bootstrap, so, there's no need...
				//console.log("Empty Fields!");
				//this.is_all_null = true;
				//this.UpdateIsAllNullUI();
			}
			else {
				event.preventDefault();
				
				//this.is_all_null = false;
				//this.UpdateIsAllNullUI();

				//set state to true for watchers
				this.clicked_state = true;
				this.LoadingUI();

				//call the server sync:
				this.SyncRegisterModel().then((serverModel) => {
					console.log('Here we are!')
					
					//sync model:
					this.serverSyncModel = serverModel;
					
					//set state for watchers
					this.clicked_state = false;
					//UI loading function:
					this.LoadingUI();

					//now start conditionals:
					if (
						(this.serverSyncModel.code === 1) &&
						(this.serverSyncModel.serverStatus === 'RegisterSuccess!')
					) {
						console.log("Success");
						//save to local:
						this.PersistTokenToLocal();
						//update state:
						this.update_success = true;
						//call reactors:
						this.UpdateUI();
					}
					else if
						(
						(this.serverSyncModel.code === 0) &&
						(this.serverSyncModel.serverStatus === 'RegisterFailure!')
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

	Init()
	{
		//console.log("Init!");
		//hide sections, loading and notification icons:
		$('section#landlord-form').hide();
		$('section#tenant-form').hide();
		$('div#registerLoadingIcon').hide();
		$('div#errorSuccessNotify').hide();
	},

	PersistChoiceToLocal() {
		//clear local storage first:
		window.localStorage.clear();
		//persist choice to the local storage:
		window.localStorage.setItem('register-choice', 'landlord');
	},

	PersistTokenToLocal()
	{
		window.localStorage.setItem('unique-landlord-id', this.serverSyncModel.unique_landlord_id);
	},

	Collectibles() {
		this.landlord_full_name = $('input#landlordFullName').val();
		this.landlord_email = $('input#landlordEmail').val();
		this.landlord_phone_number = $('input#landlordPhoneNumber').val();
		this.landlord_password = $('input.landlordPassword').val();
	},

	/*UpdateIsAllNullUI() {
		if (this.is_all_null) {
			$('div#errorSuccessNotifylandlordRegister').show();
			$('div#registerFetchSuccess').text('');
			$('div#registerFetchError').text('');
			$('div#registerFetchErrorDetails').text('');

			$('div#registerFetchError').text('Registration Error!');
			$('div#registerFetchErrorDetails').text('Please fill up all non-optional fields!');
		}
		else if (!this.is_all_null) {
			$('div#errorSuccessNotifylandlordRegister').hide();
		}
	},*/

	LoadingUI() {
		if (this.clicked_state) {
			$('button#registerLandlordBtn').hide();
			$('div#registerLoadingIcon').show();
			$('div#registerLoadingIcon').html(
				`<div class="spinner-grow w3-lime" role="status">
					<span class="sr-only">Loading...</span>
				</div>`
			);
		}
		if (!this.clicked_state) {
			$('buttomn#registerLandlordBtn').show();
			$('div#registerLoadingIcon').hide();
		}
	},

	SyncRegisterModel() {
		let method = "POST";
		let updateServerUrl = Env.LandlordBaseAPI + 'auth/register';
		//prepare the JSON model:
		let jsonRequestModel =
		{
			'landlord_full_name': this.landlord_full_name,
			'landlord_email': this.landlord_email,
			'landlord_phone_number': this.landlord_phone_number,
			'landlord_password': this.landlord_password,
		}

		const serverModel = AbstractModel(method, updateServerUrl, jsonRequestModel);
		console.log(serverModel);

		return serverModel;
		//this.serverSyncModel = serverModel;
	},

	UpdateUI() {
		if (this.update_success) {
			//clear all forms:
			$('form#registerForm').trigger('reset');

			//remove the buttons:
			$('button#registerLandlordBtns').hide();

			//show first:
			$('div#errorSuccessNotify').show();
			
			//Update Success Message:
			$('div#errorSuccessNotify').empty();
			$('div#errorSuccessNotify').html(
				`<b>
					Details Saved! 
					<br/> 
					Continue to Verify
					<span class='fa fa-arrow-circle-down'></span> 
				</b>`
			);

			//Update with the server verification message prompt:
			$('div#loginVerifyMessage').text('');
			$('div#loginVerifyMessage').text(this.serverSyncModel.short_description);

			//remove the login text, replace with button:
			$('a#redirectToAnotherPage').attr('href', './email-verification.html');
			$('a#redirectToAnotherPage').empty();
			$('a#redirectToAnotherPage').html(
				`<span class="fa fa-sync"></span> 
				<b>Verify</b>
				`
			);
		}

		if (!this.update_success) {
			//$('form#registerForm').trigger('reset');
			//clear first:
			$('button#registerLandlordBtn').show();
			$('div#errorSuccessNotify').show();
			
			//Update Error Message:
			$('div#errorSuccessNotify').empty();
			
			if (this.serverSyncModel.warning !== undefined) 
			{
				$('div#errorSuccessNotify').text(this.serverSyncModel.warning);
			}
			else 
			{
				$('div#errorSuccessNotify').text(this.serverSyncModel.short_description);
			}
		}
	},

}

//call the object method:
if ($('body#registerPage').val() !== undefined) {
	LandlordRegister.Init();
	LandlordRegister.DisplayFormsOnClick();
	LandlordRegister.RegisterLandlord();
}




