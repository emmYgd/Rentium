<?php
namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

interface TenantSocialReferralInterface 
{
    public function GenerateUniqueReferralLink(Request $request): JsonResponse;
    public function ReferralBonus(Request $request): JsonResponse;
    public function ReferralLinkUse(Request $request, $unique_tenantsocial_id): RedirectResponse;
}

?>