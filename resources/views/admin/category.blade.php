@extends('admin.layout.template')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">SneakTech /</span> Categories </h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
    
        <div class="col-lg-4 col-md-6">
            <div class="mt-3">
           
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title" id="modal-title">Add Category</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="ajaxForm">
                                <div class="modal-body">
                                    <input type="hidden" id="category_id">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Category Name</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                        <label id="name-error" class="error" for="name"></label>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description">
                                        <label id="decription-error" class="error" for="description"></label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveBtn">Save Category</button>
                                    <button type="button" class="btn btn-primary" id="updateBtn" style="display: none;">Update Category</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="container">
        <h2>Category List</h2>
            <table id="categoryTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection