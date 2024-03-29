@extends('layouts.app')



@section('content')

<style>
    .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .btn {
            border: 2px solid #3498db;
            color: #3498db;
            background-color: #fff;
            padding: 8px 20px;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background-color: #3498db;
            color: #fff;
        }

        /* Hide the input element */
        .upload-btn-wrapper input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }

        /* Optional: Style the filename text */
        .file-name {
            margin-left: 10px;
        }
</style>
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('upload.json') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="upload-btn-wrapper">
                    <button class="btn">Choose JSON File</button>
                    <input type="file" name="json_file" id="json_upload" accept=".json">
                    <span class="file-name"></span>

                </div>
                <button id="submit_btn" class="btn btn-primary" type="submit">Upload </button>
            </form>


        </div>
        <div class="col-md-6"></div>
        <div class="col-md-2">
            <form action="/user-data" method="get">
                <button class="btn btn-success"> Export</button>
            </form>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            @php($i = 1)
            @foreach ($users as $user)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->address}}</td>
                </tr>

            @endforeach
        </tbody>
    </table>

</div>

<script>
    document.querySelector('input[type="file"]').addEventListener('change', function (e) {
        var fileName = e.target.files[0].name;
        document.querySelector('.file-name').textContent = fileName;
    });

</script>
@endsection
