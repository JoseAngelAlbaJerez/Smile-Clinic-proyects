<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Smile Clinic</title>
   
  
    <!-- End layout styles -->
    <link rel="shortcut icon" href="admin/images/favicon.ico" />
    <style>
        body, html{
            overflow-x: hidden;
            padding-right: 0 !important;
        }
        body{
            font-size: 1rem;
            font-family: "ubuntu-regular", sans-serif;
            font-weight: initial;
            line-height: normal;
            -webkit-font-smoothing: anitaliased;
            background-color:var(--background);
            color: var(--txt);
            align-items: center;
        }
        h1{
            font-size: 12rem;
            margin-bottom: 0 !important;
            font-weight: 300;
            line-height: 1.2;
            margin-top: 150px;
        }
        a{
            text-decoration: underline;
            color: var(--txt);
        }
    

        
    </style>
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center text-center error-page bg-primary">
          <div class="row flex-grow">
            <div class="col-lg-7 mx-auto text-white">
              <div class="row align-items-center d-flex flex-row">
                <center>
                <div class="col-lg-6 text-lg-right pr-lg-4">
                  <h1 class="display-1 mb-0">404</h1>
                </div>
                <div class="col-lg-6 error-page-divider text-lg-left pl-lg-4">
                  <h2>LO SENTIMOS !</h2>
                  <h3 class="font-weight-light">La Pagina que estas buscando no existe.</h3>
                
                </div>
              </div>
              <div class="row mt-5">
                <div class="col-12 text-center mt-xl-2">
                    <center>
                  <a class="text-white font-weight-medium" href="{{route('home')}}">Volver al Inicio</a>
                  </center>  </div>
              </div>
              <div class="row mt-5">
                <div class="col-12 mt-xl-2">
                </center>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
 
  </body>
</html>