@extends('Dashboard.layout.layout2')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body row" style="font-size: 16px">
                                    <div class="col-lg-6">
                                        <strong>Welcome back, </strong>{{ auth()->user()->name }}
                                    </div>
                                    <div class="col-lg-6 text-right" style="font-size: 20px">
                                        <form action="{{ route('logout') }}" method="post">
                                            @csrf
                                            <button class="btn">logout</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .row -->
                </div><!-- .nk-block -->
            </div>
        </section>
        <!-- /.content -->
    </div>
@endsection
