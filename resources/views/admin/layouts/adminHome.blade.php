@extends('admin.layouts.appAdmin')

@section('title','Pagrindinis')
@section('content')
    <div class="container-fluid">
        <h2>Sveiki, {{ auth()->user()->name }}!</h2>

        <div class="row mt-4 cardRow">
            <div class="col-md-6 mb-3 cardColumn">
                <div class="card text-white admin-card price">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">Sumokėta už stovyklas</h5>
                                <h3 class="card-title">{{ App\Models\Camp::calculateTotalPayments() }} €</h3>
                            </div>
                            <div class="col-md-6">
                                <i class="bi bi-tags-fill admin-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 cardColumn">
                <div class="card text-white admin-card price">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="card-title">Visos narystės baigia galioti</h5>
                                <h3 class="card-title">{{ date('Y') }}-12-31</h3>
                            </div>
                            <div class="col-md-6">
                                <i class="bi bi-calendar-fill admin-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 cardRow">
            <div class="col-md-3 mb-3 cardColumn">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="card text-white admin-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Nariai</h5>
                                    <h3 class="card-title">{{ count($memberships) }}</h3>
                                </div>
                                <div class="col-md-6">
                                    <i class="bi bi-people-fill admin-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-3 cardColumn">
                <a href="{{ route('admin.camps.index') }}" class="text-decoration-none">
                    <div class="card text-white admin-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Stovyklos</h5>
                                    <h3 class="card-title">{{ count($camps) }}</h3>
                                </div>
                                <div class="col-md-6">
                                    <i class="bi bi-tree-fill admin-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3 cardColumn">
                <a href="{{ route('admin.articles.index') }}" class="text-decoration-none">
                    <div class="card text-white admin-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Straipsniai</h5>
                                    <h3 class="card-title">{{ count($articles) }}</h3>
                                </div>
                                <div class="col-md-6">
                                    <i class="bi bi-newspaper admin-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3 cardColumn">
                <a href="{{ route('admin.gallery.index') }}" class="text-decoration-none">
                    <div class="card text-white admin-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Galerijos</h5>
                                    <h3 class="card-title">{{ count($galleries) }}</h3>
                                </div>
                                <div class="col-md-6">
                                    <i class="bi bi-image-fill admin-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3 cardColumn">
                <a href="{{ route('admin.camps.programmes.index') }}" class="text-decoration-none">
                    <div class="card text-white admin-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Stovyklų programos</h5>
                                    <h3 class="card-title">{{ count($programmes) }}</h3>
                                </div>
                                <div class="col-md-6">
                                    <i class="bi bi-list-check admin-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-3 cardColumn">
                <a href="{{ route('admin.feedbacks.index') }}" class="text-decoration-none">
                    <div class="card text-white admin-card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="card-title">Atsiliepimai</h5>
                                    <h3 class="card-title">{{ count($feedbacks) }}</h3>
                                </div>
                                <div class="col-md-6">
                                    <i class="bi bi-star-fill admin-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
