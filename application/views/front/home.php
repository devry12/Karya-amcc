
<?php
if (!isset($_SESSION['access_token']) || $_SESSION['access_token'] == "") {
  unset($_SESSION['nim']);
  unset($_SESSION['name']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AMCC KARYA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="<?=base_url()?>assets/theme1/front/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=base_url()?>assets/theme1/front/css/style3.css">
    <script src="<?=base_url()?>assets/theme1/front/js/jquery.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.21/dist/vue.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg-primary" >
    <div id="app">
    <header class="header bg-primary" id="header">
        <a href="" class="brand text-white font-weight-bold align-middle">
            AMCC KARYA
        </a>
        <?php if (!isset($_SESSION['nim'])): ?>
          <div class="btn btn-outline-light float-right" data-toggle="modal" data-target="#loginmember">
            Sign in
          </div>
        <?php else: ?>

          <?php
            $nim = str_replace('.','_',$_SESSION['nim']);
            $thn = substr($_SESSION['nim'], 0,2);
           ?>
          <div class="alert d-inline-block bg-white p-2 float-right" style="border-radius: 50px;">
            <img src="http://www.amikom.ac.id/public/fotomhs/20<?=$thn?>/<?=$nim?>.jpg" alt="" width="40px" class="rounded-circle">
            <span class="align-middle ml-3"><?=$_SESSION['name']?> </span>
            <span class="align-middle mx-3">
              <a href="">
                <span class="fa fa-times"></span>
              </a>
            </span>
          </div>
        <?php endif; ?>
    </header>

    <section class="body">
        <div class="display-4 text-center text-white mb-5">
           Hai, Selamat datang (>_<)
        </div>
        <div class="row">

      <div class="col-sm-11">
        <form action="">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search" name="search">
                <div class="input-group-append">
                    <button type="submit" class="input-group-text" id="basic-addon2">
                        <span class="fa fa-search"></span>
                    </button>
                </div>
            </div>
        </form>
      </div>
      <?php if (isset($_SESSION['nim'])): ?>
        <div class="col-sm-1">
          <button type="button" data-toggle="modal" data-target="#uploadkarya"  class="btn btn-success">Upload Karya</button>
        </div>
      <?php else: ?>
        <div class="col-sm-1" id="errorlogin">
          <button type="button" @click='loginempty'  class="btn btn-success">Upload Karya</button>
        </div>
      <?php endif; ?>
      </div>

        <div class="row mt-body gutters" id="loadPost">
          <div class="row">
            <div class="col-sm-6 mt-5" v-for='post in posts'>
                <div class="card position-relative">
                    <img class="card-img-top" src="<?=base_url()?>assets/theme1/front/img/eberhard-grossgasteiger-382463-unsplash.jpg" alt="Card image cap">
                    <div class="card-body">
                        <div class="position-absolute img-user">
                            <img src='' width="60px" alt="" class="rounded-circle">
                        </div>
                        <h5 class="card-title h1 mt-3" v-cloak>{{ post.judul_karya }}</h5>
                        <p class="text-secondary">
                            <div class="btn btn-white text-secondary">
                                <span class="fa fa-user"></span>
                            </div>
                            {{ post.id_member }}
                        </p>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content. </p>
                        <button type="button" class="btn btn-primary"><i class="fab fa-readme"></i></button>

                        <a href="">
                            <div class="btn btn-primary" style="margin-left: 12px;">
                                <span class="fa fa-external-link-alt"></span>
                            </div>
                        </a>
                        <a href="">
                            <div class="btn btn-primary" style="margin-left: 12px;">
                                <span class="fa fa-download"></span>
                            </div>
                        </a>

                    </div>
                </div>
            </div>
          </div>

        <button v-bind:class="[isFinished ? 'finish' : 'load-more']" @click='getPosts()' v-cloak class="btn btn-outline-light w-100 mt-5">
            {{ buttonText }}
        </button>
    </section>
  </div>
</div>

    <div class="modal fade" id="loginmember" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Login member</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                        <div class="form-group">
                            <label for="nim">NIM</label>
                            <input type="text" class="form-control" id="nim" name="nim" aria-describedby="nim" placeholder="xx.xx.xxxx">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <button @click='login()' class="btn btn-primary">Submit</button>

                </div>
            </div>
        </div>
    </div>


    <!-- upload -->
<div class="modal fade" id="uploadkarya" tabindex="-1" role="dialog" aria-labelledby="uploadkarya" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Upload Karya anda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input type="text" id="" name="idmember" value="" hidden>
  <div class="form-group">
    <label for="judulkarya">Judul karya anda</label>
    <input type="text" class="form-control" id="judulkarya" name='judulkarya' placeholder="Web Penjualan">
  </div>

  <div class="form-group">
    <label for="linkkarya">Link karya anda</label>
    <input type="text" class="form-control" id="linkkarya" name="linkkarya" placeholder="https://amcc.or.id">
  </div>
  <div class="form-group">
    <label for="filekarya">File Karya Anda</label>
    <?php $percents =  '{{percent}}'; ?>
    <input type="file" class="form-control"  id="filekarya" name="filekarya">
    <div class="progress">
      <input type="text" hidden  name="percent-input" value="per">
  <div id="progressbar-upload" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" v-bind:style="{ width: percent + '%' }"  aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">{{percent}}%</div>
</div>

  <div class="form-group">
      <label for="img-thumbnail">Gambar Karya anda</label>
      <input type="file" class="form-control" id="img-thumbnail" name="img-thumbnail">
  </div>

  </div>
  <div class="form-group">
    <label for="deskkarya">Deskripsi Karya anda</label>
    <textarea class="form-control" id="deskkarya" name="deskkarya" rows="3"></textarea>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button  @click="upload()" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


    <footer class="footer">
        <center>
            <p class="text-white">
                Copyright 2019. Amcc
            </p>
        </center>
    </footer>

    <a href="#header" class="up">
        <div class="btn btn-light rounded-circle shadow-sm">
            <span class="fa fa-rocket"></span>
        </div>
    </a>

    <script src="<?=base_url()?>assets/theme1/front/js/bootstrap.min.js"></script>

    <script type="text/javascript">
    var  percent;
    var app = new Vue({
      el: '#uploadkarya',
      mounted:function (){
        console.log("mounted");
      },
      data: {
        percent:0,
        messagepercent:"",
      },
      methods:{
        upload: function(){
          var _this = this;
          var filek = document.getElementById('filekarya');
          var thum = document.getElementById('img-thumbnail');
          var link = document.getElementById('linkkarya').value;
          var judul = document.getElementById('judulkarya').value;
          var deskkarya = document.getElementById('deskkarya').value;
          console.log(thum.files[0]['name']);

          var fd = new FormData();
          fd.append("filekarya",filek.files[0])
          fd.append("thum",thum.files[0])
          fd.set("judulkarya",judul)
          fd.set("linkkarya",link)
          fd.set("deskkarya",deskkarya)
          fd.set("img-karya",thum.files[0]['name'])
          console.log(fd);
          axios.post("<?=base_url()?>home/uploadfilekarya",fd,{
            onUploadProgress:function(uploadEvent){
              _this.percent = Math.round((uploadEvent.loaded / uploadEvent.total)*100);

            }
          }).then(function(res){
            if (res.data != "ok") {
                swal({
                  title: "Sorry",
                    text: res.data,
                    icon: "error"
                  });
            }else {
              swal({
                title: "Congretulation",
                  text: "Your work has been uploaded successfully, wait for confirmation from the admin",
                  icon: "success"
                }).then(function(){
                  window.location.replace("/");
                });

            }
          }).catch(function(e){
            console.log(e);
          });
        }
      }
    })
    </script>

    <script type="text/javascript">
    var app = new Vue({
      el: '#loginmember',
      mounted:function (){
        console.log("mounted");
      },
      methods:{
        login: function(){
          var _this = this;
          var nim = document.getElementById('nim').value;
          var password = document.getElementById('password').value;

            var fd = new FormData();

            fd.set("nim",nim)
            fd.set("password",password)

            axios.post("<?=base_url()?>auth/login",fd,{

            }).then(function(res){
              if (res.data == "empty") {
                  swal({
                    title: "Sorry",
                      text: "Nim dan password harus diisi",
                      icon: "error"
                    });
              }else if(res.data == 'berhasil'){
                  window.location.replace("/home/googleAuth");
              }else if (res.data == 'gagal') {
                swal({
                  title: "Sorry",
                    text: "Nim atau password anda salah",
                    icon: "error"
                  });
              }
            }).catch(function(e){
              console.log(e);
            });
        }
      }
    })
    </script>

    <script type="text/javascript">
    var app = new Vue({
      el: '#errorlogin',
      methods:{
        loginempty: function(){
                  swal({
                    title: "Sorry",
                      text: "Anda harus login dulu sebelum upload karya",
                      icon: "error"
                    });
    }
  }
  })

    </script>

    <script type="text/javascript">
    var app = new Vue({
      el: '#loadPost',
      data: {
        isFinished: false,
        row: 0,
        rowperpage: 2,
        buttonText: 'Load More',
        posts: ''
      },
      methods: {
        getPosts: function(){
          var fd = new FormData()
          fd.set('row',this.row)
          fd.set('rowperpage',this.rowperpage)
          console.log(fd);
          axios.post('<?=base_url()?>home/loadPost',fd, {

          })
          .then(function (response) {
             if(response.data !=''){

               // Update rowperpage
               app.row+=app.rowperpage;

               var len = app.posts.length;

               if(len > 0){
                 app.buttonText = "Loading ...";
                 setTimeout(function() {
                    app.buttonText = "Load More";

                    // Loop on data and push in posts
                    for (let i = 0; i < response.data.length; i++){
                       app.posts.push(response.data[i]);
                    }
                 },500);
               }else{
                  app.posts = response.data;
               }

             }else{
               app.buttonText = "No more records avaiable.";
               app.isFinished = true;
             }
           });
         }
       },
       created: function(){
          this.getPosts();
       }
    })
    </script>

</body>
</html>