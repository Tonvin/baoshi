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
<style>
html{
font-size:32px;
}

@media screen and (max-device-width:393px){
	.v-list { width:95% }
}

@media screen and (min-device-width:700px){
	.v-list { width:750px;margin:auto; }
}

.v-list-item__title{
	display:flex;
}
.v-list-item__title:hover a.edit{
	display:inline-block;
}
.v-list-item__title:hover a.del{
	display:inline-block;
}
.v-list-item__title a.tag{
	margin-left:2em;
	text-decoration:none;
	padding:0 10px;
}
.v-list-item__title a.tag:hover{
	text-decoration:underline;
	background:#eee;
}
.v-list-item__title a.edit{
	padding:0 10px;
	margin:0 10px;
	display:none;
	color:#000;
	text-decoration:none;
	font-size:0.6rem;
	margin-left:auto;
}
.v-list-item__title a.edit:hover{
	color:#389e0d;
	background:#eee;
}

.v-list-item__title a.del{
	padding:0 10px;
	margin:0 10px;
	display:none;
	color:#000;
	text-decoration:none;
	font-size:0.6rem;
}
.v-list-item__title a.del:hover{
	color:red;
	background:#eee;
}
</style>
</head>
<body class="">

<div id="links">
<div id="app">
  <v-app id="inspire">
    <v-card
      class="mx-auto"
      tile
    >
      <v-list dense>
        <v-subheader>宝石书签</v-subheader>
        <v-list-item-group
          color="primary"
        >
          <v-list-item
            v-for="(link, i) in links"
            :key="i"
          >
            <v-list-item-content>
              <v-list-item-title v-html="link.detail"></v-list-item-title>
            </v-list-item-content>

          </v-list-item>

        </v-list-item-group>
      </v-list>
    </v-card>
  </v-app>
</div>
</div>

  <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script>
new Vue({
  el: '#app',
  vuetify: new Vuetify(),
  data: () => ({
    links: [],
  }),

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
													link = "<a class=link href='"+item.url+"' target='_blank'>"+item.url+"</a>";
												} else {
													link = "<a class=link href='"+item.url+"' target='_blank'>"+item.title+"</a>";
												}
												if ( item.tags != null ) {
													item.tags.split('|').forEach(el=> link += '<a class=tag href="{{url('link/tag/')}}'+el+'" target=self>'+el+'</a>');
												}
												link = link + '<a class=edit href="{{url('link/edit')}}/'+item.id+'" target=_self>修改</a>';
												link = link + '<a class=del href="{{url('link/del')}}/'+item.id+'" target=_self>删除</a>';
												links.push({'detail':link});
									})
							}
			)
			this.links = links
		},
	}
})

</script>
</body>
</html>
