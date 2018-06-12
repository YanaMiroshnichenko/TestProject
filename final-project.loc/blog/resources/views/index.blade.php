@extends('layout')
@section('content')
    <div class="flex-center position-ref full-height">
        <div class="container">
            <div class="row"> 
                <div class="col-md-12">
                    
                    <h1>{{ $pagetitle }}</h1>
                    <form method="POST" action="/auth">
                       {{ csrf_field() }}
                         <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input class="form-control" placeholder="E-mail" name="email" type="email" id="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Пароль: *</label>
                            <input class="form-control" placeholder="Пароль" name="password" type="password" id="password">
                        </div>
                        <div class="form-group">
                            <input class="btn btn-primary" type="submit" value="Войти">
                        </div>
                    </form>
              
                </div> 
            </div>  
        </div>
    </div>
@stop
