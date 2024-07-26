@extends('admin.layout.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">SneakTech /</span> Shippers </h4>
    <div class="card">
        <div class="col-lg-4 col-md-6">
            <div class="mt-3">
                <div class="modal fade" id="shipperModal" tabindex="-1" aria-labelledby="shipperModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="modal-title">Add Shipper</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="shipperForm">
                                <div class="modal-body">
                                    <input type="hidden" id="shipper_id" name="shipper_id">
                                    <div class="form-group mb-3">
                                        <label for="shipper_name" class="form-label">Shipper Name</label>
                                        <input type="text" class="form-control" id="shipper_name" name="shipper_name" placeholder="name">
                                        <label id="shipper_name-error" class="error" for="shipper_name"></label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="shipper_contact" class="form-label">Shipper Contact Number</label>
                                        <input type="text" class="form-control" id="shipper_contact" name="shipper_contact" placeholder="+63">
                                        <label id="shipper_contact-error" class="error" for="shipper_contact"></label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="shipper_address" class="form-label">Shipper Address</label>
                                        <input type="text" class="form-control" id="shipper_address" name="shipper_address" placeholder="address">
                                        <label id="shipper_address-error" class="error" for="shipper_address"></label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="image" class="form-label">Shipper Image</label>
                                        <input type="file" class="form-control" id="image" name="image">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveShipperBtn">Save Shipper</button>
                                    <button type="button" class="btn btn-primary" id="updateShipperBtn" style="display: none;">Update Shipper</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="container">
                <h2>Shipper List</h2>
                <table id="shipperTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Shipper Name</th>
                            <th>Shipper Contact Number</th>
                            <th>Shipper Address</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
