<?php
namespace App\Services\Interfaces\Admin;

interface AdminAccessInterface {
	public function LoginDashboard(): json;
	public function ForgotPassword(): json;
	public function UpdateAdminDetails(): json;
}

?>