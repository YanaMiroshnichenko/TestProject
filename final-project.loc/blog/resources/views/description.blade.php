@extends('layout')
@section('content')
	<div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row"> 
                <div class="col-md-12">
                    
                    <h1>{{ $pagetitle }}</h1>
                    <h3><a href="/products">Назад</a></h3>
                    <h2>{{ $name }} смотрит:</h2>
                    <h4>{{ $shortDescription }} - {{ $price }} грн</h4>
                    <span><b>Этажность: </b>{{ $numberOfFloorsFlat }}</span><br>
                    <span><b>Этаж: </b>{{ $floorsFlat }}</span><br>
                    <span><b>Количество комнат: </b>{{ $numberOfRoomsFlat }}</span><br>
                    <span><b>Площадь: </b>{{ $areaFlat }}</span>
                    <p>{{ $description }}</p>
                    <span>Фото:</span><br>
                    @foreach ($photos as $photo)
                        <img src="{{ $photo->image_url }}" style="width: 400px;">
                    @endforeach
                </div> 
            </div>  
        </div>
    </div>
@stop