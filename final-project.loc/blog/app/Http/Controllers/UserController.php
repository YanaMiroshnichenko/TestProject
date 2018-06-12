<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Users;
use App\Settings;
use App\Product;
use App\ProductPhoto;

class UserController extends Controller
{
    public function index() {
    	$data = [
	    	'title' => 'Квартира на OLX',
	    	'pagetitle' => 'Авторизация'
    	];
    	return view('index', $data); 
    }
    public function authorization(Request $request)
    {
        $email=$request->email;
        $password=$request->password;
        $qwery=Users::authUser($email, $password);

        $user_id=$qwery['id'];
        if (!empty($qwery)) {
            $request->session()->put('user_id_key', $user_id);           
            return redirect('/products');
        }
        else {
            echo 'Такого пользователя не существует!';
        }
    }
    public function products(Request $request) {
       
    	$value = $request->session()->get('user_id_key');
        $id=$value;
        
        $selectName=Users::selectUser($id);
        

        $priceFrom='Выберите значение';
        $priceTo='Выберите значение';
        $numberOfRoomsFrom='Выберите значение';
        $numberOfRoomsTo='Выберите значение';
        $floorFrom='Выберите значение';
        $floorTo='Выберите значение'; 

        $userSetting=Settings::selectAllSettings($id);
        if (!empty($userSetting)) {
            $priceFrom=$userSetting->price_from;
            $priceTo=$userSetting->price_to;
            $numberOfRoomsFrom=$userSetting->number_of_rooms_from;
            $numberOfRoomsTo=$userSetting->number_of_rooms_to;
            $floorFrom=$userSetting->floor_from;
            $floorTo=$userSetting->floor_to;   
        }

        $valuePriceFrom=$request->price_from;
        $valuePriceTo=$request->price_to;
        $valueNumberOfRoomsFrom=$request->number_of_rooms_from;
        $valueNumberOfRoomsTo=$request->number_of_rooms_to;
        $valueFloorFrom=$request->floor_from;
        $valueFloorTo=$request->floor_to;

        if (!empty($valuePriceFrom)) {
            $priceFrom = (int) $valuePriceFrom;
        }
        if (!empty($valuePriceTo)) {
            $priceTo = (int) $valuePriceTo;
        }
        if (!empty($valueNumberOfRoomsFrom)) {
            $numberOfRoomsFrom = (int) $valueNumberOfRoomsFrom;
          
        }
        if (!empty($valueNumberOfRoomsTo)) {
            $numberOfRoomsTo = (int) $valueNumberOfRoomsTo;
        }
        if (!empty($valueFloorFrom)) {
            $floorFrom = (int) $valueFloorFrom;
        }
        if (!empty($valueFloorTo)) {
            $floorTo = (int) $valueFloorTo;
        }

        

        $flats=Product::selectFlatData($priceFrom, $priceTo, $numberOfRoomsFrom, $numberOfRoomsTo, $floorFrom, $floorTo);

        $userName=$selectName->name;

        $data = [
	    	'title' => 'Квартира на OLX',
	    	'pagetitle' => 'Найти квартиру',
            'value' => $value,
            'name' => $userName,
            'flats' => $flats,
            'priceFrom' => $priceFrom,
            'priceTo' => $priceTo,
            'numberOfRoomsFrom'=> $numberOfRoomsFrom,
            'numberOfRoomsTo' => $numberOfRoomsTo,
            'floorFrom' => $floorFrom, 
            'floorTo' => $floorTo
    	];

    	return view('products', $data);
    }

    public function settings(Request $request) {
        $value = $request->session()->get('user_id_key');
        $id=$value;
        $selectName=Users::selectUser($id);
        
        $priceFrom='Выберите значение';
        $priceTo='Выберите значение';
        $numberOfRoomsFrom='Выберите значение';
        $numberOfRoomsTo='Выберите значение';
        $floorFrom='Выберите значение';
        $floorTo='Выберите значение'; 
        $emailNotifications='';
        $slackNotifications='';
        $channelName='';
        $slackLink='';

        $userSetting=Settings::selectAllSettings($id);
        if (!empty($userSetting)) {
            $priceFrom=$userSetting->price_from;
            $priceTo=$userSetting->price_to;
            $numberOfRoomsFrom=$userSetting->number_of_rooms_from;
            $numberOfRoomsTo=$userSetting->number_of_rooms_to;
            $floorFrom=$userSetting->floor_from;
            $floorTo=$userSetting->floor_to;
            $emailNotifications=$userSetting->email_notifications;
            $slackNotifications=$userSetting->slack_notifications;
            $channelName=$userSetting->channel_name;
            $slackLink=$userSetting->slack_link;
        }

        $userName=$selectName->name;
        $data = [
            'title' => 'Квартира на OLX',
            'pagetitle' => 'Настройки',
            'value' => $value,
            'name' => $userName,
            'priceFrom' => $priceFrom,
            'priceTo' => $priceTo,
            'numberOfRoomsFrom'=> $numberOfRoomsFrom,
            'numberOfRoomsTo' => $numberOfRoomsTo,
            'floorFrom' => $floorFrom, 
            'floorTo' => $floorTo,
            'emailNotifications' => $emailNotifications,
            'slackNotifications' => $slackNotifications,
            'channelName' => $channelName,
            'slackLink' => $slackLink
            
        ];
        return view('settings', $data);
    }

    public function set(Request $request) 
    {
        $value = $request->session()->get('user_id_key');

        $userId=$value;
        $priceFrom=$request->price_from;
        $priceTo=$request->price_to;
        $numberOfRoomsFrom=$request->number_of_rooms_from;
        $numberOfRoomsTo=$request->number_of_rooms_to;
        $floorFrom=$request->floor_from;
        $floorTo=$request->floor_to;
        $emailNotifications=$request->email_notifications;
        $slackLink=$request->slack_link;
        if ($emailNotifications==1) {
            $emailNotifications=1;
        }
        else {
            $emailNotifications=0;
        }
        $slackNotifications=$request->slack_notifications;
        if ($slackNotifications==1) {
            $slackNotifications=1;
        }
        else {
            $slackNotifications=0;
        }
        $channelName=$request->channel_name;

        $selectSettings=Settings::selectSettings($userId);
        
        
        if (is_null($selectSettings)) {
            Settings::insertSettings($userId, $priceFrom, $priceTo, $numberOfRoomsFrom, $numberOfRoomsTo, $floorFrom, $floorTo, $emailNotifications, $slackNotifications, $slackLink, $channelName);
        }
        else {
            Settings::updateSettings($userId, $priceFrom, $priceTo, $numberOfRoomsFrom, $numberOfRoomsTo, $floorFrom, $floorTo, $emailNotifications, $slackNotifications, $slackLink, $channelName);
        }
        return redirect('/products');
    }

    public function description(Request $request, $idFlat) {
        

        $value = $request->session()->get('user_id_key');
        $id=$value;
        $selectName=Users::selectUser($id);
        $userName=$selectName->name;

        $selectDescription=Product::selectDescription($idFlat);
        $description=$selectDescription['detailed_description'];
        $shortDescription=$selectDescription['short_description'];
        $price=$selectDescription['price'];
        $numberOfFloorsFlat=$selectDescription['number_of_floors'];
        $areaFlat=$selectDescription['area'];
        $floorsFlat=$selectDescription['floor'];
        $numberOfRoomsFlat=$selectDescription['number_of_rooms'];

        $photos=ProductPhoto::selectPhotoFlat($idFlat);

        $data = [
            'title' => 'Квартира на OLX',
            'pagetitle' => 'Полное описание квартиры',
            'name' => $userName,
            'description' => $description,
            'shortDescription' => $shortDescription,
            'price' => $price,
            'numberOfFloorsFlat' => $numberOfFloorsFlat,
            'floorsFlat' => $floorsFlat,
            'numberOfRoomsFlat' => $numberOfRoomsFlat,
            'areaFlat' => $areaFlat,
            'photos' => $photos
        ];
        return view('/description', $data); 
    }
}
