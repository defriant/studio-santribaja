@extends('layouts.master')
@section('content')
    
<div class="row">
    <div class="col-12 col-md-6 col-lg-5" style="display: flex; flex-direction: column;">
        <div class="panel panel-headline">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <p>Description</p>
                        <textarea class="form-control" id="album-description" placeholder="Description ..." rows="4" style="resize: none;"></textarea>
                        <br>
                        <div style="display: flex; justify-content: space-between;">
                            <label class="fancy-checkbox" style="margin-bottom: 0" data-toggle="tooltip" data-placement="right" title="Show album description on customer page">
                                <input type="checkbox" id="show-description">
                                <span>Show description</span>
                            </label>
                            <button type="button" class="btn btn-primary" id="btn-update-description">Update description</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Post Album</h3>
            </div>
            <div class="panel-body" id="post-album">
                <div class="upload-images">
                    <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview post-album" id="add-post-image-preview">
                    <span>Minimum resolution : 400 x 400 (Pixel)</span>
                    <button class="btn btn-warning choose-image">Choose poster</button>
                    <input type="file" class="choose-image-file required" id="post-album-image" style="display: none;">
                </div>
                <textarea class="form-control required" placeholder="Caption ..." rows="4" id="post-album-caption" style="resize: none"></textarea>
                <br>
                <button class="btn btn-success" id="btn-post-album" style="float: right" disabled>Post &nbsp; <i class="far fa-paper-plane"></i></button>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 col-lg-7">
        <div class="panel panel-headline">
            <div class="panel-heading">
                <h3 class="panel-title">Album</h3>
            </div>
            <div class="panel-body">
                <div class="panel-loader">
                    <div class="loader4"></div>
                </div>
                <ul class="list-unstyled activity-timeline custom-timeline" id="album-data">

                </ul>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUpdateAlbum" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" id="edit-album">
                <input type="hidden" id="edit-album-id">
                <div class="upload-images">
                    <img src="{{ asset('assets/images/grey.jpg') }}" class="image-preview post-album" id="edit-album-image-preview">
                    <span>400 x 400</span>
                    <button class="btn btn-warning choose-image">Choose poster</button>
                    <input type="file" class="choose-image-file" id="edit-album-image" style="display: none;">
                </div>
                <textarea class="form-control required" placeholder="Caption ..." rows="4" id="edit-album-caption" style="resize: none"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button id="btn-edit-album" type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteAlbum" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" style="margin-top: 3rem">Are you sure you want to delete this album ?</h4>
                <input type="hidden" id="delete-album-id">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-album">Delete</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection