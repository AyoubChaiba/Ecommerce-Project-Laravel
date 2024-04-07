@extends('admin.layout.app')

@section('title' , "Add category")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Create Category'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" enctype="multipart/form-data" id="category" name="category">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{old('name')}}">
                                    <p></p>
                                </div>
                                {{-- @error('name')
                                    <p class="text-red" >{{ $message }}</p>
                                @enderror --}}
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" value="{{old('slug')}}" readonly>
                                    <p></p>
                                </div>
                                {{-- @error('slug')
                                    <p class="text-red" >{{ $message }}</p>
                                @enderror --}}
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                            {{-- <div id="image" class="dropzone dz-clickable">
                                <div class="dz-message needsclick">
                                    <br>Drop files here or click to upload.<br><br>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" name="image" accept="image/png, image/jpeg">
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary" id="btn-submit">Create</button>
                    <a href="{{ route('category.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $(document).ready(function () {
            $('#btn-submit').prop('disabled', true);
            $("#category").submit(function(e){
                e.preventDefault();
                const category = $(this);
                $('#btn-submit').text('Loading ...');
                $.ajax({
                    url: "{{ route('category.store') }}",
                    method: "POST",
                    data: category.serializeArray(),
                    dataType: "json",
                    success: function(data){
                        if (!data['status']) {
                            $('#btn-submit').prop('disabled', true);
                            const { name , slug }  = data['errors'];
                            name ? $('#name').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(name)
                            : $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            slug ? $('#slug').addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(slug)
                            : $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        } else {
                            $('#name').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            $('#slug').removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            Swal.fire({
                                icon:'success',
                                title: data['message'],
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                didClose: () => {
                                    window.location.href = "{{ route('category.index') }}";
                                }
                            })
                            // category[0].reset();
                            // $('.dropzone').dropzone.removeAllFiles(true);
                        }
                    },
                    error: function(error){
                        console.log(error);
                    },
                    complete: function(){
                        $('#btn-submit').text('Create');
                        $('#btn-submit').prop('disabled', false);
                    }
                })
            })
            $("#name").change(function(e){
                $('#btn-submit').prop('disabled', false);
                const name = $(this).val();
                const slug = name.toLowerCase()
                    .replace(/\s+/g, '-')
                        .replace(/[^\w-]+/g, '')
                        .replace(/--+/g, '-')
                        .replace(/^-+/, '')
                        .replace(/-+$/, '');
                $("#slug").val(slug);
            })
        })
    </script>
@endsection

