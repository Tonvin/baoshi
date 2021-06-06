<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">  
        <title>{{__('link.add_link')}}</title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
        <link href="{{ URL::asset('css/link.css')}}" rel="stylesheet">
<style>
body{max-width:700px;}
</style>
    </head>
<body class="">
@include('link.header')

<div id="app">
    <v-app id="inspire">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form method=post action={{url('/link/insert')}}>
            @csrf
            <p><input type=hidden name=id value='' /></p>
            <v-row><v-text-field label="地址" name=url placeholder="{{__('link.url')}}" outlined ></v-text-field></v-row>
            <v-row><v-text-field label="标题" name=title placeholder="{{__('link.title')}}" outlined ></v-text-field></v-row>
            <v-row><v-text-field label="标签" name=tags placeholder="{{__('link.tags_exploded_by_vertical_bar')}}" outlined ></v-text-field></v-row>
            <v-row justify="center"><v-btn type=submit small outlined class="">{{__('link.add')}} </v-btn>  </v-row>
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
