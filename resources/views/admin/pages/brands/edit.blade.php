@extends('admin.layout.mastar')

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Edit brands'])
    <section class="content">
        <form action="{{ route('brands.update',$brand->id) }}" method="POST" class="container-fluid">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{old('name',$brand->name)}} ">
                            </div>
                            @error('name')
                                <p class="text-red" >{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{old('slug',$brand->slug)}} ">
                            </div>
                            @error('slug')
                                <p class="text-red" >{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="1" @if($brand->status == 1) selected @endif>Active</option>
                                    <option value="0" @if($brand->status == 0) selected @endif>Block</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('brands.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@endsection
