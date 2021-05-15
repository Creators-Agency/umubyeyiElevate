@extends('layouts/wrapper')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-user">
                <div class="card-header">
                    <h5 class="card-title">Add Category</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('CreateCategory') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 pr-1">
                                <div class="form-group">
                                    <label>Category Name</label>
                                    <input type="text" name="categoryName" class="form-control"
                                        placeholder="Category Name">
                                </div>
                            </div>
                            <div class="col-md-6 px-1">
                                <div class="form-group">
                                    <label>Parent Category</label>
                                    <select name="parent" class="form-control">
                                        <option value="0">None</option>
                                        <option value="parent Id">parent name</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>About Me</label>
                                    <textarea name="categoryDescription"
                                        class="form-control textarea summernote"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="update ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary btn-round">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection