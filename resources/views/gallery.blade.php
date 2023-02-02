@extends('layouts.master')
@section('content')

<div class="panel panel-headline">
    <div class="panel-loader">
        <div class="loader4"></div>
    </div>

    <div class="panel-body">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <p>Description</p>
                <textarea class="form-control" id="gallery-description" placeholder="Description ..." rows="4" style="resize: none;"></textarea>
                <br>
                <div style="display: flex; justify-content: space-between;">
                    <label class="fancy-checkbox" style="margin-bottom: 0" data-toggle="tooltip" data-placement="right" title="Show gallery description on customer page">
                        <input type="checkbox" id="show-description">
                        <span>Show description</span>
                    </label>
                    <button type="button" class="btn btn-primary" id="btn-update-description">Update description</button>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="panel-heading">
        <h3 class="panel-title">Galery</h3>
        <div class="right">
            <button class="add-product" data-toggle="modal" data-target="#modalAddGallery"><i class="far fa-plus"></i> Add Galery</button>
        </div>
    </div>
    <div class="panel-body">
        <div class="product-wrapper" id="gallery-data">

        </div>
    </div>
    <br>
</div>

<div class="modal fade" id="modalAddGallery" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" id="add-gallery">
                <div class="upload-images">
                    <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview gallery" id="add-thumbnail-gallery-preview">
                    <span>Resolution : 400 x 200 (Pixel)</span>
                    <button class="btn btn-warning choose-image">Choose thumbnail</button>
                    <input type="file" class="choose-image-file required" id="add-thumbnail-gallery" style="display: none;">
                </div>
                <p>Link youtube</p>
                <input type="text" id="link-youtube" class="form-control required" placeholder="Contoh : https://www.youtube.com/watch?v=GPQh6CxTog5">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-add-gallery" type="submit" class="btn btn-success" disabled>Add Gallery</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditGallery" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" id="edit-gallery">
                <input type="hidden" id="edit-gallery-id">
                <div class="upload-images">
                    <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview gallery" id="edit-thumbnail-gallery-preview">
                    <span>Resolution : 400 x 200 (Pixel)</span>
                    <button class="btn btn-warning choose-image">Pilih thumbnail</button>
                    <input type="file" class="choose-image-file" id="edit-thumbnail-gallery" style="display: none;">
                </div>
                <p>Link youtube</p>
                <input type="text" id="edit-link-youtube" class="form-control required" placeholder="Example : https://www.youtube.com/watch?v=GPQh6CxTog5">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-edit-gallery" type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteGallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" style="margin-top: 3rem">Yakin ingin menghapus galery ?</h4>
                <input type="hidden" id="delete-gallery-id">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-gallery">Hapus</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
