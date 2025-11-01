<!-- Content Header (Page header) -->
<?php
$breadcumes = explode("/", $slot);
// dd($slot);
// dd($slot);
?>

<div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0">{{ Str::ucfirst($breadcumes[1]) }}</h1>
                {{-- <h1 class="m-0"></h1><parent>{{ $slot }}</parent></h1> --}}
              </div>
              <!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  @foreach($breadcumes as $breadcume)
                    <li class="breadcrumb-item active"><a href="#">{{ $breadcume }}</a></li>
                  @endforeach
                  {{-- <li class="breadcrumb-item"><a href="#">{{ $breadcumes[0] }}</a></li>
                  <li class="breadcrumb-item active">{{ $breadcumes[1] }}</li> --}}
                </ol>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->