@include('link.head')
<body>

<style>
    body{max-width:700px;}
</style>

@include('link.header')

<div id="app">
    <v-app id="inspire">
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        <form method=post action={{url('/link/insert')}}>
            @csrf
            <p><input type=hidden name=id value='' /></p>
            <v-row><v-text-field label="地址" name=url value="{{old('url')}}" placeholder="https://" outlined ></v-text-field></v-row>
            <v-row><v-text-field label="标题" name=title value="{{old('title')}}" placeholder="{{__('link.title')}}" outlined ></v-text-field></v-row>
            <v-row><v-text-field label="页面" name=page value="{{old('page')}}" placeholder="" outlined ></v-text-field></v-row>
            <v-row><v-text-field label="标签" name=tags value="{{old('tags')}}" placeholder="{{__('link.tags_exploded_by_vertical_bar')}}" outlined ></v-text-field></v-row>

            <v-radio-group v-model="access" row name=access>
              <v-radio label="私密" value="1"></v-radio>
              <v-radio label="公开" value="2"></v-radio>
            </v-radio-group>

            <v-row justify="center"><v-btn type=submit small outlined class="">{{__('link.add')}} </v-btn>  </v-row>
        </form>
    </v-app>
</div>

@include('link.footer')

<script>
new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  data() {
      return {
          access: "1",
      }
  },
})
</script>
</body>
</html>
