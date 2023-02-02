@extends('layouts.master')
@section('content')

<div class="panel panel-headline">
    <div class="panel-loader">
        <div class="loader4"></div>
    </div>
    <div class="panel-heading">
        <h3 class="panel-title">3 Grid Banner</h3>
    </div>
    <div class="panel-body">
        <div class="banner-grid3-wrapper">
            <div class="main-banner-wrapper grid3-main banner-order-0">
                <img src="{{ asset('assets/images/grey.jpg') }}" class="img-banner">
                <div class="main-banner-overlay">
                    <button class="btn-overlay edit" data-toggle="modal" data-target="#modalEditBanner" data-type="banner_grid_3" data-order="0"><i class="far fa-pen"></i></button>
                </div>
            </div>
            <div class="main-banner-wrapper grid3-child banner-order-1">
                <img src="{{ asset('assets/images/grey.jpg') }}" class="img-banner">
                <div class="main-banner-overlay">
                    <button class="btn-overlay edit" data-toggle="modal" data-target="#modalEditChildBanner" data-type="banner_grid_3" data-order="1"><i class="far fa-pen"></i></button>
                </div>
            </div>
            <div class="main-banner-wrapper grid3-child banner-order-2">
                <img src="{{ asset('assets/images/grey.jpg') }}" class="img-banner">
                <div class="main-banner-overlay">
                    <button class="btn-overlay edit" data-toggle="modal" data-target="#modalEditChildBanner" data-type="banner_grid_3" data-order="2"><i class="far fa-pen"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="panel panel-headline">
    <div class="panel-loader">
        <div class="loader4"></div>
    </div>
    <div class="panel-heading">
        <h3 class="panel-title">2 Grid Banner</h3>
    </div>
    <div class="panel-body">
        <div class="banner-grid2-wrapper">
            <div class="main-banner-wrapper grid2-main banner-order-0">
                <img src="{{ asset('assets/images/grey.jpg') }}" class="img-banner">
                <div class="main-banner-overlay">
                    <button class="btn-overlay edit" data-toggle="modal" data-target="#modalEditBanner" data-type="banner_grid_2" data-order="0"><i class="far fa-pen"></i></button>
                </div>
            </div>
            <div class="main-banner-wrapper grid2-main banner-order-1">
                <img src="{{ asset('assets/images/grey.jpg') }}" class="img-banner">
                <div class="main-banner-overlay">
                    <button class="btn-overlay edit" data-toggle="modal" data-target="#modalEditBanner" data-type="banner_grid_2" data-order="1"><i class="far fa-pen"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditBanner" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-banner-content" role="document">
        <div class="modal-content">
            <input type="hidden" class="banner_type">
            <input type="hidden" class="banner_order">
            <img src="{{ asset('assets/images/grey.jpg') }}" class="img-banner-modal">
            <div class="img-banner-tools">
                <span>Resolution : 1000 x 500 (Pixel)</span>
                <button class="btn btn-warning" id="edit-banner-choose-file">Pilih file</button>
                <input type="file" id="edit-banner-file" class="input-file-hidden">
                <span class="img-file-invalid" id="edit-banner-file-invalid"><i class="far fa-info-circle"></i> Image resolution doesn't match</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-banner-edit" disabled="true">Save changes</button>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="modal fade" id="modalEditChildBanner" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-banner-content" role="document">
        <div class="modal-content">
            <input type="hidden" class="banner_type">
            <input type="hidden" class="banner_order">
            <img src="{{ asset('assets/images/grey.jpg') }}" class="img-banner-modal">
            <div class="img-banner-tools">
                <span>Resolution : 1000 x 240 (Pixel)</span>
                <button class="btn btn-warning" id="edit-child-banner-choose-file">Pilih file</button>
                <input type="file" id="edit-child-banner-file" class="input-file-hidden">
                <span class="img-file-invalid" id="edit-child-banner-file-invalid"><i class="far fa-info-circle"></i> Image resolution doesn't match</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-child-banner-edit" disabled="true">Save changes</button>
            </div>
        </div>
    </div>
    </div>
</div>

@endsection
