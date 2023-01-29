@extends('layouts.master')
@section('content')

<div class="panel panel-headline">
    <div class="panel-loader">
        <div class="loader4"></div>
    </div>
    <div class="panel-heading">
        <h3 class="panel-title">Main Banner</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <p>Title</p>
                <input type="text" class="form-control" id="title" placeholder="Title ...">
                <br>
                <p>Description</p>
                <textarea class="form-control" id="description" placeholder="Description ..." rows="4" style="resize: none;"></textarea>
                <br>
            </div>
            <div class="col-sm-12 col-md-6" id="main-banner-width">
                <div class="main-banner-wrapper" id="main-banner-wrapper">
                    <img src="" class="img-banner" id="img-main-banner">
                    <div class="main-banner-overlay" id="main-banner-overlay">
                        <button class="btn-overlay edit" id="main-banner-edit-choose-file"><i class="far fa-pen"></i></button>
                        <input type="file" id="main-banner-edit-file" class="input-file-hidden">
                    </div>
                </div>
                <div class="img-banner-tools" style="padding-bottom: 0;">
                    <span>Landing page banner</span>
                    <span>Minimum resolution : 1920 x 1080 (Pixel)</span>
                    <span class="img-file-invalid"><i class="far fa-info-circle"></i> Image resolution doesn't match</span>
                </div>
            </div>
        </div>
        <br>
        <button type="button" class="btn btn-primary" id="btn-save-banner-edit" style="float: right;">Save changes</button>
    </div>
    <br>
</div>

{{-- <div class="modal fade" id="modalEditMainBanner" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-banner-content" role="document">
        <div class="modal-content">
            <img src="{{ asset('assets/images/grey.jpg') }}" class="img-banner-modal">
            <div class="img-banner-tools">
                <span>Resolusi gambar : 1920 x 1080 (Pixel)</span>
                <button class="btn btn-warning" id="main-banner-edit-choose-file">Pilih file</button>
                <input type="hidden" id="edit-banner-id">
                <input type="file" id="main-banner-edit-file" class="input-file-hidden">
                <span class="img-file-invalid"><i class="far fa-info-circle"></i> Image resolution doesn't match</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-banner-edit" disabled="true">Save changes</button>
            </div>
        </div>
    </div>
    </div>
</div> --}}

{{-- <div class="modal fade" id="modalDeleteMainBanner" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-banner-content" role="document">
        <div class="modal-content">
            <img src="{{ asset('assets/images/grey.jpg') }}" class="img-banner-modal">
            <div class="img-banner-tools">
                <span>Delete this banner ?</span>
                <input type="hidden" id="delete-banner-id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="btn-delete-banner">Delete</button>
            </div>
        </div>
    </div>
    </div>
</div> --}}

@endsection
