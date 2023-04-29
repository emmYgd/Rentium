<?php

namespace App\Services\Traits\ModelAbstraction\Tenant;

use Illuminate\Http\Request;

use App\Services\Traits\ModelCRUD\Social\ContactCRUD;

trait TenantSocialCommentsAndRatingsAbstraction
{
	use ContactCRUD;
	
	protected function TenantSendAdminMessageService(Request $request): bool
	{
        //Store the attachment file on disk first:
        $attachment_file_rep = $request?->file('attachment')?->store('uploads');
        //store its link representation in db:
		$contactNewKeysValues = [
			'unique_tenant_id' => $request?->$unique_tenant_id,
            'unique_admin_id' => $request?->$unique_admin_id,
			'message_nature' => 'tenant_to_admin',
		    'message' => $request?->message,
            'message_attachment' => $attachment_file_rep
		];
		$was_tenant_message_saved = $this?->ContactCreateAllService($contactNewKeysValues);

		return $was_tenant_message_saved;
	}


	protected function TenantSendLandlordMessageService(Request $request): array
	{
        //Store the attachment file on disk first:
        $attachment_file_rep = $request?->file('attachment')?->store('uploads');
        //store its link representation in db:
		$contactNewKeysValues = [
			'unique_tenant_id' => $request?->$unique_tenant_id,
            'unique_landlord_id' => $request?->$unique_landlord_id,
			'message_nature' => 'tenant_to_landlord',
		    'message' => $request?->message,
            'message_attachment' => $attachment_file_rep
		];
		$was_tenant_message_saved = $this?->ContactCreateAllService($contactNewKeysValues);

		return $was_tenant_message_saved;
	}


    protected function TenantReadAllAdminMessagesService(Request $request): bool
	{
        $queryKeysValues = [
			'unique_tenant_id' => $request?->unique_tenant_id,
			//'message_nature' => 'tenant_to_admin',
			'message_nature' => 'admin_to_tenant',
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
	

	protected function TenantReadAllLandlordMessagesService(Request $request): bool
	{
        $queryKeysValues = [
			'unique_tenant_id' => $request?->unique_tenant_id,
			//'message_nature' => 'tenant_to_landlord',
			'message_nature' => 'landlord_to_tenant'
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