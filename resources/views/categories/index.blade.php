<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">

      <title>{{ config('app.name') }}</title>

      <script src="{{ asset('js/app.js') }}" defer></script>

      <!-- Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

      <link rel="stylesheet" href="{{ asset('css/app.css') }}">
           <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font-awesome.min.css')}}">
        <link rel= "stylesheet" type="text/css" href="{{asset('assets/css/animate.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/font.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">

        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/li-scroller.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/slick.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/jquery.fancybox.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/theme.css')}}">
    </head>
    <body>
        <nav class="navbar navbar- navbar-static-top  navbar-inverse" style="font-size: 20px ;">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ol class="navbar-nav mr-auto">
                 

                  <li class="nav-item active">
                      <a class="nav-link" href="{{ route('category.index') }}">Categories <span class="sr-only">(current)</span></a>
                  </li>
              </ol>

              <ol class="navbar-nav ml-auto">
                @guest
                  
                @else
                    <li class="nav-item">
                        <a href="{{ route('post.create') }}" class="btn btn-success my-2 my-sm-0">Create Post</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ol>
              
          </div>
      </nav>

      @if (Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Success!</h4>
                <p>{{ Session::get('success') }}</p>

                <button type="button" class="close" data-dismiss="alert aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if (Session::has('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Error!</h4>
                <p>
                    <ol>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ol>
                </p>

                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

          <div class="container py-3">

            <div class="modal" tabindex="-1" role="dialog" id="editCategoryModal">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <form action="" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                      <div class="form-group">
                        <input type="text" name="name" class="form-control" value="" placeholder="Category Name" required>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>
                  </form>
              </div>
            </div>

          <div class="row">
            <div class="col-md-8">

              <div class="card">
                <div class="card-header">
                  <h3>Categories</h3>
                </div>
                <div class="card-body">
                  <ol class="list-group">
                    @foreach ($categories as $category)
                      <li class="list-group-item">
                        <div class="d-flex justify-content-between">
                          {{ $category->name }}

                          <div class="button-group d-flex">
                            <button type="button" class="btn btn-sm btn-primary mr-1 edit-category" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $category->id }}" data-name="{{ $category->name }}">Edit</button>

                            <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                              @csrf
                              @method('DELETE')

                              <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                          </div>
                        </div>

                        @if ($category->children)
                          <ol class="list-group mt-2">
                            @foreach ($category->children as $child)
                              <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                  {{ $child->name }}

                                  <div class="button-group d-flex">
                                    <button type="button" class="btn btn-sm btn-primary mr-1 edit-category" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $child->id }}" data-name="{{ $child->name }}">Edit</button>

                                    <form action="{{ route('category.destroy', $child->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')

                                      <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                  </div>
                                </div>
                              </li>
                               @if ($child->children)
                              <ol class="list-group mt-2">
                                @foreach ($child->children as $ch)
                              <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                  {{ $ch->name }}

                                  <div class="button-group d-flex">
                                    <button type="button" class="btn btn-sm btn-primary mr-1 edit-category" data-toggle="modal" data-target="#editCategoryModal" data-id="{{ $ch->id }}" data-name="{{ $ch->name }}">Edit</button>

                                    <form action="{{ route('category.destroy', $ch->id) }}" method="POST">
                                      @csrf
                                      @method('DELETE')

                                      <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                  </div>
                                </div>
                              </li>
                               @endforeach
                              </ol>
                              @endif
                            @endforeach
                          </ol>
                        @endif
                      </li>
                    @endforeach
                  </ol>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                <div class="card-header">
                  <h3>Create Category</h3>
                </div>

                <div class="card-body">
                  <form action="{{ route('category.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                      <select class="form-control" name="parent_id">
                        <option value="">Select Parent Category</option>

                        @foreach ($cat as $cat)
                          <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                      </select>
                    </div>

                    <div class="form-group">
                      <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Category Name" required>
                    </div>

                    <div class="form-group">
                      <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

<form action="{{ route('category.destroy', $category->id) }}" method="POST">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
</form>
        <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>

        <script type="text/javascript">
          $('.edit-category').on('click', function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var url = "{{ url('category') }}/" + id;

            $('#editCategoryModal form').attr('action', url);
            $('#editCategoryModal form input[name="name"]').val(name);
          });
        </script>
<script type="text/javascript">
    $('.edit-category').on('click', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var url = "{{ url('category') }}/" + id;

        $('#editCategoryModal form').attr('action', url);
        $('#editCategoryModal form input[name="name"]').val(name);
    });
</script>
 <script src="{{asset('assets/js/jquery.min.js')}}"></script> 
            <script src="{{asset('assets/js/wow.min.js')}}"></script> 
            <script src="{{asset('assets/js/bootstrap.min.js')}}"></script> 
            <script src="{{asset('assets/js/slick.min.js')}}"></script> 
            <script src="{{asset('assets/js/jquery.li-scroller.1.0.js')}}"></script> 
            <script src="{{asset('assets/js/jquery.newsTicker.min.js')}}"></script> 
            <script src="{{asset('assets/js/jquery.fancybox.pack.js')}}"></script> 
            <script src="{{asset('assets/js/custom.js')}}"></script>
    </body>
</html>