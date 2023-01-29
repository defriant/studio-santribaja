@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="panel panel-headline">
            <div class="panel-loader">
                <div class="loader4"></div>
            </div>
            <div class="panel-heading">
                <h3 class="panel-title">Mailbox</h3>
                <div class="right">
                    <button type="button" class="btn-right delete" id="btn-delete-mail" data-toggle="modal" data-target="#modalDeleteMailbox" disabled><i class="far fa-trash-alt"></i></button>
                    <button type="button" class="btn-right refresh" id="btn-refresh"><i class="fas fa-redo-alt"></i></button>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-mailbox" id="table-mailbox">
                    <thead style="visibility: hidden"></thead>
                    <tbody>
                        
                    </tbody>
                    <br>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-headline">
            <div class="panel-loader" id="loader-mailbox-data">
                <div class="loader4"></div>
            </div>
            <div class="panel-body">
                <div class="mailbox-data" id="mailbox-data">
                    <div class="null-data-wrapper">
                        <i class="far fa-info-circle"></i> <h4>Mailbox data</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDeleteMailbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="text-center" style="margin-top: 3rem">Delete selected mail ?</h4>
                <input type="hidden" id="delete-feed-id">
                <div style="margin-top: 5rem; text-align: center">
                    <button type="button" class="btn btn-danger" id="delete-mail">Hapus</button>
                    &nbsp;&nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection