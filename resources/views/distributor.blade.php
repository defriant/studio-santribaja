@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">
        <!-- RECENT PURCHASES -->
        <div class="panel panel-headline">
            <div class="panel-loader">
                <div class="loader4"></div>
            </div>
            <div class="panel-heading">
                <h3 class="panel-title">Distributor</h3>
                <div class="right">
                    <button type="button" data-toggle="modal" data-target="#modalAdd"><i class="far fa-plus"></i>&nbsp; Add Distributor</button>
                </div>
            </div>
            <div class="panel-body">
                <table class="table" id="table-distributor">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Region</th>
                            <th>Instagram</th>
                            <th>Whatsapp</th>
                            <th>Address</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END RECENT PURCHASES -->
    </div>
</div>

<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Add Distributor</h4>
            </div>
            <div class="modal-body" id="add-data">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p>Name</p>
                        <input type="text" id="nama" class="form-control required">
                    </div>
                    <div class="col-12 col-md-6">
                        <p>Region</p>
                        <input type="text" id="wilayah" class="form-control required" placeholder="Kota / Kabupaten">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p>Instagram</p>
                        <input type="text" id="instagram" class="form-control required">
                    </div>
                    <div class="col-12 col-md-6">
                        <p>Whatsapp</p>
                        <input type="text" id="whatsapp" class="form-control required">
                    </div>
                </div>
                <br>
                <p>Address</p>
                <textarea class="form-control required" id="alamat" rows="3" style="resize: none"></textarea>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-add-data" disabled>Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Distributor</h4>
            </div>
            <div class="modal-body" id="edit-data">
                <input type="hidden" id="distributor-id">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p>Name</p>
                        <input type="text" id="nama" class="form-control required">
                    </div>
                    <div class="col-12 col-md-6">
                        <p>Region</p>
                        <input type="text" id="wilayah" class="form-control required" placeholder="Kota / Kabupaten">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <p>Instagram</p>
                        <input type="text" id="instagram" class="form-control required">
                    </div>
                    <div class="col-12 col-md-6">
                        <p>Whatsapp</p>
                        <input type="text" id="whatsapp" class="form-control required">
                    </div>
                </div>
                <br>
                <p>Address</p>
                <textarea class="form-control required" id="alamat" rows="3" style="resize: none"></textarea>
                <br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-edit-data" disabled>Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body" id="delete-data">
                <h4 class="text-center" style="margin-top: 3rem" id="delete-warning-message"></h4>
                <input type="hidden" id="distributor-id">
                <input type="hidden" id="nama">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="btn-delete-data">Hapus</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection