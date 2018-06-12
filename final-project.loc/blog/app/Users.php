<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    public static function authUser($email, $password)
	{
		$password=md5($password);
		$authUser=Users::select('id')->where('email', '=', $email)->where('password', '=', $password)->first();
		return $authUser;
	}
	public static function selectUser($id)
	{
		$selectUser=Users::select('name')->where('id', '=', $id)->first();
            
        return $selectUser;
	}

	public static function selectUserInformation()
	{
		$userInformation=Users::
			join('settings', 'users.id', 'settings.user_id')
			->select('users.id', 'users.name', 'users.email', 'settings.email_notifications', 'settings.slack_notifications', 'settings.channel_name', 'settings.slack_link')
			->get();
		
        return $userInformation;
	}

	public static function selectUserIdSession()
	{
		$userIdSession=Users::select('id')->get();
		return $userIdSession;
	}
}