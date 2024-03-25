@extends('admin.layout.mastar')

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Edit Sub Category'])
    <section class="content">
        <form action="{{ route('sub-category.edit',$subCategory->id) }}" method="POST" enctype="multipart/form-data" class="container-fluid">
            @csrf
            @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        @foreach ($categorys as $category)
                                            <option value="{{ $category->id }}" @if( $category->id == $subCategory->category_id) selected @endif>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Slug</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{old('name',$subCategory->name)}} ">
                                </div>
                                @error('name')
                                    <p class="text-red" >{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{old('slug', $subCategory->slug)}} ">
                                </div>
                                @error('slug')
                                    <p class="text-red" >{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1" @if($subCategory->status == 1) selected @endif>Active</option>
                                        <option value="0" @if($subCategory->status == 0) selected @endif>Block</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" id="image" name="image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('sub-category.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
