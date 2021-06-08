<style>
#header{
	width:800px;
margin:auto;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    align-items: center;
}

#header h1{ 
    margin:.1em;
    letter-spacing:.1em;
}

#header h1 a { 
    text-decoration:none;
    color:#092b00;
    font-size:1.5rem;
}

#header .nav{
	width:100%;
    display:flex;
    flex-direction:row;
    justify-content:flex-end;
    margin:.5em;
}

#header .nav a{
	font-size:.8rem;
    padding-left:20px;
    text-decoration:none;
}
</style>
<header id=header>
    <h1 class=app_name><a href='{{env('APP_URL')}}' target=_self>{{env('APP_NAME')}}</a></h1>
    <div class=nav>
		@if (Route::has('login'))
			@auth
                <a href="">{{$passport->name}}</a>
				<a href="#" onclick="logout();" id=logout>{{__('auth.signout')}}</a>
			@else
				<a href="{{ route('login') }}" class="">{{__('auth.login')}}</a>
				@if (Route::has('register'))
					<a href="{{ route('register') }}" class="">{{__('auth.register')}}</a>
				@endif
			@endauth
		@endif
	</div>

</header>
