<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware(["auth:sanctum"])->get("/user", function (Request $request) 
{
    return $request->user();//returns authenticated user using the laravel sanctum...
});*/


//Tenant Auth:
Route::prefix("v1/tenant/")->group(function () {

	Route::middleware("TenantCleanNullRecords")->group(function () {

		Route::prefix("auth/")->group(function () {
			$common_auth_controller_url = "App\Http\Controllers\Tenant\TenantAccessController";

			Route::post("register", [
				"as" => "tenant.register",
				//"middleware" => "",
				"uses" => "{$common_auth_controller_url}@Register"
			]);

			Route::put("dashboard/login", [
				"as" => "tenant.login",
				//"middleware" => "",
				"uses" => "{$common_auth_controller_url}@LoginDashboard"
			]);

			Route::patch("confirm/login/state", [
				"as" => "tenant.confirm.login.state",
				"middleware" => [/*"auth:sanctum", "ability:tenant-crud"*/],
				"uses" => "{$common_auth_controller_url}@ConfirmLoginState"
			]);

			Route::put("verifications/verify", [
				"as" => "tenant.verify",
				"middleware" => ["TenantEnsureLogoutState", /*"throttle:6,1"*/],
				"uses" => "{$common_auth_controller_url}@VerifyAccount"
			]);

			Route::put("logout/dashboard", [
				"as" => "tenant.logout",
				"middleware" => ["TenantConfirmLoginState", "TenantDestroyTokenAfterLogout", /*"auth:sanctum", "ability:tenant-crud"*/],
				"uses" => "{$common_auth_controller_url}@Logout"
			]);

			//This is only for guests: send the password reset link to the tenant gmail:
			Route::patch("guest/send/reset/password/token", [
				"as" => "tenant.send.password.reset.token",
				"middleware" => ["TenantEnsureLogoutState", "guest"],
				"uses" => "{$common_auth_controller_url}@SendPassordResetToken"
			]);

			//This option will be presented to the guest: 
			Route::patch("guest/reset/password", [
				"as" => "tenant.reset.password",
				"middleware" => ["TenantEnsureLogoutState", "guest"],
				"uses" => "{$common_auth_controller_url}@ImplementResetPassword"
			]);
		});
	});

	Route::prefix("searches/")->group(function () {
		$common_house_fetch_controller_url = "App\Http\Controllers\Tenant\TenantHouseFetchDetailsController";

		//all housefetchs to allow for frontend complex search by the JS dev:
		Route::get("fetch/available/propertys/by/category", [
			"as" => "tenant.fetch.all.propertys",
			//"middleware" => "init",
			"uses" => "{$common_house_fetch_controller_url}@FetchAllHousingDetailsByCategory"
		]);

		/*housefetchs search by specific category, the search here is just simple one-keyword search, 
		the JS frontend can perform most of the complex queries:*/
		Route::get("fetch/each/property/details/", [
			"as" => "tenant.fetch.each.property",
			//"middleware" => "init",
			"uses" => "{$common_house_fetch_controller_url}@FetchEachHousingDetails"
		]);

		Route::prefix("dashboard/")->middleware(["auth:sanctum", "ability:tenant-crud", "TenantConfirmLoginState", "TenantConfirmVerifyState"])->group(function () {
			$common_house_fetch_controller_url = "App\Http\Controllers\Tenant\TenantHouseFetchDetailsController";

			Route::get("fetch/all/landords/summary", [
				"as" => "tenant.fetch.all.landlords",
				//"middleware" => "",
				"uses" => "{$common_house_fetch_controller_url}@FetchAllLandlordSummary"
			]);

			Route::post("fetch/each/landlord/detail", [
				"as" => "tenant.fetch.specific.landlord",
				//"middleware" => [],
				"uses" => "{$common_house_fetch_controller_url}@SearchForLandlord"
			]);

			Route::post("fetch/all/landlord/invitations", [
				"as" => "tenant.fetch.all.invitations",
				//"middleware" => "",
				"uses" => "{$common_house_fetch_controller_url}@SearchAllPropertyInvitations"
			]);

			Route::post("fetch/each/landlord/invitation", [
				"as" => "tenant.fetch.each.invitation",
				//"middleware" => ,
				"uses" => "{$common_house_fetch_controller_url}@SearchEachPropertyInvitation"
			]);

			Route::post("fetch/all/own/requests/made", [
				"as" => "tenant.fetch.all.own.requests",
				//"middleware" => "",
				"uses" => "{$common_house_fetch_controller_url}@SearchAllPropertyRequests"
			]);

			Route::post("fetch/each/own/request/made", [
				"as" => "tenant.fetch.each.own.request",
				//"middleware" => "",
				"uses" => "{$common_house_fetch_controller_url}@SearchEachPropertyRequest"
			]);
		});
	});


	Route::prefix("actions/")->group(function () {
		Route::prefix("dashboard/")->middleware(["auth:sanctum", "ability:tenant-crud", "TenantConfirmLoginState", "TenantConfirmVerifyState"])->group(function () {
			$common_house_action_controller_url = "App\Http\Controllers\Tenant\TenantToLandlordInteractionsController";
			//$common_landlord_action_controller_url = "App\Http\Controllers\Tenant\TenantToLandlordInteractionsController";

			//all housefetchs to allow for frontend complex search by the JS dev:
			Route::put("show/interest/in/property/invitations", [
				"as" => "tenant.show.invitation.interest",
				//"middleware" => "init",
				"uses" => "{$common_house_action_controller_url}@ShowInterestInPropertyInvitations"
			]);

			Route::post("make/property/request", [
				"as" => "tenant.make.property.request",
				//"middleware" => "init",
				"uses" => "{$common_house_action_controller_url}@MakePropertyRequest"
			]);

			Route::delete("delete/each/property/request", [
				"as" => "tenant.delete.each.property.request",
				//"middleware" => "init",
				"uses" => "{$common_house_action_controller_url}@DeleteEachPropertyRequest"
			]);

			Route::put("approve/disapprove/property/after/inspection", [
				"as" => "tenant.approve.disapprove.house.after.inspection",
				//"middleware" => "init",
				"uses" => "{$common_house_action_controller_url}@(Dis)ApproveProperyAfterInspection"
			]);
		});
	});


	//Profile:	
	Route::prefix("utils/dashboard/")->middleware(["auth:sanctum", "ability:tenant-crud", "TenantConfirmLoginState", "TenantConfirmVerifyState"])->group(function () {
		Route::prefix("profile/")->group(function () {
			$common_profile_controller_url = "App\Http\Controllers\Tenant\TenantProfileController";

			//This option will be presented to the already logged in user: 
			Route::put("authenticated/change/password", [
				"as" => "tenant.auth.change.password",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@ChangePassword"
			]);

			Route::put("edit/profile", [
				"as" => "tenant.edit.profile",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@EditProfile"
			]);

			//optional pictures:
			Route::put("edit/image", [
				"as" => "tenant.edit.profile.image",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@EditImage"
			]);

			Route::delete("delete/profile", [
				"as" => "tenant.delete.profile",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@DeleteProfile"
			]);
		});


		Route::prefix("comments_ratings/")->group(function () {
			$common_comments_ratings_controller_url = "App\Http\Controllers\Tenant\TenantSocialCommentsAndRatingsController";

			Route::get("upload/commments/ratings", [
				"as" => "tenant.upload.comments.ratings",
				//"middleware" => "init",
				"uses" => "{$common_comments_ratings_controller_url}@CommentsAndRatings"
			]);

			Route::get("view/others/tenants/comments/ratings", [
				"as" => "tenant.view.other.tenants.comments.ratings",
				//"middleware" => "init",
				"uses" => "{$common_comments_ratings_controller_url}@ViewOtherTenantsCommentsRatingsOnLandlord"
			]);
		});


		Route::prefix("payments/")->group(function () {
			$common_payment_controller_url = "App\Http\Controllers\Tenant\TenantPaymentController";
			$common_payment_execution_controller_url = "App\Http\Controllers\Tenant\TenantPaymentExecuteController";

			Route::post("upload/bank/account/details", [
				"as" => "tenant.upload.bank.account.details",
				//"middleware" => "init",
				"uses" => "{$common_payment_controller_url}@UploadBankAccountDetails"
			]);

			Route::post("upload/bank/card/details", [
				"as" => "tenant.upload.debit.card.details",
				//"middleware" => "init",
				"uses" => "{$common_payment_controller_url}@UploadCardDetails"
			]);

			Route::get("fetch/bank/account/details", [
				"as" => "tenant.fetch.bank.account.details",
				//"middleware" => "init",
				"uses" => "{$common_payment_controller_url}@FetchBankAccountDetails"
			]);

			Route::get("fetch/bank/card/details", [
				"as" => "tenant.fetch.debit.card.details",
				//"middleware" => "init",
				"uses" => "{$common_payment_controller_url}@FetchBankCardDetails"
			]);

			Route::post("make/payment/by/new/account/details", [
				"as" => "tenant.pay.by.new.bank.account",
				//"middleware" => "init",
				"uses" => "{$common_payment_execution_controller_url}@MakePaymentByNewBankAccount"
			]);

			Route::post("make/payment/by/new/card/details", [
				"as" => "tenant.pay.by.new.debit.card",
				//"middleware" => "init",
				"uses" => "{$common_payment_execution_controller_url}@MakePaymentByNewBankCard"
			]);

			Route::post("make/payment/by/saved/account/details", [
				"as" => "tenant.pay.by.saved.bank.account",
				//"middleware" => "init",
				"uses" => "{$common_payment_execution_controller_url}@MakePaymentBySavedBankAccount"
			]);

			Route::post("make/payment/by/saved/card/details", [
				"as" => "tenant.pay.by.saved.debit.card",
				//"middleware" => "init",
				"uses" => "{$common_payment_execution_controller_url}@MakePaymentBySavedBankCard"
			]);

			/*This will be used in future for crypto:*/

			//This will be for later - an option to use the crypto wallet payment option:
			/*Route::post("upload/crypto/wallet/details", [
					"as" => "tenant.upload.crypto.wallet.details", 
					//"middleware" => "init",
					"uses" => "UploadCryptoWalletDetails"
				]);

				Route::post("fetch/crypto/wallet/details", [
					"as" => "tenant.fetch.crypto.wallet.details", 
					//"middleware" => "init",
					"uses" => "FetchCryptoWalletDetails"
				]);*/

			/*Route::post("make/payment/with/new/crypto/wallet/details", [
					//"as" => "tenant.pay.with.new.crypto",
					//"middleware" => "init",
					"uses" => "{$common_payment_execution_controller_url}@MakePaymentWithNewCrypto"
				]);

				Route::post("make/payment/with/saved/crypto/wallet/details", [
					//"as" => "tenant.pay.with.saved.crypto",
					//"middleware" => "init",
					"uses" => "{$common_payment_execution_controller_url}@MakePaymentWithSavedCrypto"
				]);

				/*Route::get("view/all/payment/history", [
				"as" => "tenant.payment.history",
				//"middleware" => "init",
				"uses" => "ViewPaymentHistory"
			]);
			*/
		});


		Route::prefix("social/")->group(function () {
			Route::prefix("messaging/")->group(function () {
				$common_contact_controller_url = "App\Http\Controllers\Tenant\TenantSocialContactController";

				Route::post("send/admin/message", [
					"as" => "tenant.message.admin",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@SendAdminMessage"
				]);

				Route::post("send/landlord/message", [
					"as" => "tenant.message.landlord",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@SendLandlordMessage"
				]);

				Route::get("fetch/all/admin/messages", [
					"as" => "tenant.read.all.admin.messages",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@ReadAllAdminMessages"
				]);

				Route::get("fetch/all/landlord/messages", [
					"as" => "tenant.read.all.landlord.messages",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@ReadAllLandlordMessages"
				]);

				Route::get("fetch/all/sent/messages", [
					"as" => "admin.read.all.sent.messages",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@ReadAllSentMessages"
				]);
			});

			Route::prefix("referral/")->group(function () {
				$common_referral_controller_url = "App\Http\Controllers\Tenant\TenantSocialReferralController";

				Route::post("generate/unique/referral/link", [
					"as" => "tenant.generate.referral.link",
					//"middleware" => "init",
					"uses" => "{$common_referral_controller_url}@GenerateUniqueReferralLink"
				]);

				Route::get("get/referral/bonus", [
					"as" => "tenant.get.referral.bonus",
					//"middleware" => "init",
					"uses" => "{$common_referral_controller_url}@GetReferralBonus"
				]);

				Route::put("use/referral/link", [
					"as" => "tenant.use.referral.link",
					//"middleware" => "init",
					"uses" => "{$common_referral_controller_url}@UseReferralLink"
				]);
			});

			/*Route::prefix("wishlist/")->middleware("DeleteEmptyWishlists")->group(function()
			{
				$common_wishlist_controller_url = "App\Http\Controllers\Tenant\TenantWishlistEditController";
				$common_wishlist_fetch_controller_url = "App\Http\Controllers\Tenant\TenantWishlistFetchController";

					Route::post("add/propertys/to/wishlist", [
						"as" => "add.property.to.wishlist", 
						//"middleware" => "",
						"uses" => "{$common_wishlist_controller_url}@AddPropertysToWishList"
					]);

					//This will been handled fully on frontend:
					Route::patch("edit/existing/wishlist", [
						"as" => "edit.existing.wishlist", 
						"middleware" => "",
						"uses" => "{$common_wishlist_controller_url}@EditPropertysOnWishlist"
					]);

					//this will be handled fully on frontend:
					Route::delete("delete/wishlist", [
						"as" => "delete.wishlist", 
						"middleware" => "",
						"uses" => "{$common_wishlist_controller_url}@DeleteWishlist"
					]);

					//this will be handled fully on frontend:
					Route::post("bulk/pay/for/all/wishlists", [
						"as" => "pay.bulk.for.wishlists", 
						"middleware" => "",
						"uses" => "{$common_wishlist_controller_url}@ClearAllWishlists"
					]);

					Route::get("fetch/all/wishlists/summary", [
						"as" => "all.wishlists.summary", 
						//"middleware" => "",
						"uses" => "{$common_wishlist_controller_url}@FetchAllWishlistsSummary"
					]);

					Route::get("fetch/each/wishlist/details", [
						"as" => "each.wishlist.details", 
						//"middleware" => "",
						"uses" => "{$common_wishlist_controller_url}@FetchEachWishlistDetails"
					]);
				});
			});*/
		});
	});
});


//Landlord Auth:
Route::prefix("v1/landlord/")->group(function () {

	Route::middleware("LandlordCleanNullRecords")->group(function () {
		Route::prefix("auth/")->group(function () {
			$common_auth_controller_url = "App\Http\Controllers\Landlord\LandlordAccessController";

			Route::post("register", [
				"as" => "landlord.register",
				//"middleware" => "",
				"uses" => "{$common_auth_controller_url}@Register"
			]);

			Route::put("login/dashboard", [
				"as" => "landlord.login",
				//"middleware" => "",
				"uses" => "{$common_auth_controller_url}@LoginDashboard"
			]);

			Route::patch("confirm/login/state", [
				"as" => "landlord.confirm.login.state",
				"middleware" => [/*"auth:sanctum", "ability:landlord-crud"*/],
				"uses" => "{$common_auth_controller_url}@ConfirmLoginState"
			]);

			Route::put("verifications/verify", [
				"as" => "landlord.verify",
			"middleware" => ["LandlordEnsureLogoutState", /*"throttle:6,1"*/],
				"uses" => "{$common_auth_controller_url}@VerifyAccount"
			]);

			Route::put("logout/dashboard", [
				"as" => "landlord.logout",
				"middleware" => ["LandlordConfirmLoginState", "LandlordDestroyTokenAfterLogout", /*"auth:sanctum", "ability:landlord-crud"*/],
				"uses" => "{$common_auth_controller_url}@Logout"
			]);

			//This is only for guests: send the password reset link to the landlord gmail:
			Route::patch("guest/send/reset/password/token", [
				"as" => "landlord.send.password.reset.token",
				"middleware" => ["LandlordEnsureLogoutState", "guest"],
				"uses" => "{$common_auth_controller_url}@SendPassordResetToken"
			]);

			//This option will be presented to the guest: 
			Route::patch("guest/reset/password", [
				"as" => "landlord.reset.password",
				//"middleware" => ["LandlordEnsureLogoutState", "guest"],
				"uses" => "{$common_auth_controller_url}@ImplementResetPassword"
			]);
		});
	});


	Route::prefix("searches/")->group(function () {
		Route::prefix("dashboard/")->middleware(["auth:sanctum", "ability:landlord-crud", "LandlordConfirmLoginState", "LandlordConfirmVerifyState"])->group(function () {

			$common_landlord_fetch_controller_url = "App\Http\Controllers\Landlord\LandlordHouseFetchDetailsController";
			$common_landlord_house_tenant_controller_url = "App\Http\Controllers\Landlord\LandlordToTenantInteractionsController";

			Route::get("fetch/all/own/propertys/summary", [
				"as" => "fetch.all.own.propertys",
				//"middleware" => "init",
				"uses" => "{$common_landlord_fetch_controller_url}@FetchAllOwnHouseDetailsSummary"
			]);

			Route::get("fetch/each/own/property/detail", [
				"as" => "fetch.each.own.property",
				//"middleware" => "init",
				"uses" => "{$common_landlord_fetch_controller_url}@FetchEachHousingDetails"
			]);

			Route::get("fetch/all/tenants/summary", [
				"as" => "landlord.fetch.all.tenants",
				//"middleware" => "",
				"uses" => "{$common_landlord_house_tenant_controller_url}@FetchAllTenantsSummary"
			]);

			Route::get("fetch/each/tenant/detail", [
				"as" => "landlord.fetch.each.tenant.detail",
				//"middleware" => "",
				"uses" => "{$common_landlord_house_tenant_controller_url}@SearchForTenant"
			]);

			Route::get("fetch/all/tenant/property/requests/summary", [
				"as" => "landlord.fetch.all.property.requests",
				//"middleware" => [],
				"uses" => "{$common_landlord_fetch_controller_url}@ViewAllPropertyRequestsSummary"
			]);

			Route::get("fetch/each/tenant/property/request/details", [
				"as" => "landlord.fetch.each.property.request",
				//"middleware" => [],
				"uses" => "{$common_landlord_fetch_controller_url}@ViewTenantPropertyRequests"
			]);

			Route::get("fetch/all/landlord/own/invitations/summary", [
				"as" => "landlord.fetch.all.own.invitations",
				//"middleware" => "",
				"uses" => "{$common_landlord_fetch_controller_url}@ViewAllOwnPropertyInvitations"
			]);

			Route::get("fetch/each/landlord/own/invitation/detail", [
				"as" => "landlord.fetch.each.invitation",
				//"middleware" => ,
				"uses" => "{$common_landlord_fetch_controller_url}@ViewEachPropertyInvitation"
			]);
		});
	});


	Route::prefix("actions/")->group(function () {
		Route::prefix("dashboard/")->middleware(["auth:sanctum", "ability:landlord-crud", "LandlordConfirmLoginState", "LandlordConfirmVerifyState"])->group(function () {
			$common_house_action_controller_url = "App\Http\Controllers\Landlord\LandlordToTenantInteractionsController";
			//$common_landlord_action_controller_url = "App\Http\Controllers\Landlord\LandlordToLandlordInteractionsController";
			$common_inspection_schedule_controller_url = "App\Http\Controllers\Landlord\LandlordInspectionAppointmentController";

			//all housefetchs to allow for frontend complex search by the JS dev:
			Route::post("send/property/invitations", [
				"as" => "landlord.send.property.invitation",
				//"middleware" => "init",
				"uses" => "{$common_house_action_controller_url}@SendPropertyInvite"
			]);

			Route::delete("delete/property/invitation", [
				"as" => "landlord.delete.each.property.invitation",
				//"middleware" => "init",
				"uses" => "{$common_house_action_controller_url}@DeleteEachPropertyInvite"
			]);

			Route::put("reject/or/approve/property/request", [
				"as" => "landlord.reject.or.approve.property.request",
				//"middleware" => "init",
				"uses" => "{$common_house_action_controller_url}@ApproveRejectTenantRequests"
			]);

			Route::post("schedule/inspection/appointment/for/landlord/invitation", [
				"as" => "landlord.schedule.appointment.for.invitation",
				//"middleware" => "init",
				"uses" => "{$common_inspection_schedule_controller_url}@ScheduleInspectionAppointmentForLandlordInvitation"
			]);

			Route::post("schedule/inspection/appointment/for/tenant/request", [
				"as" => "landlord.schedule.appointment.for.request",
				//"middleware" => "init",
				"uses" => "{$common_inspection_schedule_controller_url}@ScheduleInspectionAppointmentForTenantRequest"
			]);

			Route::get("view/all/inspection/appointment/schedules", [
				"as" => "landlord.all.inspection.appointments",
				//"middleware" => "init",
				"uses" => "{$common_inspection_schedule_controller_url}@ViewAllInspectionAppointmentSchedules"
			]);

			Route::delete("delete/inspection/appointment/schedule", [
				"as" => "delete.inspection.appointment",
				//"middleware" => "init",
				"uses" => "{$common_inspection_schedule_controller_url}@DeleteInspectionAppointmentSchedule"
			]);
		});

		Route::prefix("uploads/")->group(function () {
			Route::prefix("dashboard/")->middleware(["auth:sanctum", "ability:landlord-crud", "LandlordConfirmLoginState", "LandlordConfirmVerifyState"])->group(function () {
				$common_house_uploads_controller_url = "App\Http\Controllers\Landlord\LandlordHouseUploadDetailsController";
				$common_house_edits_controller_url = "App\Http\Controllers\Landlord\LandlordHouseEditDetailsController";
				$common_house_delete_controller_url = "App\Http\Controllers\Landlord\LandlordHouseDeleteDetailsController";

				Route::post("property/upload/text/details", [
					"as" => "landlord.upload.property.texts",
					//"middleware" => "init",
					"uses" => "{$common_house_uploads_controller_url}@UploadHouseTextDetails"
				]);

				Route::post("property/upload/image/details", [
					"as" => "landlord.upload.property.images",
					//"middleware" => "init",
					"uses" => "{$common_house_uploads_controller_url}@UploadHouseImageDetails"
				]);

				Route::post("property/upload/clip/details", [
					"as" => "landlord.upload.property.clip",
					//"middleware" => "init",
					"uses" => "{$common_house_uploads_controller_url}@UploadHouseClip"
				]);

				Route::patch("property/edit/text/details", [
					"as" => "landlord.edit.property.text",
					//"middleware" => "init",
					"uses" => "{$common_house_edits_controller_url}@EditHouseTextDetails"
				]);

				Route::patch("property/edit/image/details", [
					"as" => "landlord.edit.property.images",
					//"middleware" => "init",
					"uses" => "{$common_house_edits_controller_url}@EditHouseImageDetails"
				]);

				Route::patch("property/edit/clip/details", [
					"as" => "landlord.edit.property.clip",
					//"middleware" => "init",
					"uses" => "{$common_house_edits_controller_url}@EditHouseClip"
				]);

				Route::delete("property/delete/all/own/details", [
					"as" => "landlord.delete.all.own.properties",
					//"middleware" => "init",
					"uses" => "{$common_house_delete_controller_url}@DeleteAllPropertyRecords"
				]);

				Route::delete("property/delete/specific/own/detail", [
					"as" => "landlord.delete.specific.own.property",
					//"middleware" => "init",
					"uses" => "{$common_house_delete_controller_url}@DeleteSpecificHouseDetails"
				]);
			});
		});
	});


	//Profile:	
	Route::prefix("utils/dashboard/")->middleware(["auth:sanctum", "ability:landlord-crud", "LandlordConfirmLoginState", "LandlordConfirmVerifyState"])->group(function () {
		Route::prefix("profile/")->group(function () {
			$common_profile_controller_url = "App\Http\Controllers\Landlord\LandlordProfileController";

			//This option will be presented to the already logged in user: 
			Route::put("authenticated/change/password", [
				"as" => "landlord.auth.change.password",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@ChangePassword"
			]);

			Route::put("edit/profile/details", [
				"as" => "landlord.edit.profile",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@EditProfile"
			]);

			//optional pictures:
			Route::put("edit/profile/image", [
				"as" => "landlord.edit.profile.image",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@EditImage"
			]);

			Route::delete("delete/all/profile/details", [
				"as" => "landlord.delete.profile",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@DeleteProfile"
			]);
		});


		Route::prefix("comments_ratings/")->group(function () {
			$common_comments_ratings_controller_url = "App\Http\Controllers\Landlord\LandlordSocialCommentsAndRatingsController";

			Route::post("upload/commments/ratings", [
				"as" => "landlord.upload.comments.ratings",
				//"middleware" => "init",
				"uses" => "{$common_comments_ratings_controller_url}@CommentsAndRatings"
			]);

			Route::get("view/others/landlords/comments/ratings", [
				"as" => "landlord.view.other.landlords.comments.ratings",
				//"middleware" => "init",
				"uses" => "{$common_comments_ratings_controller_url}@ViewOtherLandlordsCommentsRatingsOnLandlord"
			]);

			Route::get("view/all/own/tenants/comments/ratings", [
				"as" => "landlord.view.own.tenants.comments.ratings",
				//"middleware" => "init",
				"uses" => "{$common_comments_ratings_controller_url}@ViewOwnTenantCommentsRatings"
			]);
		});


		Route::prefix("payments/")->group(function () {
			$common_payment_controller_url = "App\Http\Controllers\Landlord\LandlordPaymentController";
			$common_payment_execution_controller_url = "App\Http\Controllers\Landlord\LandlordPaymentExecuteController";

			Route::post("upload/bank/account/details", [
				"as" => "landlord.upload.bank.account.details",
				//"middleware" => "init",
				"uses" => "{$common_payment_controller_url}@UploadBankAccountDetails"
			]);

			Route::post("edit/bank/account/details", [
				"as" => "landlord.edit.bank.account.details",
				//"middleware" => "init",
				"uses" => "{$common_payment_controller_url}@EditBankAccountDetails"
			]);

			Route::get("fetch/bank/account/details", [
				"as" => "landlord.fetch.bank.account.details",
				//"middleware" => "init",
				"uses" => "{$common_payment_controller_url}@FetchBankAccountDetails"
			]);

			Route::post("make/withdrawal/request", [
				"as" => "landlord.make.withdrawal.request",
				//"middleware" => "init",
				"uses" => "{$common_payment_execution_controller_url}@MakeWithdrawalRequest"
			]);

			Route::post("view/all/withdrawal/requests/summary", [
				"as" => "landlord.view.all.withdrawal.requests",
				//"middleware" => "init",
				"uses" => "{$common_payment_execution_controller_url}@ViewAllWithdrawalRequests"
			]);

			Route::post("view/each/withdrawal/request", [
				"as" => "landlord.view.each.withdrawal.request",
				//"middleware" => "init",
				"uses" => "{$common_payment_execution_controller_url}@MakeWithdrawalRequest"
			]);

			Route::get("view/payment/transaction/history", [
				"as" => "landlord.view.payment.history",
				//"middleware" => "init",
				"uses" => "{$common_payment_execution_controller_url}@ViewPaymentTransactionDetails"
			]);

			Route::get("view/wallet/details", [
				"as" => "landlord.view.wallet.details",
				//"middleware" => "init",
				"uses" => "{$common_payment_execution_controller_url}@ViewWalletDetails"
			]);
		});


		Route::prefix("social/")->group(function () {
			Route::prefix("messaging/")->group(function () {
				$common_contact_controller_url = "App\Http\Controllers\Landlord\LandlordSocialContactController";

				Route::post("send/admin/message", [
					"as" => "landlord.message.admin",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@SendAdminMessage"
				]);

				Route::post("send/tenant/message", [
					"as" => "landlord.message.tenant",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@SendTenantMessage"
				]);

				Route::get("fetch/all/admin/messages", [
					"as" => "landlord.read.all.admin.messages",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@ReadAllAdminMessages"
				]);

				Route::get("fetch/all/tenant/messages", [
					"as" => "landlord.read.all.tenant.messages",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@ReadAllTenantMessages"
				]);

				Route::get("fetch/all/sent/messages", [
					"as" => "landlord.read.all.sent.messages",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@ReadAllSentMessages"
				]);
			});
		});
	});
});


//Admin Auth:
Route::prefix("v1/admin/")->middleware(["auth:sanctum", "ability:admin-boss", "AdminCleanNullRecords"])->group(function () {
	Route::prefix("auth")->group(function () {
		$common_access_controller_url = "App\Http\Controllers\Admin\AdminAccessController";

		Route::post("dashboard/login", [
			"as" => "admin.login",
			"middleware" => "AdminCreateBoss",
			"uses" => "{$common_access_controller_url}@LoginDashboard"
		]);

		//here, admin-boss registers admin-hired:
		Route::post("register/hired", [
			"as" => "admin.hired.register",
			//"middleware" => "",
			"uses" => "{$common_access_controller_url}@RegisterHiredAdmin"
		]);

		//here, admin-boss delete admin-hired:
		Route::delete("delete/hired", [
			"as" => "admin.hired.delete",
			"middleware" => ["auth:sanctum", "ability:admin-boss"],
			"uses" => "{$common_access_controller_url}@DeleteHiredAdmin"
		]);

		Route::patch("dashboard/logout", [
			"as" => "admin.logout",
			"middleware" => ["AdminConfirmLoginState", "DestroyTokenAfterLogout", "auth:sanctum", "abilities:admin-boss, admin-hired"],
			"uses" => "{$common_access_controller_url}@Logout"
		]);
	});


	Route::prefix("dashboard/utils/")->group(function () {
		Route::prefix("profile")->group(function () {
			$common_profile_controller_url = "App\Http\Controllers\Admin\AdminProfileController";

			Route::patch("edit/profile/texts", [
				"as" => "admin.edit.profile.texts",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@EditProfile"
			]);

			//optional pictures:
			Route::patch("edit/profile/image", [
				"as" => "admin.edit.profile.image",
				//"middleware" => "init",
				"uses" => "{$common_profile_controller_url}@EditImage"
			]);
		});

		Route::prefix("searches/")->group(function () {
			$common_fetch_controller_url = "App\Http\Controllers\Admin\AdminLandlordTenantFetchController";

			Route::get("fetch/all/landlords/summary", [
				"as" => "admin.fetch.all.landlords",
				//"middleware" => "init",
				"uses" => "{$common_fetch_controller_url}@FetchAllLandlordDetails" //paginate
			]);

			Route::patch("fetch/each/landlord/details", [
				"as" => "admin.fetch.each.landlord",
				//"middleware" => "init",
				"uses" => "{$common_fetch_controller_url}@FetchEachLandlordDetail"
			]);

			Route::get("fetch/all/tenants/summary", [
				"as" => "admin.fetch.all.tenants",
				//"middleware" => "init",
				"uses" => "{$common_fetch_controller_url}@FetchAllTenantDetails" //paginate
			]);

			Route::patch("fetch/each/tenant/details", [
				"as" => "admin.fetch.each.tenant",
				//"middleware" => "init",
				"uses" => "{$common_fetch_controller_url}@FetchEachTenantDetail"
			]);
		});

		Route::prefix("action/")->group(function () {
			$common_admin_action_controller_url = "App\Http\Controllers\Admin\AdminLandlordTenantGeneralActionController";

			Route::patch("ban/landlord", [
				"as" => "admin.ban.landlord",
				//"middleware" => "init",
				"uses" => "{$common_admin_action_controller_url}@BanLandlord"
			]);

			Route::delete("delete/landlord", [
				"as" => "admin.delete.landlord",
				//"middleware" => "init",
				"uses" => "{$common_admin_action_controller_url}@DeleteLandlord"
			]);

			//Admin can delete landlord after warning(unauthorised content upload or in case long time of in-activity):
			Route::patch("ban/tenant", [
				"as" => "admin.ban.tenant",
				//"middleware" => "init",
				"uses" => "{$common_admin_action_controller_url}@BanTenant"
			]);

			Route::delete("delete/tenant", [
				"as" => "admin.delete.tenant",
				//"middleware" => "init",
				"uses" => "{$common_admin_action_controller_url}@DeleteTenant"
			]);

			Route::put("activate/each/banned/landlord", [
				"as" => "admin.activate.banned.landlord",
				//"middleware" => "init",
				"uses" => "{$common_admin_action_controller_url}@ActivateLandlord"
			]);

			Route::put("activate/each/banned/tenant", [
				"as" => "admin.activate.banned.tenant",
				//"middleware" => "init",
				"uses" => "{$common_admin_action_controller_url}@ActivateTenant"
			]);
		});

		Route::prefix("payment/")->group(function () {
			$common_admin_payment_controller_url = "App\Http\Controllers\Admin\AdminPaymentController";
			$common_withdrawal_specific_controller_url = "App\Http\Controllers\Admin\AdminLandlordSpecificActionController";

			//This will be in percentage, to be deducted from the landlord money, upon withdrawal request:
			Route::patch("set/withdrawal/charge", [
				"as" => "admin.set.withdrawal.charge",
				//"middleware" => "init",
				"uses" => "{$common_admin_payment_controller_url}@SetWithdrawalCharge"
			]);

			Route::get("fetch/all/landlord/wallet/total", [
				"as" => "admin.fetch.landlord.wallet.total",
				//"middleware" => "init",
				"uses" => "{$common_admin_payment_controller_url}@AllLandlordWalletTotal"
			]);

			//Admin can delete landlord after warning(unauthorised content upload or in case long time of in-activity):
			Route::get("fetch/total/withdrawal/payout", [
				"as" => "admin.total.withdrawal.payout",
				//"middleware" => "init",
				"uses" => "{$common_admin_payment_controller_url}@TotalWithdrawalPayout"
			]);

			/*Route::get("fetch/all/unapproved/withdrawal/requests", [
				"as" => "admin.fetch.unapproved.withdrawal.requests",
				//"middleware" => "init",
				"uses" => "{$common_withdrawal_specific_controller_url}@ViewAllUnApprovedLandlordWithdrawalRequests"
			]);*/

			Route::patch("fetch/all/withdrawal/requests/by/approval", [
				"as" => "admin.fetch.withdrawal.requests.by.approval",
				//"middleware" => "init",
				"uses" => "{$common_withdrawal_specific_controller_url}@ViewAllApprovedLandlordWithdrawalRequests"
			]);

			Route::patch("approve/withdrawal/request", [
				"as" => "admin.approve.withdrawal.request",
				//"middleware" => "init",
				"uses" => "{$common_withdrawal_specific_controller_url}@ApproveLandlordWithdrawalRequest"
			]);
		});

		Route::prefix("social/")->group(function () {
			Route::prefix("messaging/")->group(function () {
				$common_contact_controller_url = "App\Http\Controllers\Admin\AdminSocialContactController";

				Route::post("send/landlord/message", [
					"as" => "admin.message.landlord",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@SendLandlordMessage"
				]);

				Route::post("send/tenant/message", [
					"as" => "admin.message.tenant",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@SendTenantMessage"
				]);

				Route::get("fetch/all/sent/messages", [
					"as" => "admin.read.all.sent.messages",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@ReadAllSentMessages"
				]);

				Route::get("fetch/all/landlord/messages", [
					"as" => "admin.read.all.landlord.messages",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@ReadAllLandlordMessages"
				]);

				Route::get("fetch/all/tenant/messages", [
					"as" => "admin.read.all.tenant.messages",
					//"middleware" => "init",
					"uses" => "{$common_contact_controller_url}@ReadAllTenantMessages"
				]);
			});

			Route::prefix("referral/")->group(function () {
				$common_referral_controller_url = "App\Http\Controllers\Admin\AdminReferralController";

				Route::post("update/referral/details", [
					"as" => "admin.update.referral.details",
					//"middleware" => "init",
					"uses" => "{$common_referral_controller_url}@UpdateReferralDetails"
				]);

				Route::get("fetch/referral/details", [
					"as" => "admin.fetch.referral.details",
					//"middleware" => "init",
					"uses" => "{$common_referral_controller_url}@FetchReferralDetails"
				]);

				//when a new user clicks the unique referral link generated:
				Route::get("change/referral/program/status", [
					//"as" => "admin.change.referral.program.status", 
					//"middleware" => "init",
					"uses" => "{$common_referral_controller_url}@DisableReferralProgram"
				]);
			});

			Route::prefix("general/")->group(function () {
				$common_general_controller_url = "App\Http\Controllers\Admin\AdminOverviewController";

				//some of these data will be used for plotting charts on the frontend:
				//include - month, total payment made:
				Route::get("fetch/general/statistics", [
					"as" => "admin.fetch.general.statistics",
					//"middleware" => "init",
					"uses" => "{$common_general_controller_url}@FetchGeneralStatistics"
				]);

				Route::get("sales/chart/data", [
					"as" => "admin.sales.chart.data",
					//"middleware" => "init",
					"uses" => "{$common_general_controller_url}@SpecificLandlordSalesData"
				]);

				Route::get("view/all/landlords/by/highest/sales", [
					"as" => "admin.view.landlords.by.highest.sales",
					//"middleware" => "init",
					"uses" => "{$common_general_controller_url}@ViewLandlordsByHighestSales"
				]);

				Route::post("hint/landlord/on/each/sales/made", [
					"as" => "admin.hint.landlord",
					"uses" => "{$common_general_controller_url}@HintLandlord"
				]);
			});
		});
	});
});
