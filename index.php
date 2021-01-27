<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"                    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <style>

      html {
        background: url('images/backgroundcompressed.jpeg') no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
      }

      #hello {
        background: none;
      }

      #header-text {
        width: 100%;
        text-align: center;
        background-color: transparent;
        position: absolute;
        color: #373a3c;
        display: block;
        padding-top: 25vh;
        height: 15vh;
      }

      .form-wrapper {
        width: 100%;
        position: absolute;
        top: 38vh;
        height: 15vh;
      }

      form {
        left: calc(50% - 140px);
      }

      h1 {
        font-size: 30px;
        font-weight: 500;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        margin-bottom: 4px;
      }

      p {
        font-size: 16px;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        margin-bottom: 8px;
      }

      .form-group {
        position: relative;
        width: 100%;
        margin-bottom: 12px;
      }

      input {
        position: relative;
        display: inline-block;
        max-width: 280px;
        left: calc(50% - 140px);
      }


      .btn-primary {
        display: inline-block;
        width: 80px;
        left: calc(50% - 40px);
        position: relative;
      }

      .message {
        position: absolute;
        left: calc(50% - 140px);
        top: 55vh;
      }

      .forecast {
        width: 280px;
      }

      .alert-warning,
      .alert-danger {
        text-align: center;
      }

      @media (min-width: 500px) {
        #header-text {
        padding-top: 2vh;
        height: 10vh;
        }
        .form-wrapper {
        top: 27vh;
        height: 10vh;
        }
        .message {
        left: calc(50% - 240px);
        top: 56vh;
        }
        .forecast {
        width: 480px;
        }
      }

      @media (min-width: 768px) {
        h1 {
        font-size: 40px;
        }
        input {
        min-width: 420px;
        left: calc(50% - 210px);
        }
        .form-wrapper {
        top: 35vh;
        }
        .btn-primary {
        left: calc(50% - 40px);
        }
        #header-text {
        padding-top: 25vh;
        }
        .message {
        left: calc(50% - 210px);
        top: 45vh;
        }
        .forecast {
        position: absolute;
        width: 420px;
        /* left: calc(50% - 210px);
        top: 45vh; */
        left: 0;
        }
        
      }

      @media (min-width: 992px) {
        .form-wrapper {
        top: 38vh;
        }
        .message {
        left: calc(50% - 210px);
        top: 54vh;
        }
        .forecast {
        position: absolute;
        width: 420px;
        /* left: calc(50% - 210px);
        top: 55.5vh; */
        }
        
      }

    </style>

  <title>PHP Weather Scraper</title>
</head>
<body>

<?php
      $successAlert = $forgotAlert = $wrongAlert = $citySearch = "";
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $citySearch = $_POST["city"];
          $citySearch = preg_replace('/\s+/', '', $citySearch);
          $url = "http://completewebdevelopercourse.com/locations/".$citySearch;
          $contents = @file_get_contents($url);
          if ($contents == '' and $citySearch != '') {
              $wrongAlert = "<p class='alert alert-danger forecast' role='alert'>That city could not be found</p>";
          } elseif ($citySearch == '' and $contents == '') {
              $forgotAlert = "<p class='alert alert-warning forecast' role='alert'>You forgot to enter a city</p>";
          } else {
              $classname = 'phrase';
              $dom  = new DOMDocument('1.0', 'UTF-8');
              libxml_use_internal_errors(true);
              $dom->loadHTML($contents);
              libxml_clear_errors();
              $xpath = new DOMXPath($dom);
              $results = $xpath->query("//*[@class='" . $classname . "']");
              if ($results->length > 0) {
                  $weather = $results->item(0)->nodeValue;
                  $successAlert = "<p class='alert alert-success forecast' role='alert'>".$weather."</p>";
              };
              $tags = $dom->getElementsByTagName('title');
              $alts = $tags->item(0)->nodeValue;
          }
      };
    ?>

<header>
      <div id='header-text'>
        <h1>What's The Weather?</h1>
        <p>Enter the name of a city.</p>
      </div>
        <div class='form-wrapper'>
        <form method='POST'>
          <div class="form-group">
            <input autocomplete="off" type="text" class="form-control" name="city" id="city" placeholder='e.g. London, Paris' value='<?php echo $alts; ?>'>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
        <div id='success-alert' class='message'><?= $successAlert ?></div>
        <div id='forgot-alert' class='message'><?= $forgotAlert ?></div>
        <div id='wrong-alert' class='message'><?= $wrongAlert ?></div>
    </header>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <script>
    if ( window.history.replaceState ) {
      window.history.replaceState( null, null, window.location.href );
    }

    document.getElementById('city').onfocus = function () {
      let successAlert = document.getElementById('success-alert');
      let forgotAlert = document.getElementById('forgot-alert');
      let wrongAlert = document.getElementById('wrong-alert');
      if (successAlert.innerHTML != '' || forgotAlert.innerHTML != '' || wrongAlert.innerHTML != '') {
        // emailErrorDiv.style.opacity = 0;
        setTimeout(function () {
          successAlert.innerHTML = '';
          forgotAlert.innerHTML = '';
          wrongAlert.innerHTML = '';
        }, 500);
      }
    };

    function hideMessage() {
      let hideForgot = document.getElementById('forgot-alert').style.display = 'none';
      let hideWrong = document.getElementById('wrong-alert').style.display = 'none';
    };
    setTimeout(hideMessage, 3000);
    </script>

</body>
</html>