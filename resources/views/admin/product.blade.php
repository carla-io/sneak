@extends('admin.layout.template')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">SneakTech /</span> Products</h4>
    <!-- Basic Bootstrap Table -->
    <div class="card">
    
        <div class="col-lg-4 col-md-6">
            <div class="mt-3">
           
          <!-- Import Button -->
          <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal">
                    Import Products
                </button>

            <!-- Import Modal -->
            <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="importModalLabel">Import Products</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="importForm"  method="POST" enctype="multipart/form-data" >
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="import_file" class="form-label">Upload Excel File</label>
                                        <input type="file" class="form-control" id="import_file" name="file" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="productForm">
                <div class="modal-body">
                <input type="hidden" id="product_id">
                    <div class="mb-3">
                        <label for="product_name" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="product_name" name="product_name">
                        <label id="product_name-error" class="error" for="product_name"></label>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price">
                        <label id="price-error" class="error" for="price"></label>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <label id="category_id-error" class="error" for="category_id"></label>
                    </div>
                    <div class="form-group mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveProductBtn">Save Product</button>
                    <button type="submit" class="btn btn-primary" id="updateProductBtn">Update Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
            </div>
        </div>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="container">
        <h2>Product List</h2>
            <table id="productTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Category</th>
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


@endsection
