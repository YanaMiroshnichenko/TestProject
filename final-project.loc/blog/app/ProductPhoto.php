<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
	public  $table='ProductPhoto';
	public $timestamps = false;

    public static function insertMainPhoto($MainPhotoSrc, $idFlat)
	{
		$data = new ProductPhoto;
		$data -> image_url = ($MainPhotoSrc);
		$data -> product_id = ($idFlat);
		$data -> save();
	}

	public static function selectPhotoFlat($idFlat)
	{
		$photos=ProductPhoto::select('image_url')->where('product_id', '=', $idFlat)->get();
		return $photos;
	}
}
