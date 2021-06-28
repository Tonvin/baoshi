<style>
#header{
    margin:auto;
}

#header h1{ 
    margin-top:-30px;
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
    margin:.1 .5em;
}

#header .nav button{
	font-size:.8rem;
    padding-left:20px;
    line-height:30px;
}

#header .nav a{
	font-size:.8rem;
    padding-left:20px;
    text-decoration:none;
    line-height:30px;
}
</style>

<header id=header>
    <div class=nav>
            @if (Route::has('login'))
                @auth
                        <div>
                                <v-btn
                                    dark
                                    small
                            href="{{url('link/add')}}"
                                    color="indigo"
                                    >
                                    <v-icon dark>
                                        mdi-plus
                                    </v-icon>
                                </v-btn>
                        </div>

                        <div>
                            <a href="/">{{$passport->name}}</a>
                        </div>

                        <div>
                            <form action={{route('logout')}} method=post>
                            @csrf
                                <button>{{__('auth.signout')}}</button>
                            </form>
                        </div>

                @else
                    <a href="{{ route('login') }}" class="">{{__('auth.login')}}</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="">{{__('auth.register')}}</a>
                    @endif
                @endauth
            @endif
	</div>
    <h1 class=app_name><a href='{{env('APP_URL')}}' target=_self>{{env('APP_NAME')}}</a></h1>
</header>

<script>
new Vue({
    el: '#header',
    vuetify: new Vuetify(),
    })
</script>
