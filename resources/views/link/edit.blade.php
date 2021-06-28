@include('link.head')
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
            <v-row><v-text-field label="页面" name=page value="{{old('page')?? $link->page}}" placeholder="" outlined ></v-text-field></v-row>
            <v-row><v-text-field label="标签" name=tags placeholder="标签" outlined value="{{old('tags')?? $link->tags}}" ></v-text-field></v-row>

            <v-radio-group v-model="access" row name=access>
              <v-radio label="私密" value="1"></v-radio>
              <v-radio label="公开" value="2"></v-radio>
            </v-radio-group>

            <v-row justify="center" > <v-btn type=submit small outlined class="">{{__('link.edit')}}</v-btn> </v-row>
        </form>
    </v-app>
</div>
<script>
new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  data() {
      return {
          access: "{{old('access') ?? $link->access}}",
      }
  },
  
})
</script>

</body>
</html>
