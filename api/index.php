<html>
  <head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Val" name="author">
    <title>Imkay - public api</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
      #wrapshopcart {
        width               : 350px;
        margin              : auto;
        padding             : 20px;
        padding-bottom      : 1px;
        margin-bottom       : 20px;
        background          : #fff;
        box-shadow          : 0 0 5px #c1c1c1;
        border-radius       : 5px;
      }
    </style>
  </head>
  <body>
    <br>
    <div id="wrapshopcart">
      <a href="/"><i class="fa fa-times" style="font-size:25px"></i></a>
      <center>
       <h4><br>IMKAY API documentation</h4>
      </center>
      <hr>
      <div class="form-group">
        <span class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h4 class="mb-1">RandomAnime un-official API</h4>
            <small><span class="badge badge-primary badge-pill">new</span></small>
          </div>
          <p class="mb-1">Simple API to get anime recommendations randomly from <a href="https://www.randomanime.org">randomanime.org</a>.</p><br>

        <textarea class="form-control" readonly="" rows="7">GET /api/anime.php HTTP/1.1
Host: imkay.herokuapp.com
Connection: keep-alive
Save-Data: on
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8
Referer: https://imkay.herokuapp.com/
</textarea>
        </span>

      </div>
      <hr>
      <center>
        <p>&copy; 2019 <a href="/">IMKAY</a>&nbsp;
          <i class="fa fa-facebook-official"></i>
          <a href="https://m.facebook.com/zvtyrdt.id">Val</a>
        </p>
      </center>
    </div>
  </body>
</html>
