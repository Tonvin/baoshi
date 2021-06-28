@include('link.head')

<style>
.crumbs{
    display:flex;
    margin-bottom:.5rem;
    justify-content: flex-start;
}
.crumbs a{
    text-decoration:none;
    margin:0 .2rem;
}
.crumbs a.setting{
    margin-left:auto;
    font-size:0.8rem;
}
.v-card {
    width:100%;
    max-width:800px;
}
.v-list-item__title{
    display:flex;
    flex-wrap:wrap;
}

.v-list-item__title a{
    padding:2px 4px;
    text-decoration:none;
}

.v-list-item__title a:hover{
    background:#bae7ff;
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
font-size:.8rem;
    margin-right:1em;
text-decoration:none;
color:#00474f;
}
.v-list-item__title a.tag{
    padding:2px 4px;
    font-size:.8rem;
    color:#08979c;
}
.v-list-item__title a.edit{
    opacity: 0;
    margin-left:auto;
    font-size:.6rem;
}

.v-list-item__title a.del{
    opacity: 0;
    font-size:.6rem;
}
</style>

@include('link.header')

<div id="page">
<v-app id="inspire">
<div class='crumbs'>
    <a href='/{{$user}}' target=_self>{{$user}}</a>/<a href="/{{$user}}/{{$page}}" target=_self>{{$page}}</a>
    @if (Route::has('login'))
            @if ($user == $admin->name)
                <a href='/setting/page/{{$page}}' target=_self class=setting>{{__("link.setting")}}</a>
            @endif
    @endif
</div>
<v-card class="mx-auto" tile >
<v-divider></v-divider>
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

@include('link.footer')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
new Vue({
    el: '#page',
    vuetify: new Vuetify(),
    data: () => ({
    admin:{
        name:'{{$admin->name}}',
        id:{{$admin->id}},
    },
    links: [],
    page:
        {
            user:'{{$user}}',
            page:'{{$page}}',
            tag:'{{$tag}}',
        }
  }),

  mounted () {
      this.getDataFromApi()
  },

  methods: {

  getDataFromApi () {
  let urls = [];
  const request = (admin = this.admin, page=this.page) => {
      axios.post('{{$fetchUrl}}',page).then
      (
          response => {
          response.data.forEach(function(item) {
              let link = '';
              let url = item.url;
              if (item.title) {
                  if ( item.title.length > 15 ) {
                      _title = item.title.substr(0, 15) + '...';
                  } else {
                      _title = item.title;
                  }
                  link += "<a class=url_title href='"+item.url+"' target='_blank'>"+_title+"</a>";
              }
              if (url) {
                  if ( url.substr(0, 7) == 'http://' ) {
                      url = url.substr(7);
                  } else if ( url.substr(0, 8) == 'https://' ) {
                      url = url.substr(8);
                  }
                  link += "<a class=url_href href='//"+url+"' target='_blank'>";
                  
                  if ( url.length > 35 ) {
                      url = url.substr(0, 35) + '...';
                  }
                  link = link + url + "</a>";

              }
              if ( item.tags ) {
                  item.tags.split('|').forEach(el=> link += '<a class=tag href="/'+page.user+'/'+page.page+'/'+el+'" target=_self>'+el+'</a>');
              }
              if ( admin.name == page.user ) {
                  link = link + '<a class=edit href="{{url('link/edit')}}/'+item.id+'" target=_self>修改</a>';
                  link = link + '<a class=del href="{{url('link/del')}}/'+item.id+'" target=_self>删除</a>';
              }
              urls.push({'detail':link});
          })
          }
          )
          this.links = urls;
        }
          request()
        },
    }
})

</script>
</body>
</html>
