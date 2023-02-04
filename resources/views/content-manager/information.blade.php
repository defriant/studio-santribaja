@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-12 col-lg-12">
        <div class="panel panel-headline">
            <div class="panel-loader" id="panel-loader-general">
                <div class="loader4"></div>
            </div>
            <div class="row" id="general-information">
                <div class="col-12 col-md-6">
                    <div class="panel-heading">
                        <h3 class="panel-title">General Information</h3>
                    </div>
                    <div class="panel-body">
                        <p>Email</p>
                        <input type="text" id="email" class="form-control required">
                        <br>
                        <p>Phone</p>
                        <input type="text" id="telepon" class="form-control required">
                        <br>
                        <p>Logo</p>
                        <div class="logo-wrapper" style="width: 150px; height: 150px">
                            <img src="{{ asset('assets/images/logo.png?v='.filemtime(public_path('assets/images/logo.png'))) }}" class="img-preview">
                            <div class="logo-overlay">
                                <button class="btn-overlay edit img-btn"><i class="far fa-pen"></i></button>
                            </div>
                            <input type="file" class="input-file-hidden img-file" id="logo" data-width="200" data-height="200" data-value="" data-accept=".png" accept="image/png">
                        </div>
                        <p class="text-note">Resolution : 200 x 200 (Pixel) | File format (.png)</p>
                        <br>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="panel-heading">
                        <h3 class="panel-title">Social Media</h3>
                    </div>
                    <div class="panel-body">
                        <p>Facebook Link</p>
                        <input type="text" id="facebook" class="form-control required">
                        <br>
                        <p>Instagram Link</p>
                        <input type="text" id="instagram" class="form-control required">
                        <br>
                        <p>Youtube Link</p>
                        <input type="text" id="youtube" class="form-control required">
                        <br>
                        <p>Whatsapp Link</p>
                        <input type="text" id="whatsapp" class="form-control required">
                        <br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="panel-footer" style="display: flex">
                    <button class="btn btn-primary" id="btn-general-save" style="margin-left: auto" disabled>Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-12">
        <div class="panel panel-headline">
            <div class="panel-loader" id="panel-loader-about">
                <div class="loader4"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel-heading">
                        <h3 class="panel-title">About Us</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-8">
                                <p style="margin-bottom: 1.5rem">Tell people about Santri Baja Indonesia :</p>
                                <textarea class="form-control" id="about-us" placeholder="About santri baja indonesia ..."></textarea>
                            </div>

                            <div class="col-sm-12 col-md-8">
                                <br>
                                <button class="btn btn-primary" id="btn-about-save" style="float: right;" disabled>Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="panel-body">
                        <div style="margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
                            <p style="margin: 0">Images</p>
                            <button class="add-kategori" data-toggle="modal" data-target="#modalAddAboutImages"><i class="far fa-plus" style="padding-top: 2px"></i></button>
                        </div>
                        <div class="product-wrapper" id="about-images">
                            
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddAboutImages" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" id="add-gallery">
                <div class="upload-images">
                    <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview" style="width: 200px; height: 200px" id="add-about-image-preview">
                    <span>Resolution : 500 x 500 (Pixel)</span>
                    <button class="btn btn-warning choose-image">Choose image</button>
                    <input type="file" class="choose-image-file required" id="add-about-image" style="display: none;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-add-about-image" type="submit" class="btn btn-success" disabled>Add</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateAboutImage" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" id="update-about-image-id">
                <input type="hidden" id="update-about-image-current">
                <div class="upload-images">
                    <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview" style="width: 200px; height: 200px" id="update-about-image-preview">
                    <span>Resolution : 500 x 500 (Pixel)</span>
                    <button class="btn btn-warning choose-image">Choose image</button>
                    <input type="file" class="choose-image-file required" id="update-about-image" style="display: none;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-update-about-image" type="submit" class="btn btn-primary" disabled>Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteAboutImages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" style="margin-top: 3rem">Delete this image ?</h4>
                <input type="hidden" id="delete-about-image-id">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-about-image">Delete</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
