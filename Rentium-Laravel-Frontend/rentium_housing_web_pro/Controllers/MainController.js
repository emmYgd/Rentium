/*import LandlordRegister from "./Controllers/Landlord/LandlordRegisterController.js";
import LandlordLoginLogout from "./Controllers/Landlord/LandlordLoginLogoutController.js";
import LandlordDashboardSecurity from "./Controllers/Landlord/LandlordDashboardSecurityController.js";

import LandlordCartTenant from "./Controllers/Landlord/LandlordCartTenantController.js";
import LandlordPendingCart from "./Controllers/Landlord/LandlordPendingCartController.js";
import LandlordClearedCart from "./Controllers/Landlord/LandlordClearedCartController.js";

import LandlordProduct from "./Controllers/Landlord/LandlordProductController.js";

import LandlordBusinessAddress from "./Controllers/Landlord/LandlordBusinessAddressController.js";
import LandlordBankAccount from "./Controllers/Landlord/LandlordBankAccountController.js";
import LandlordLocationsTracks from "./Controllers/Landlord/LandlordLocationsTracksController.js";
import LandlordReferral from "./Controllers/Landlord/LandlordReferralController.js"; 




import TenantRegister from "./Controllers/Tenant/TenantRegisterController.js";
import TenantLoginLogout from "./Controllers/Tenant/TenantLoginLogoutController.js";
import TenantDashboardSecurity from "./Controllers/Tenant/TenantDashboardSecurityController.js";

import TenantCardDetails from "./Controllers/Tenant/TenantCardDetailsController.js";
import TenantBillingDetails from "./Controllers/Tenant/TenantBillingDetailsController.js";
import TenantShippingDetails from "./Controllers/Tenant/TenantShippingDetailsController.js";

import TenantAccountDetails from "./Controllers/Tenant/TenantAccountDetailsController.js";
import TenantLocationsTracks from "./Controllers/Tenant/TenantLocationsTracksController.js";

import TenantReferral from "./Controllers/Tenant/TenantReferralController.js"; 

import TenantPendingCart from "./Controllers/Tenant/TenantPendingCartController.js";
import TenantClearedCart from "./Controllers/Tenant/TenantClearedCartController.js";

import TenantFetchAndSelectProducts from "./Controllers/Tenant/TenantFetchAllProducts.js";

import TenantPayment from "./Controllers/Tenant/TenantPaymentController.js";

import LandlordGeneralStatistics from "./Controllers/Landlord/LandlordGeneralStatisticsController.js"; 
import TenantGeneralStatistics from "./Controllers/Tenant/TenantGeneralStatisticsController.js"; 

*/
//Now start the app with IIFE main():
const main = (() => {

	$(document).ready(function () {
		/*//FOR LANDLORD: 
		if( $('body#registerPage').val() !== undefined)
		{
			LandlordRegister.RegisterLandlord('button#landlordRegisterBtn');
		}

		//execute at login;
		if( $('body#landlordLoginPage').val() !== undefined ) 
		{
			LandlordLoginLogout.LoginDashboard('button#landlordLoginBtn');
		}

		//execute on dashboard;
		if( $('body#landlordDashboardPage').val() !== undefined )
		{
			LandlordDashboardSecurity.SecureDashboard();

			LandlordGeneralStatistics.FetchStatistics();

			//for Carts:
			LandlordCartTenant.RefreshCartTenantIDs();
			LandlordCartTenant.FetchCartTenantIDs();
			LandlordCartTenant.FetchCartTenantDetails('button#viewEachTenantDetails');

			//for pending Carts:
			LandlordPendingCart.RefreshPendingCartIDs();
			LandlordPendingCart.FetchPendingCartIDs();
			LandlordPendingCart.FetchEachPendingCartDetails('button#viewPendingCartDetails');

			//for cleared Carts:
			LandlordClearedCart.RefreshClearedCartIDs();
			LandlordClearedCart.FetchClearedCartIDs();
			LandlordClearedCart.FetchEachClearedCartDetails('button#viewClearedCartDetails');

			//Upload Products:
			LandlordProduct.UploadProduct('button#saveProductDetails');
			LandlordProduct.RefreshProductIDs();
			LandlordProduct.FetchProductIDs();
			LandlordProduct.FetchEachProductDetails('button#viewProductDetails');
			LandlordProduct.DeleteEachProductDetails('button#deleteProduct');

			//Business Address
			LandlordBusinessAddress.FetchBusinessAddress();
			LandlordBusinessAddress.RefreshFetchBusinessAddress();
			LandlordBusinessAddress.UpdateBusinessAddress('button#saveBizDetails');
			//Upload Bank Acc Details:
			LandlordBankAccount.FetchBankAccount();
			LandlordBankAccount.RefreshFetchBankAccount();
			LandlordBankAccount.UpdateBankAccount('button#saveBankAccDetails');

			//Track Bought Goods:
			LandlordLocationsTracks.FetchCartLocation();
			LandlordLocationsTracks.UpdateCartLocation('button#updateCartLocationBtn');

			//Referral	Program:
			LandlordReferral.RefreshFetchReferral();
			LandlordReferral.FetchReferral();
			LandlordReferral.UpdateReferralInfo('button#uploadReferralInfoBtn');

			LandlordLoginLogout.LogoutDashboard('a#signOut');
		}*/


		//FOR TENANTS:
		/*import("./Tenant/TenantRegisterController.js").then((TenantRegister) => 
		{
			if ($('body#registerPage').val() !== undefined) 
			{
				TenantRegister.RegisterTenant('button#tenantRegisterBtn');
			}
		});*/


		/*if ($('body#tenantShopPage').val() !== undefined) {
			TenantLoginLogout.LoginDashboard('button#tenantLoginBtn');
		}
		//console.log("About to!");
		//for product listings:
		TenantFetchAndSelectProducts.RefreshAllProducts();
		TenantFetchAndSelectProducts.FetchAllProducts();
		TenantFetchAndSelectProducts.PersistPendingCartDetailsToFront('a#checkoutBtn');

		if ($('body#tenantDashboardPage').val() !== undefined) {
			TenantDashboardSecurity.SecureDashboard();
			TenantLoginLogout.LogoutDashboard('a#signOutLink');

			TenantCardDetails.FetchCardDetails();
			TenantCardDetails.RefreshCardDetails();
			TenantCardDetails.UploadCardDetails('button#uploadCardDetailsBtn');

			TenantBillingDetails.FetchBillingDetails();
			TenantBillingDetails.RefreshBillingDetails();
			TenantBillingDetails.UploadBillingDetails('button#billingUploadDetailsBtn');

			TenantShippingDetails.FetchShippingDetails();
			TenantShippingDetails.RefreshShippingDetails();
			TenantShippingDetails.UploadShippingDetails('button#shippingUploadDetailsBtn');

			TenantAccountDetails.FetchBasicAccountDetails();
			TenantAccountDetails.RefreshBasicAccountDetails();
			TenantAccountDetails.UploadAccountDetails('button#accountUploadDetailsBtn');

			//Track Bought Goods: Use Landlord module to avoid repitions:
			TenantLocationsTracks.FetchCartLocation();

			TenantReferral.RefreshFetchReferral();
			TenantReferral.FetchReferralAmount();
			TenantReferral.GenerateReferralLink("button#genRefLinkBtn");

			//to avoid repitions, use common landlord module for user:
			//for pending Carts:
			TenantPendingCart.RefreshPendingCartIDs();
			TenantPendingCart.FetchPendingCartIDs();
			TenantPendingCart.FetchEachPendingCartDetails('button#viewPendingCartDetails');

			//for cleared Carts:
			TenantClearedCart.RefreshClearedCartIDs();
			TenantClearedCart.FetchClearedCartIDs();
			TenantClearedCart.FetchEachClearedCartDetails('button#viewClearedCartDetails');

			TenantPayment.EnsurePaymentIntent('button#settleCartPayBtn');
			TenantPayment.MakePayment();

			TenantGeneralStatistics.FetchStatistics();
		}*/

	});
})();