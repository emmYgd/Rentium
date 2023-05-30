const TenantLogout =
{
    //values:
    serverSyncModel: null,
    unique_tenant_id: "",
    tenant_basic_auth_header_token: "",

    //states:
    clicked_state: false,
    is_all_null: false,
    update_success: false,

    LogoutDashboard(targetClickElem) {
        this.Init();

        $(targetClickElem).click((event) => {
            console.log("Logout Clicked!");

            event.preventDefault();

            this.unique_tenant_id = window.localStorage.getItem('uniqueTenantID');
            this.tenant_basic_auth_header_token = window.localStorage.getItem('tenantBasicAuthHeaderToken');


            //call the server sync:
            this.SyncLogoutModel().then((serverModel) => {
                //sync model:
                this.serverSyncModel = serverModel;
                console.log(this.serverSyncModel);

                //now start conditionals:
                if (
                    (this.serverSyncModel.code === 1) &&
                    (this.serverSyncModel.serverStatus === 'LoggedOut!')
                ) {
                    console.log("Success");

                    //delete all Tokens Received to Local Storage:
                    this.DeleteTokenLocal();

                    this.update_success = true;

                    //now, redirect:
                    this.UpdateUI();
                    this.Redirect();
                }
                else if
                    (
                    (this.serverSyncModel.code === 0) &&
                    (this.serverSyncModel.serverStatus === 'NotLoggedOut!')
                ) {
                    //user is not expecting any error for their own logout...
                    console.log("Error");

                }
            });
        });
    },

    Init() {
        //hide loading icon:
        $('div#redirectLoginNotify').hide();
    },

    SyncLogoutModel() {
        let method = "PUT";
        let logoutServerUrl = Env.TenantBaseAPI + 'auth/logout/dashboard';

        let jsonRequestModel = {
            'unique_tenant_id': this.unique_tenant_id,
        };

        let reqAuthHeader = this.tenant_basic_auth_header_token;

        //console.log("InitJson", jsonRequestModel);

        let serverModel = AbstractModelWithAuthHeader(method, logoutServerUrl, jsonRequestModel, reqAuthHeader);
        return serverModel;
        //this.serverSyncModel = serverModel;
    },

    DeleteTokenLocal() {
        window.localStorage.clear();
    },

    UpdateUI() {

        if (this.update_success) {
            //hide initial components:
            $('div#logoutPrompt').hide();
            $('div.modal-footer').hide();

            //show loading to signify redirecting:
            $('div#redirectLogoutNotify').show();
            $('div#redirectLogoutNotify').empty();

            //inject html elems:
            $('div#redirectLogoutNotify').html(
                `<!-- Warning start -->
				<br/>
				<br/>
				<div class="w3-container w3-card-4 w3-center w3-padding w3-margin w3-round-xxlarge">
					<br/>
					<b class="w3-large"><span class="fa fa-lock"></span> Logging Out!</b>
					<hr class="w3-lime"/>
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

    Redirect() {
        //redirect back to the login page:
        setTimeout(() => {
            window.location.replace(Links.common.login_link)
        }, 3000
        );
    }
}

//call the object method:
if ($('body#dashboardPage').val() !== undefined) {
    TenantLogout.LogoutDashboard('button#logoutBtn');
    console.log("Great One");
}