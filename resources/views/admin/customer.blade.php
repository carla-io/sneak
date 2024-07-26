@extends('admin.layout.template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-4"><span class="text-muted fw-light">SneakTech /</span> Users </h4>
        <div class="card">
       
        <div class="mt-3">
        <h2> Users</h2>
        <table id="usersTable" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Active</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
      
</div>
</div>
    </div>



@endsection
