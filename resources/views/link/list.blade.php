<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">

	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
	<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

	<title>书签列表</title>
</head>
<body class="">

<div id="links">
  <v-app id="inspire">
    <div>
      <v-data-table
        :headers="headers"
        :items="links"
        hide-default-header
        item-key="url"
        class="elevation-1"
        :search="search">

        <template v-slot:top>
          <v-text-field
            v-model="search"
            label="检索"
            class="mx-4"
          ></v-text-field>
        </template>

      </v-data-table>
    </div>
  </v-app>
</div>

  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
  <script>
new Vue({
  el: '#links',
  vuetify: new Vuetify(),
  data() {
    return {
      search: '',
      links: [ ]
	};
  },
  computed: {
    headers() {
      return [
		  {
			text: 'info',
			value: 'detail'
		}
	]
    }
},

  mounted () {
	this.getDataFromApi()
  },

	methods: {
		getDataFromApi () {
			let links = []
			axios.post('{{url('link/select')}}').then
			(
				response => {
									response.data.forEach(function(item) {
												let link = '';
												if (item.title == '' || item.title == null) {
													link = "<a href='"+item.url+"' target='_blank'>"+item.url+"</a>";
												} else {
													link = "<a href='"+item.url+"' target='_blank'>"+item.title+"</a>";
												}
												links.push({'detail':link});
									})
							}
			)
			this.links = links
		},
	}

});
  </script>
</body>
</html>
