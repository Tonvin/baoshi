<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">  

        <title>修改书签</title>

	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

<style>
body {
    font-family: 'Nunito', sans-serif;
}

@media screen and (max-device-width:393px){
    .body{width:95%;}
}

@media screen and (min-device-width:700px){
    .body{width:700px;margin:auto;}
}

p input{border:1px solid gray;width:100%;height:35px;}

button.add {width:150px;height:35px;letter-spacing:.5em;font-weight:bold;}

.logo { margin:1em 0 }

</style>
    </head>
    <body class="antialiased body">

<header>
<div class=logo><h1>宝石书签</h1></div>
</header>

<div id="app">
    <v-app id="inspire">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form method=post action={{url('/link/update')}}>
            @csrf
            <p><input type=hidden name=id value='{{$link->id}}' /></p>
            <v-row><v-text-field label="地址" name=url placeholder="请输入地址" outlined value="{{$link->url}}" ></v-text-field></v-row>
            <v-row><v-text-field label="标题" name=title placeholder="请输入标题" outlined value="{{$link->title}}" ></v-text-field></v-row>
            <v-row><v-text-field label="标签" name=tags placeholder="标签" outlined value="{{$link->tags}}" ></v-text-field></v-row>
            <v-row justify="start" > <v-btn type=submit large outlined class="red white--text"> 修改 </v-btn> </v-row>
        </form>
    </v-app>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  
})
</script>

    </body>
</html>

