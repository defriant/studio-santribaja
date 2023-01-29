@extends('layouts.master')
@section('content')

<div class="panel panel-headline">
    <div class="panel-loader">
        <div class="loader4"></div>
    </div>
    <div class="panel-heading border-bottom">
        <h3 class="panel-title">Category Manager</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6">
                <p>Description</p>
                <textarea class="form-control" id="category-description" placeholder="Description ..." rows="4" style="resize: none;"></textarea>
                <br>
                <div style="display: flex; justify-content: space-between;">
                    <label class="fancy-checkbox" style="margin-bottom: 0" data-toggle="tooltip" data-placement="bottom" title="Show category description on customer page">
                        <input type="checkbox" id="show-description">
                        <span>Show description</span>
                    </label>
                    <button type="button" class="btn btn-primary" id="btn-update-description">Update description</button>
                </div>
            </div>
        </div>
        <hr>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <p style="margin: 0; font-weight: normal; font-size: 16px">Categories</p>
            <button class="add-kategori" data-toggle="modal" data-target="#modalAddKategori"><i class="far fa-plus" style="padding-top: 2px"></i></button>
        </div>
        <br>
        <div class="kategori-wrapper" id="kategori-data">
            
        </div>
    </div>
    <br>
</div>

<div class="panel panel-headline">
    <div class="panel-loader">
        <div class="loader4"></div>
    </div>
    <div class="panel-heading border-bottom">
        <h3 class="panel-title">Product Manager</h3>
        <div class="right custom-right">
            <button class="add-product" data-toggle="modal" data-target="#modalAddProduct"><i class="far fa-plus"></i> Add Product</button>
        </div>
    </div>
    <div class="panel-body">
        <div class="product-wrapper" id="product-data">
            
        </div>
    </div>
    <br>
</div>

<div class="modal fade" id="modalAddKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-banner-content" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create new category</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="upload-images">
                            <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview category-preview" id="category-image-preview">
                            <span>Minimum resolution : 525 x 700 (Pixel)</span>
                            <button class="btn btn-warning choose-image-category">Choose category image</button>
                            <input type="file" class="choose-image-file-category required" id="category-image" style="display: none;">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <p>Category name</p>
                        <input type="text" class="form-control" id="add-kategori-name" placeholder="Enter category name">
                    </div>
                </div>
            </div>
            <br>
            <div class="modal-header">
                <h4 class="modal-title">Add product to this category</h4>
            </div>
            <div class="modal-body">
                <div class="modal-loader" id="add-product-to-category-loader">
                    <div class="loader4"></div>
                </div>
                <div id="add-product-to-category-data">
                    
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="btn-add-kategori">Create</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="upload-images">
                            <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview category-preview" id="update-category-image-preview">
                            <span>Minimum resolution : 525 x 700 (Pixel)</span>
                            <button class="btn btn-warning choose-image-update-category">Choose category image</button>
                            <input type="file" class="choose-image-update-file-category required" id="update-category-image" style="display: none;">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <p>Category name</p>
                        <input type="text" class="form-control" id="update-kategori-name">
                    </div>
                </div>
                <input type="hidden" id="update-kategori-id">
                <input type="hidden" id="current-category-image">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-save-kategori">Update</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteKategori" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" style="margin-top: 3rem" id="delete-warning-message"></h4>
                <p class="text-center"><i class="far fa-info-circle"></i>&nbsp; Product in this category will not be deleted</p>
                <input type="hidden" id="delete-kategori-id">
                <input type="hidden" id="delete-kategori-name">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-kategori">Hapus</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalAddProduct" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-add-product">
                <div class="row">
                    <div class="col-12">
                        <div class="upload-images">
                            <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview">
                            <span>Minimum resolution : 500 x 500 (Pixel)</span>
                            <button class="btn btn-warning choose-image">Choose image</button>
                            <input type="file" class="choose-image-file required" id="add-image-1" style="display: none;">
                        </div>
                    </div>
                    {{-- <div class="col-xs-6 col-sm-4">
                        <div class="upload-images">
                            <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview">
                            <span>500 x 500</span>
                            <button class="btn btn-warning choose-image">Pilih file</button>
                            <input type="file" class="choose-image-file required" id="add-image-2" style="display: none;">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <div class="upload-images">
                            <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview">
                            <span>500 x 500</span>
                            <button class="btn btn-warning choose-image">Pilih file</button>
                            <input type="file" class="choose-image-file required" id="add-image-3" style="display: none;">
                        </div>
                    </div> --}}
                </div>

                <div class="produk-detail">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5>Category :</h5>
                            <select id="add-category" class="form-control">
                                
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <h5>Product name :</h5>
                            <input id="add-name" type="text" class="form-control required" autocomplete="off">
                        </div>
                    </div>
                    
                    <br>
                    <h5>Description :</h5>
                    <textarea id="add-description" class="form-control required" style="resize: none; height: 100px; overflow-y: auto"></textarea>

                    <br>
                    <h5>Specification :</h5>
                    <div class="input-group" id="add-specification-choose-file" style="cursor: pointer">
                        <span class="input-group-addon"><i class="fas fa-cloud-upload"></i></span>
                        <input type="text" class="form-control" autocomplete="off" readonly="true" placeholder="Choose file" style="background: #FFF; cursor: pointer">
                    </div>
                    <input type="file" id="add-specification" style="display: none">

                    <br>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <h5 id="tambah-loading" style="text-align: center; display: none;"><i class="fas fa-spinner fa-spin" style="margin-right: 5px"></i> Menambahkan</h5> --}}
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-add-product" type="submit" class="btn btn-success" disabled>Add Product</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateProduct" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body modal-update-product">
                <div class="row">
                    <div class="col-12">
                        <div class="upload-images">
                            <img src="" class="image-preview">
                            <span>Minimum resolution : 500 x 500 (Pixel)</span>
                            <button class="btn btn-warning choose-image">Choose image</button>
                            <input type="file" class="choose-image-file required" id="update-image-1" style="display: none;">
                        </div>
                    </div>
                    {{-- <div class="col-xs-6 col-sm-4">
                        <div class="upload-images">
                            <img src="" class="image-preview">
                            <span>500 x 500</span>
                            <button class="btn btn-warning choose-image">Pilih file</button>
                            <input type="file" class="choose-image-file required" id="update-image-2" style="display: none;">
                        </div>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <div class="upload-images">
                            <img src="" class="image-preview">
                            <span>500 x 500</span>
                            <button class="btn btn-warning choose-image">Pilih file</button>
                            <input type="file" class="choose-image-file required" id="update-image-3" style="display: none;">
                        </div>
                    </div> --}}
                </div>

                <div class="produk-detail">
                    <input type="hidden" id="update-id">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <h5>Kategori Produk :</h5>
                            <select id="update-category" class="form-control">
                                
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <h5>Nama Produk :</h5>
                            <input id="update-name" type="text" class="form-control required" autocomplete="off">
                        </div>
                    </div>
                    
                    <br>
                    <h5>Description :</h5>
                    <textarea id="update-description" class="form-control required" style="resize: none; height: 100px; overflow-y: auto"></textarea>

                    <br>
                    <h5>Specification :</h5>
                    <div style="display: flex; align-items: center; gap: 1.5rem">
                        <div class="input-group" id="update-specification-choose-file" style="cursor: pointer; width: 100%">
                            <span class="input-group-addon"><i class="fas fa-cloud-upload"></i></span>
                            <input type="text" class="form-control" autocomplete="off" readonly="true" placeholder="Choose file" style="background: #FFF; cursor: pointer">
                        </div>
                        <i class="fas fa-download" style="margin-right: .75rem; cursor: pointer; display: none;" id="update-specification-download"></i>
                    </div>
                    <input type="file" id="update-specification" style="display: none">
                </div>
            </div>
            <div class="modal-footer">
                <h5 id="tambah-loading" style="text-align: center; display: none;"><i class="fas fa-spinner fa-spin" style="margin-right: 5px"></i> Menambahkan</h5>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-update-product" type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" style="margin-top: 3rem" id="delete-product-warning-message"></h4>
                <input type="hidden" id="delete-product-id">
                <input type="hidden" id="delete-product-name">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-product">Hapus</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
