@extends('admin.layout.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">SneakTech /</span> Suppliers </h4>
    <div class="card">
        <div class="col-lg-4 col-md-6">
            <div class="mt-3">
                <div class="modal fade" id="supplierModal" tabindex="-1" aria-labelledby="supplierModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title" id="modal-title">Add Supplier</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="supplierForm">

                                <div class="modal-body">
                                    <input type="hidden" id="supplier_id" name="supplier_id">

                                    <div class="form-group mb-3">
                                        <label for="supplier_name" class="form-label">Supplier Name</label>
                                        <input type="text" class="form-control" id="supplier_name" name="supplier_name">
                                        <label id="supplier_name-error" class="error" for="supplier_name"></label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="contact_name" class="form-label">Contact Name</label>
                                        <input type="text" class="form-control" id="contact_name" name="contact_name">
                                        <label id="contact_name-error" class="error" for="contact_name"></label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="email" name="email">
                                        <label id="email-error" class="error" for="email"></label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="supplier_phone" class="form-label">Supplier Phone</label>
                                        <input type="text" class="form-control" id="supplier_phone" name="supplier_phone">
                                        <label id="supplier_phone-error" class="error" for="supplier_phone"></label>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address" name="address">
                                        <label id="address-error" class="error" for="address"></label>
                                    </div>
                                    <div class="form-group mb-3">
                                      <label for="supplier_image" class="form-label">Supplier Image</label>
                                      <input type="file" class="form-control" id="supplier_image" name="image">
                                   </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveSupplierBtn">Save Supplier</button>
                                    <button type="button" class="btn btn-primary" id="updateSupplierBtn" style="display: none;">Update Supplier</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="container">
                <h2>Supplier List</h2>
                <table id="supplierTable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Supplier Name</th>
                            <th>Contact Name</th>
                            <th>Email</th>
                            <th>Supplier Phone</th>
                            <th>Address</th>
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
