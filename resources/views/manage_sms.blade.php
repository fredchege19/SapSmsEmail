
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Sap &rsaquo; SMS &mdash; Email</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="../assets/css/style.css">
  <link rel="stylesheet" href="../assets/css/components.css">
</head>

<body>
  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>

          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Messages


            </div>
          </li>
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Notifications


            </div>
          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::User()->name}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <div class="dropdown-divider"></div>
              <a href="logout" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>
    @include('partials.sidemenu')

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>SMS Management</h1>
          </div>

          <div class="section-body">

            <div class="row">
              <div class="col-12 ">
                <div class="card">
                  <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">All SMS</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Pending  SMS</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Sent SMS</a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                      <div class="">
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                <th>#</th>
                                <th>CardCode</th>
                                <th>CardName</th>
                                <th>Phone</th>
                                <th>Doc Type</th>
                                <th>Doc Num</th>
                                <th>Status</th>
                                </tr>
                                @foreach($allSms as $all)
                                <tr>
                                <td>{{$all->Id}}</td>
                                <td>{{$all->CardCode}}</td>
                                <td>{{$all->CardName}}</td>
                                <td>{{$all->Cellular}}</td>
                                <td>{{$all->DocType}}</td>
                                <td>{{$all->DocNum}}</td>
                                @if($all->Status == 0)
                                <td><div class="badge badge-success">Delivered</div></td>
                                @else
                                <td><div class="badge badge-warning">Not Sent</div></td>
                                </tr>
                                @endif
                                @endforeach
                            </table>
                            </div>
                        </div>

                    </div>
                      </div>
                      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                      <div class="">
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                <th>#</th>
                                <th>CardCode</th>
                                <th>CardName</th>
                                <th>Phone</th>
                                <th>Doc Type</th>
                                <th>Doc Number</th>
                                <th>Action <span id="loader" style="Visibility:hidden;"><i class="fa fa-spinner fa-2x fa-spin"></i></span></th>
                                </tr>
                                @foreach($pendingSms as $all)
                                <tr>
                                <td>{{$all->Id}}</td>
                                <td>{{$all->CardCode}}</td>
                                <td>{{$all->CardName}}</td>
                                <td>{{$all->Cellular}}</td>
                                <td>{{$all->DocType}}</td>
                                <td>{{$all->DocNum}}</td>
                                <td><a href="#" onClick="sendSms({{$all->Id}})" class="btn btn-primary">Send</a> </td>
                                @endforeach
                            </table>
                            </div>
                        </div>
                      </div>
                      </div>
                      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                      <div class="">
                        <div class="card-body">
                            <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <tr>
                                <th>#</th>
                                <th>CardCode</th>
                                <th>CardName</th>
                                <th>Phone</th>
                                <th>Doc Type</th>
                                <th>Doc Number</th>
                                <th>Status</th>
                                </tr>
                                @foreach($sentSms as $all)
                                <tr>
                                <td>{{$all->Id}}</td>
                                <td>{{$all->CardCode}}</td>
                                <td>{{$all->CardName}}</td>
                                <td>{{$all->Cellular}}</td>
                                <td>{{$all->DocType}}</td>
                                <td>{{$all->DocNum}}</td>
                                @if($all->Status == 0)
                                <td><div class="badge badge-success">Delivered</div></td>
                                @else
                                <td><div class="badge badge-warning">Not Sent</div></td>
                                </tr>
                                @endif
                                @endforeach
                            </table>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </section>
      </div>
  @include('partials.footer')
    </div>
  </div>

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="../assets/js/stisla.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="../assets/js/scripts.js"></script>
  <script src="../assets/js/custom.js"></script>
  <script>
    function sendSms(id) {
        var custId = id;
        var token = $("input[name='_token']").val();
        $.ajax({
        url: 'sendSms/'+id,
          method: 'GET',
          dataType:"json",
          beforeSend: function(){
                    $('#loader').css("visibility", "visible");
                },
          success: function(data) {
            console.log('Completed');
            $('#loader').css("visibility", "hidden");
            alert('SMS Has Been Sent Successfully');
            location.reload();
            return false;

          }
      });
    }
  </script>

  <!-- Page Specific JS File -->
</body>
</html>
