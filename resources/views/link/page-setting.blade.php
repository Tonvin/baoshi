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
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
	<script src="{{ URL::asset('js/auth.js')}}"></script>
	<title>{{__('link.setting')}}</title>
<style>
button{
	margin:15px 0;
	font-size:.8rem;
}
</style>
</head>
<body>
@include('link.header')
<div id="app">
  <v-app id="inspire">
    <div>
	<x-auth-validation-errors class="mb-4" :errors="$errors" />
	<v-form ref="form" v-model="valid" lazy-validation action="/setting/page/{{$page}}" method='post'>
		@csrf
      <v-text-field label="{{__('link.page_name')}}" :rules="rules" name="page" value="{{old('page')??$page}}" hide-details="auto" ></v-text-field>
      <input  name="old_page" value="{{old('old_page')??$page}}" type=hidden></input>
	  <v-btn type=submit rounded color="primary" dark >保存</v-btn>
	</v-form>
    </div>
  </v-app>
</div>
@include('link.footer')
<script>
new Vue({
el: '#app',
	vuetify: new Vuetify(),
	data: () => ({
	valid:true,
	rules: [
		value => !!value || 'Required.',
		value => (value && value.length >= 1) || 'Min 1 characters',
	],
  }),
})

</script>
</body>
</html>
