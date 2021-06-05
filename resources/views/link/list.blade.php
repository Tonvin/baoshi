<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ URL::asset('css/link.css')}}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
	<title>{{__('link.link_list')}}</title>

<style>
.v-list-item__title{
    display:flex;
}

.v-list-item__title a{
    padding:2px 4px;
    text-decoration:none;
}

.v-list-item__title a:hover{
	background:#ddd;
    color:red;
}

.v-list-item__title:hover a.edit{
  opacity: 100;
}

.v-list-item__title:hover a.del{
  opacity: 100;
}

.v-list-item__title a.url_title{
    margin-right:.5em;
text-decoration:none;
color:#00474f;
}
.v-list-item__title a.url_href{
font-size:.6rem;
    margin-right:1em;
text-decoration:none;
color:#00474f;
}
.v-list-item__title a.tag{
    padding:2px 4px;
    font-size:0.5rem;
    color:#08979c;
}
.v-list-item__title a.edit{
    opacity: 0;
	margin-left:auto;
    font-size:.4rem;
}

.v-list-item__title a.del{
    opacity: 0;
    font-size:.4rem;
}
</style>
</head>
<body>

@include('link.header')

<div id="links">

<div id="app">
  <v-app id="inspire">


    <v-card
      class="mx-auto"
      tile
    >


<v-divider></v-divider>

<v-row justify=center>
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
</v-row>


      <v-list dense>
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
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
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
												if (item.title) {
                                                    if ( item.title.length > 15 ) {
                                                       _title = item.title.substr(0, 15) + '...';
                                                    } else {
                                                        _title = item.title;
                                                    }
													link += "<a class=url_title href='"+item.url+"' target='_blank'>"+_title+"</a>";
												}
												if (item.url) {
                                                    if ( item.url.length > 55 ) {
                                                       _url = item.url.substr(0, 55) + '...';
                                                    } else {
                                                        _url = item.url;
                                                    }
													link += "<a class=url_href href='"+item.url+"' target='_blank' title='"+item.url+"'>"+_url+"</a>";
												}
												if ( item.tags ) {
													item.tags.split('|').forEach(el=> link += '<a class=tag href="{{url('link/tag/')}}/'+el+'" target=self>'+el+'</a>');
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
