<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public  $table='product';
    public $timestamps = false;

	public static function insertFlatData($linkFlat, $prise, $shortDescriptionFlat, $descriptionFlat, $numberOfFloorsFlat, $floorsFlat, $numberOfRoomsFlat, $areaFlat)
	{
		$data = new Product;
		$data -> link = $linkFlat;
		$data -> price = $prise;
		$data -> short_description = $shortDescriptionFlat;
		$data -> detailed_description = $descriptionFlat;
		$data -> number_of_floors = $numberOfFloorsFlat;
		$data -> floor = $floorsFlat;
		$data -> number_of_rooms = $numberOfRoomsFlat;
		$data -> area = $areaFlat;
		$data -> save();
	}

	public static function selectFlatId($linkFlat) 
	{
		$selectFlatId=Product::select('id')->where('link', '=', $linkFlat)->first();
		return $selectFlatId;
	}

	public static function selectFlatData($priceFrom, $priceTo, $numberOfRoomsFrom, $numberOfRoomsTo, $floorFrom, $floorTo)
	{

		$selectFlatData=Product::
			leftJOIN('productphoto', 'product.id', 'productphoto.product_id')
			->select('product.id', 'product.number_of_rooms', 'product.floor', 'product.price', 'product.short_description', 'product.detailed_description', 'productphoto.image_url')
			->groupBy('product.id')
			->where('product.price', '>=', $priceFrom)
			->where('product.price', '<=', $priceTo)
			->where('product.number_of_rooms', '>=', $numberOfRoomsFrom)
			->where('product.number_of_rooms', '<=', $numberOfRoomsTo)
			->where('product.floor', '>=', $floorFrom)
			->where('product.floor', '<=', $floorTo)
			->get();
		
        return $selectFlatData;

	}

	public static function selectDescription($idFlat) {
		$selectFlatDescription=Product::select('detailed_description', 'price', 'short_description', 'floor', 'number_of_rooms', 'area', 'number_of_floors')->where('id', '=', $idFlat)->first();
		return $selectFlatDescription;
	}

	public static function flatDataForComparison($linkFlat) {
		$selectFlatDataForComparison=Product::select('id')->where('link', '=', $linkFlat)->first();

		return $selectFlatDataForComparison;
	}
}
