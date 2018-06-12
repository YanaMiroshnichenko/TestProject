<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

	public $timestamps = false;

	public static function selectSettings($userId)
	{
		$selectSettings=Settings::select('id')->where('user_id', '=', $userId)->first();
            
        return $selectSettings;
	}

    public static function insertSettings($userId, $priceFrom, $priceTo, $numberOfRoomsFrom, $numberOfRoomsTo, $floorFrom, $floorTo, $emailNotifications, $slackNotifications, $slackLink, $channelName)
	{
		$insertSetting = new Settings;
		$insertSetting -> user_id = $userId;
		$insertSetting -> price_from = $priceFrom;
		$insertSetting -> price_to = $priceTo;
		$insertSetting -> number_of_rooms_from = $numberOfRoomsFrom;
		$insertSetting -> number_of_rooms_to = $numberOfRoomsTo;
		$insertSetting -> floor_from = $floorFrom;
		$insertSetting -> floor_to = $floorTo;
		$insertSetting -> email_notifications = $emailNotifications;
		$insertSetting -> slack_notifications = $slackNotifications;
		$insertSetting -> slack_link = $slackLink;
		$insertSetting -> channel_name = $channelName;
		$insertSetting -> save();
	}

	public static function updateSettings($userId, $priceFrom, $priceTo, $numberOfRoomsFrom, $numberOfRoomsTo, $floorFrom, $floorTo, $emailNotifications, $slackNotifications, $slackLink, $channelName)
	{
		$updateSetting = new Settings;
		$updateSetting -> price_from = $priceFrom;
		$updateSetting -> price_to = $priceTo;
		$updateSetting -> number_of_rooms_from = $numberOfRoomsFrom;
		$updateSetting -> number_of_rooms_to = $numberOfRoomsTo;
		$updateSetting -> floor_from = $floorFrom;
		$updateSetting -> floor_to = $floorTo;
		$updateSetting -> email_notifications = $emailNotifications;
		$updateSetting -> slack_notifications = $slackNotifications;
		$updateSetting -> slack_link = $slackLink;
		$updateSetting -> channel_name = $channelName;

		Settings::where('user_id', $userId)->update([
				'price_from' => $priceFrom,
				'price_to' => $priceTo,
				'number_of_rooms_from' => $numberOfRoomsFrom,
				'number_of_rooms_to' => $numberOfRoomsTo,
				'floor_from' => $floorFrom,
				'floor_to' => $floorTo,
				'email_notifications' => $emailNotifications,
				'slack_notifications' => $slackNotifications,
				'slack_link' => $slackLink,
				'channel_name' => $channelName
			]);	
	}

	public static function selectSettingsForLink($userIdForSettings)
	{
		$settings=Settings::select('price_from', 'price_to', 'number_of_rooms_from', 'number_of_rooms_to', 'floor_from', 'floor_to')->where('user_id', '=', $userIdForSettings)->first();
        return $settings;
	}

	public static function selectAllSettings($id)
	{
		$userSettingsForProduct=Settings::select('price_from', 'price_to', 'number_of_rooms_from', 'number_of_rooms_to', 'floor_from', 'floor_to', 'email_notifications', 'slack_notifications', 'channel_name', 'slack_link')->where('user_id', '=', $id)->first();
        return $userSettingsForProduct;
	}
}
