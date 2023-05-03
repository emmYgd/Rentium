<?php

namespace App\Services\Traits\ModelAbstraction\Landlord;

use Illuminate\Http\Request;

use App\Services\Traits\ModelCRUD\Social\ContactCRUD;

trait LandlordSocialContactAbstraction
{
	use ContactCRUD;
	
	protected function LandlordSendAdminMessageService(Request $request): bool
	{
        //Store the attachment file on disk first:
        $attachment_file_rep = $request?->file('attachment')?->store('uploads');
        //store its link representation in db:
		$contactNewKeysValues = [
			'unique_landlord_id' => $request?->$unique_landlord_id,
            'unique_admin_id' => $request?->$unique_admin_id,
			'message_nature' => 'landlord_to_admin',
		    'message' => $request?->message,
            'message_attachment' => $attachment_file_rep
		];
		$was_landlord_message_saved = $this?->ContactCreateAllService($contactNewKeysValues);

		return $was_landlord_message_saved;
	}


	protected function LandlordSendTenantMessageService(Request $request): array
	{
        //Store the attachment file on disk first:
        $attachment_file_rep = $request?->file('attachment')?->store('uploads');
        //store its link representation in db:
		$contactNewKeysValues = [
			'unique_landlord_id' => $request?->$unique_landlord_id,
            'unique_tenant_id' => $request?->$unique_tenant_id,
			'message_nature' => 'landlord_to_tenant',
		    'message' => $request?->message,
            'message_attachment' => $attachment_file_rep
		];
		$was_landlord_message_saved = $this?->ContactCreateAllService($contactNewKeysValues);

		return $was_landlord_message_saved;
	}


    protected function LandlordReadAllAdminMessagesService(Request $request): bool
	{
        $queryKeysValues = [
			'unique_landlord_id' => $request?->unique_landlord_id,
			//'message_nature' => 'landlord_to_admin',
            'message_nature' => 'admin_to_landlord'
		];
		$messageDetails = $this?->ContactReadAllLazySpecificService($queryKeysValues);

		//loop through the array and read in the image if it isn't empty:
		//Now loop through each occupied array and get the image link:
		foreach($messageDetails as $eachMessageModel)
		{
			//get the db link:
			$eachAttachmentLink = $eachMessageModel?->message_attachment;
			//use each db link rep of the attachment file link to get the real file on disk:
			$real_attachment_file_on_disk = base64_encode(Storage::get($eachAttachmentLink));
			//replace model link with real image file:
			$eachMessageModel->message_attachment = $real_attachment_file_on_disk;
		}
		return $messageDetails;
	}
	

	protected function LandlordReadAllTenantMessagesService(Request $request): bool
	{
        $queryKeysValues = [
			'unique_landlord_id' => $request?->unique_landlord_id,
			'message_nature' => 'tenant_to_landlord',
            //'message_nature' => 'landlord_to_tenant',
		];
		$messageDetails = $this?->ContactReadAllLazySpecificService($queryKeysValues);

		//loop through the array and read in the image if it isn't empty:
		//Now loop through each occupied array and get the image link:
		foreach($messageDetails as $eachMessageModel)
		{
			//get the db link:
			$eachAttachmentLink = $eachMessageModel?->message_attachment;
			//use each db link rep of the attachment file link to get the real file on disk:
			$real_attachment_file_on_disk = base64_encode(Storage::get($eachAttachmentLink));
			//replace model link with real image file:
			$eachMessageModel->message_attachment = $real_attachment_file_on_disk;
		}

		return $messageDetails;
	}

}

?>