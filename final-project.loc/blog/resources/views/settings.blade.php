@extends('layout')
@section('content')
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row"> 
                <div class="col-md-12">
                    
                    <h1>{{ $pagetitle }}</h1>
                    <h3><a href="/products">Назад</a></h3>
                    <h2>{{ $name }} настраивает:</h2>
                    <form method="POST" action="/set">
                       {{ csrf_field() }}
                         <div class="form-group">
                            <label for="email">Цена от:</label>
                            <select class="form-control" placeholder="E-mail" name="price_from" type="email" id="email">
                                @for ($i = 1; $i <= 1000000; $i = $i*10) 
                                    <option 
                                        @if ($i == $priceFrom ) 
                                            {{'selected'}}  
                                        @endif 
                                    >{{ $i }}</option>
                                @endfor 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Цена до:</label>
                            <select class="form-control" placeholder="E-mail" name="price_to" type="email" id="email">
                                @for ($i = 1; $i <= 1000000; $i = $i*10) 
                                    <option 
                                        @if ($i == $priceTo ) 
                                            {{'selected'}}  
                                        @endif
                                    >{{ $i }}</option>
                                @endfor 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Количество комнат от:</label>
                            <select class="form-control" placeholder="E-mail" name="number_of_rooms_from" type="email" id="email">
                                @for ($i = 1; $i <= 10; $i++) 
                                    <option
                                        @if ($i == $numberOfRoomsFrom ) 
                                            {{'selected'}}  
                                        @endif
                                    >{{ $i }}</option>
                                @endfor 
                            </select>
                        </div>
                          <div class="form-group">
                            <label for="email">Количество комнат до:</label>
                            <select class="form-control" placeholder="E-mail" name="number_of_rooms_to" type="email" id="email">
                                @for ($i = 1; $i <= 10; $i++) 
                                    <option
                                        @if ($i == $numberOfRoomsTo )
                                            {{'selected'}}
                                        @endif
                                    >{{ $i }}</option>
                                @endfor 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Этаж от:</label>
                            <select class="form-control" placeholder="E-mail" name="floor_from" type="email" id="email">
                                @for ($i = 1; $i <= 15; $i++) 
                                    <option
                                        @if ($i == $floorFrom )
                                            {{'selected'}}
                                        @endif
                                    >{{ $i }}</option>
                                @endfor 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Этаж до:</label>
                            <select class="form-control" placeholder="E-mail" name="floor_to" type="email" id="email">
                                @for ($i = 1; $i <= 15; $i++) 
                                    <option
                                        @if ($i == $floorTo )
                                            {{'selected'}}
                                        @endif
                                    >{{ $i }}</option>
                                @endfor 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Уведомления на email:</label>
                            <input value="1" name="email_notifications" type="checkbox" {{ $emailNotifications ? 'checked' : '' }}> 
                          
                        </div>
                        <div class="form-group">
                            <label for="email">Уведомления на Slack:</label>
                            <input value="1" name="slack_notifications" type="checkbox"{{ $slackNotifications ? 'checked' : '' }}> 
                        </div>
                        <div class="form-group">
                            <label for="email">Ключ Slack:</label>
                            <input value="{{ $slackLink }}" name="slack_link" type="text"> 
                        </div>
                        <div class="form-group">
                            <label for="email">Имя канала Slack:</label>
                            <input value="{{ $channelName }}" name="channel_name" type="text"> 
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Сохранить">
                        </div>
                    </form>
                </div> 
            </div>  
        </div>
    </div>
@stop