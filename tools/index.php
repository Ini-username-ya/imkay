<html>
  <head>
    <meta charset="utf-8">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta content="Val" name="author">
    <title>kay - list tools</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
    <style> .has-search .form-control {padding-left: 2.375rem;} .has-search .form-control-feedback {position: absolute; z-index: 2; display: block; width: 2.375rem; height: 2.375rem; line-height: 2.375rem; text-align: center; pointer-events: none; color: #aaa;} </style>
  </head>
  <body>
    <br>
    <div id="wrapshopcart">
      <a href="/"><i class="fa fa-times" style="font-size:25px"></i></a>
      <h3><center>list tools</center></h3>
      <hr>

      <div class="form-group has-search">
         <i class="fa fa-search form-control-feedback"></i>
         <input type="text" onkeyup="Search()" class="form-control" placeholder="Search" id="tanya">
      </div>

      <ul class="list-group" id="daftar">
        <!-- items -->
        <a href="/tools/smsae.php" class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h4 class="mb-1">Send Free SMS</h4>
            <small><span class="badge badge-primary badge-pill">messaging</span></small>
          </div>
          <p class="mb-1">Send SMS to all operators in Indonesia at no charge. this tool is equipped with the completion of automatic captcha. After 5 times you have to wait 3 minutes to send the message again</p>
        </a>
        <a href="/tools/guard.php" class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h4 class="mb-1">Profile Guard</h4>
            <small><span class="badge badge-primary badge-pill">facebook</span></small>
          </div>
          <p class="mb-1"><small>note: we don't store any data that you provide</small></p>
        </a>
        <a href="/tools/token.php" class="list-group-item list-group-item-action flex-column align-items-start">
          <div class="d-flex w-100 justify-content-between">
            <h4 class="mb-1">Access Token Generator</h4>
            <small><span class="badge badge-primary badge-pill">facebook</span></small>
          </div>
          <p class="mb-1"><small>note: we don't store any data that you provide</small></p>
        </a>
      </ul>
      <script>
        function Search() {
          // Declare variables
          var input, filter, ul, li, a, i, txtValue;
          input = document.getElementById('tanya');
          filter = input.value;
          ul = document.getElementById("daftar");
          li = ul.getElementsByTagName('a');

          // Loop through all list items, and hide those who don't match the search query
          for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName("h4")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.indexOf(filter) > -1) {
              li[i].style.display = "";
            } else {
              li[i].style.display = "none";
            }
          }
        }
      </script>

      <hr>
      <center>
        <p><i class="fa fa-facebook-official"></i><a href="https://m.facebook.com/zvtyrdt.id"> Val</a></p>
      </center>
    </div>
  </body>
</html>
