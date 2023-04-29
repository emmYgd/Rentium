<?php

namespace App\Services\Traits\ModelAbstraction;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

use App\Services\Traits\ModelCRUD\Tenant\TenantCRUD;
use App\Services\Traits\ModelCRUD\Property\PropertyCRUD;
use App\Services\Traits\ModelCRUD\Payment\PaymentCRUD;
use App\Services\Traits\ModelCRUD\Payment\PaymentTransactionCRUD;
use App\Services\Traits\ModelCRUD\Payment\WalletCRUD;
use App\Services\Traits\ModelCRUD\Social\ReferralCRUD;

//use App\Services\Hooks\StripePaymentHook;
//use App\Services\Hooks\PayStackPaymentHook;
//use App\Services\Hooks\MonifyPaymentHook;

trait TenantPaymentExecuteAbstraction
{
	//inherits all their methods:
	use TenantCRUD;
	use PropertyCRUD;
	use PaymentCRUD;
	use PaymentTransactionCRUD;
	use WalletCRUD;
    use ReferralCRUD;

	//use StripePaymentHook;
    //use PayStackPaymentHook;
    //use MonifyPaymentHook;

	private function PerformNecessaryActionsAfterPaymentSuccess(
		string $unique_tenant_id, 
		string $unique_landlord_id,
		string $unique_property_id,
		float $property_price
	): bool
	{
		//To add this money to landlord's wallet:

		//first read amount:
		$readQueryKeysValues = [
			'unique_landlord_id' => $unique_landlord_id,
		];
		$current_wallet_amount = this->WalletReadSpecificService($queryKeysValues)->current_wallet_balance;

		//now, to update:
		$walletUpdateKeysValues = [
			//cast both values to the same data types
			'current_wallet_balance' => (float)$current_wallet_amount + $property_price,
		];
		$was_wallet_updated = $this->WalletUpdateSpecificService($walletQueryKeysValues, $walletUpdateKeysValues);
		if(!$was_wallet_updated)
		{
			return false;
		}
		//else:

		//change this property's properties:
		$propertyQueryKeysValues = [
			'unique_property_id' => $unique_property_id,
			//'unique_landlord_id' => $unique_landlord_id,
		];

		$propertyUpdateKeysValues = [
			'is_occupied' => true,
			'is_hidden' => false,
		];
		$was_property_updated = this->PropertyUpdateSpecificService($propertyQueryKeysValues, $propertyUpdateKeysValues);
		if(!$was_property_updated)
		{
			return false;
		}

		//clear referral bonus after transaction bcos it has been used:
		$queryReferralKeysValues = [
			'unique_tenant_id' => $unique_tenant_id,
		];

		$newReferralKeysValues = [
			'total_referral_bonus' => null,
		];
		$was_referral_updated = this?->ReferralUpdateSpecificService($queryKeysValues, $newKeysValues);
		if(!$was_referral_updated)
		{
			return false;
		}
		//else:

		//update the payment transaction db:
		$paymentRecordCreateKeysValues = [
			'paying_tenant_id' => $unique_tenant_id,
			'receiving_landlord_id' => $unique_landlord_id,
			'amount_paid' => $tenant_amount_paid,
			//'created_at' => date - will be created by default in database...
		];
		$was_payment_trans_record_created = this->PaymentTransactionCreateAllService($paymentRecordCreateKeysValues);
		if(!$was_payment_trans_record_created)
		{
			return false;
		}

		//else:
		return true;
	}


    protected function TenantMakePaymentByNewBankAccountService(Request $request): bool | array 
	{
		$unique_tenant_id = $request?->unique_tenant_id;
        $unique_landlord_id = $request?->unique_landlord_id;
        $unique_property_id = $request?->unique_property_id;
		//casted to float for arithmetic operation:
		$property_price = (float)$request?->property_price;

        //check for referral bonus:
        $refQueryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];
		//casted to float for arithmetic operation:
        $referral_bonus = (float)$this?->ReferralReadSpecificService($refQueryKeysValues)->tenant_total_referral_bonus;

        //tenant email:
        $tenantQueryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];
        $tenant_model = $this?->TenantReadSpecificService($tenantQueryKeysValues);
        $tenant_email = $tenant_model?->tenant_email;
        $tenant_phone_number = $tenant_model?->tenant_phone_number;

		//new details of this tenant's bank account:
		$paymentKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
			'unique_property_id' => $unique_property_id,
            'tenant_email' => $tenant_email,
            'tenant_phone_number' => $tenant_phone_number,
			
            'amount_to_be_paid' => $property_price - $referral_bonus,//subtract bonus from it if it exists
            
			'bank_name' => $request?->bank_name,
            'bank_account_first_name'=> $request?->bank_account_first_name,
            'bank_account_middle_name'=> $request?->bank_account_middle_name,
            'bank_account_last_name'=> $request?->bank_account_last_name,
            'country_of_opening' => $request?->country_of_opening,
            'currency_of_operation'=> $request?->currency_of_operation,
            'bank_account_type' => $request?->bank_account_type,//savings, current, domiciliary
            'bank_account_number' => $request?->bank_account_number,
            'bank_account_additional_info' => $request?->bank_account_additional_info
        ];

		//call our payment hooks that will interact with the API:
		$was_payment_made = $this?->CallStripeService($paymentKeysValues);
        /*$was_payment_made = $this?->CallPayStackService($paymentKeysValues);
        $was_payment_made = $this?->CallMonifyService($paymentKeysValues);*/
		if(!$was_payment_made)
		{
			return false;
		}
		//else:
			$were_neccessary_actions_performed_after_payment = 
				$this?->PerformNecessaryActionsAfterPaymentSuccess(
					$unique_tenant_id, 
					$unique_landlord_id,
					$unique_property_id,
					$property_price
				);
			if(!$were_neccessary_actions_performed_after_payment)
			{
				return false;
			}
			//else:

				return [
					'was_payment_made' => $was_payment_made,
					'unique_property_id' => $unique_property_id,
					'purchase_currency' => $request->currency_of_operation,
					'purchase_price' => $property_price,
					'discount' => $referral_bonus
				];
	}


	protected function TenantMakePaymentBySavedBankAccountService(Request $request): array 
	{
		$unique_tenant_id = $request?->unique_tenant_id;
        $unique_landlord_id = $request?->unique_landlord_id;
        $unique_property_id = $request?->unique_property_id;
		//casted to float for arithmetic operation:
		$property_price = (float)$request?->property_price;

        //check for referral bonus:
        $refQueryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];
		//casted to float for arithmetic operation:
        $referral_bonus = (float)$this?->ReferralReadSpecificService($refQueryKeysValues)->tenant_total_referral_bonus;

        //tenant email:
        $tenantQueryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];
        $tenant_model = $this?->TenantReadSpecificService($tenantQueryKeysValues);
        $tenant_email = $tenant_model?->tenant_email;
        $tenant_phone_number = $tenant_model?->tenant_phone_number;

		//saved details of this tenant's bank account:
		$saved_payment_details = $this->PaymentReadSpecificService($tenantQueryKeysValues);
		$paymentKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
			'unique_property_id' => $unique_property_id,
            'tenant_email' => $tenant_email,
            'tenant_phone_number' => $tenant_phone_number,
			
            'amount_to_be_paid' => $property_price - $referral_bonus,//subtract bonus from it if it exists
            
			'bank_name' => Crypt::decryptString($saved_payment_details?->bank_name),
            'bank_account_first_name'=> Crypt::decryptString($saved_payment_details?->bank_account_first_name),
            'bank_account_middle_name'=>  Crypt::decryptString($saved_payment_details?->bank_account_middle_name),
            'bank_account_last_name'=>  Crypt::decryptString($saved_payment_details?->bank_account_last_name),
            'country_of_opening' =>  Crypt::decryptString($saved_payment_details?->country_of_opening),
            'currency_of_operation'=>  Crypt::decryptString($saved_payment_details?->currency_of_operation),
            'bank_account_type' =>  Crypt::decryptString($saved_payment_details?->bank_account_type),//savings, current, domiciliary
            'bank_account_number' =>  Crypt::decryptString($saved_payment_details?->bank_account_number),
            'bank_account_additional_info' =>  Crypt::decryptString($saved_payment_details?->bank_account_additional_info)
        ];

		//call our payment hooks that will interact with the API:
		$was_payment_made = $this?->CallStripeService($paymentKeysValues);
        /*$was_payment_made = $this?->CallPayStackService($paymentKeysValues);
        $was_payment_made = $this?->CallMonifyService($paymentKeysValues);*/
		if(!$was_payment_made)
		{
			return false;
		}
		//else:
			$were_neccessary_actions_performed_after_payment = 
				$this?->PerformNecessaryActionsAfterPaymentSuccess(
					$unique_tenant_id, 
					$unique_landlord_id,
					$unique_property_id,
					$property_price
				);
			if(!$were_neccessary_actions_performed_after_payment)
			{
				return false;
			}
			//else:

				return [
					'was_payment_made' => $was_payment_made,
					'unique_property_id' => $unique_property_id,
					'purchase_currency' => $request->currency_of_operation,
					'purchase_price' => $property_price,
					'discount' => $referral_bonus
				];
	}


	protected function TenantMakePaymentByNewBankCardService(Request $request): bool | array 
	{
		$unique_tenant_id = $request?->unique_tenant_id;
        $unique_landlord_id = $request?->unique_landlord_id;
        $unique_property_id = $request?->unique_property_id;
		//casted to float for arithmetic operation:
		$property_price = (float)$request?->property_price;

        //check for referral bonus:
        $refQueryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];
		//casted to float for arithmetic operation:
        $referral_bonus = (float)$this?->ReferralReadSpecificService($refQueryKeysValues)->tenant_total_referral_bonus;

        //tenant email:
        $tenantQueryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];
        $tenant_model = $this?->TenantReadSpecificService($tenantQueryKeysValues);
        $tenant_email = $tenant_model?->tenant_email;
        $tenant_phone_number = $tenant_model?->tenant_phone_number;

		//new details of this tenant's bank account:
		$paymentKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
			'unique_property_id' => $unique_property_id,
            'tenant_email' => $tenant_email,
            'tenant_phone_number' => $tenant_phone_number,
			
            'amount_to_be_paid' => $property_price - $referral_bonus,//subtract bonus from it if it exists
            
            'bank_card_type'=> $request?->bank_card_type,
            'bank_card_number'=> $request?->bank_card_number,
            'bank_card_cvv'=> $request?->bank_card_cvv,
            'bank_card_expiry_month' => $request?->bank_card_expiry_month,
            'bank_card_expiry_year'=> $request?->currency_of_operation,
        ];

		//call our payment hooks that will interact with the API:
		$was_payment_made = $this?->CallStripeService($paymentKeysValues);
        /*$was_payment_made = $this?->CallPayStackService($paymentKeysValues);
        $was_payment_made = $this?->CallMonifyService($paymentKeysValues);*/
		if(!$was_payment_made)
		{
			return false;
		}
		//else:
			$were_neccessary_actions_performed_after_payment = 
				$this?->PerformNecessaryActionsAfterPaymentSuccess(
					$unique_tenant_id, 
					$unique_landlord_id,
					$unique_property_id,
					$property_price
				);
			if(!$were_neccessary_actions_performed_after_payment)
			{
				return false;
			}
			//else:

				return [
					'was_payment_made' => $was_payment_made,
					'unique_property_id' => $unique_property_id,
					'purchase_currency' => $request->currency_of_operation,
					'purchase_price' => $property_price,
					'discount' => $referral_bonus
				];
	}


	protected function TenantMakePaymentBySavedBankCardService(Request $request): array 
	{
		$unique_tenant_id = $request?->unique_tenant_id;
        $unique_landlord_id = $request?->unique_landlord_id;
        $unique_property_id = $request?->unique_property_id;
		//casted to float for arithmetic operation:
		$property_price = (float)$request?->property_price;

        //check for referral bonus:
        $refQueryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];
		//casted to float for arithmetic operation:
        $referral_bonus = (float)$this?->ReferralReadSpecificService($refQueryKeysValues)->tenant_total_referral_bonus;

        //tenant email:
        $tenantQueryKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
        ];
        $tenant_model = $this?->TenantReadSpecificService($tenantQueryKeysValues);
        $tenant_email = $tenant_model?->tenant_email;
        $tenant_phone_number = $tenant_model?->tenant_phone_number;

		//saved details of this tenant's bank account:
		$saved_payment_details = $this->PaymentReadSpecificService($tenantQueryKeysValues);
		$paymentKeysValues = [
            'unique_tenant_id' => $unique_tenant_id,
			'unique_property_id' => $unique_property_id,
            'tenant_email' => $tenant_email,
            'tenant_phone_number' => $tenant_phone_number,
			
            'amount_to_be_paid' => $property_price - $referral_bonus,//subtract bonus from it if it exists
            
            'bank_card_type'=> Crypt::decryptString($saved_payment_details?->bank_card_type),
            'bank_card_number'=> Crypt::decryptString($saved_payment_details?->bank_card_number),
            'bank_card_cvv'=> Crypt::decryptString($saved_payment_details?->bank_card_cvv),
            'bank_card_expiry_month' => Crypt::decryptString($saved_payment_details?->bank_card_expiry_month),
            'bank_card_expiry_year'=> Crypt::decryptString($saved_payment_details?->currency_of_operation),
        ];

		//call our payment hooks that will interact with the API:
		$was_payment_made = $this?->CallStripeService($paymentKeysValues);
        /*$was_payment_made = $this?->CallPayStackService($paymentKeysValues);
        $was_payment_made = $this?->CallMonifyService($paymentKeysValues);*/
		if(!$was_payment_made)
		{
			return false;
		}
		//else:
			$were_neccessary_actions_performed_after_payment = 
				$this?->PerformNecessaryActionsAfterPaymentSuccess(
					$unique_tenant_id, 
					$unique_landlord_id,
					$unique_property_id,
					$property_price
				);
			if(!$were_neccessary_actions_performed_after_payment)
			{
				return false;
			}
			//else:

				return [
					'was_payment_made' => $was_payment_made,
					'unique_property_id' => $unique_property_id,
					'purchase_currency' => $request->currency_of_operation,
					'purchase_price' => $property_price,
					'discount' => $referral_bonus
				];
	}
}