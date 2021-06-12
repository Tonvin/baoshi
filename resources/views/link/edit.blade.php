<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">  
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
        <link href="{{ URL::asset('css/link.css')}}" rel="stylesheet">
        <title>{{__('edit_link')}}</title>
    </head>

<body>
@include('link.header')
<div id="app">
    <v-app id="inspire">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form method=post action={{url('/link/update')}}>
            @csrf
            <p><input type=hidden name=id value='{{$link->id}}' /></p>
            <v-row><v-text-field label="地址" name=url placeholder="请输入地址" outlined value="{{old('url') ?? $link->url}}" ></v-text-field></v-row>
            <v-row><v-text-field label="标题" name=title placeholder="请输入标题" outlined value="{{old('title') ?? $link->title}}" ></v-text-field></v-row>
            <v-row><v-text-field label="标签" name=tags placeholder="标签" outlined value="{{old('tags')?? $link->tags}}" ></v-text-field></v-row>
            <v-row justify="center" > <v-btn type=submit small outlined class="">{{__('link.edit')}}</v-btn> </v-row>
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
