@extends('admin.layout.app')

@section('title', 'Edit sub categories')

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Edit Sub Category'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="sub-category" name="sub-category">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category_id" id="category_id" class="form-control">
                                        @foreach ($categorys as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $subCategory->name }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" readonly value="{{ $subCategory->slug }}">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{  $subCategory->status == 1 ? "selected" : "" }} value="1">Active</option>
                                        <option {{  $subCategory->status == 0 ? "selected" : "" }} value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('category.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $('#btn-submit').prop('disabled', true);
        $("#sub-category").submit(function(e){
            e.preventDefault();
            const sub_category = $(this);
            $('#btn-submit').text('Loading ...');
            $.ajax({
                url: "{{ route('sub-category.update',$subCategory->id) }}",
                method: "PUT",
                data: sub_category.serializeArray(),
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
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = "{{ route('sub-category.index') }}";
                            }
                        })
                    }
                },
                error: function(error){
                    console.log(error);
                },
                complete: function(){
                    $('#btn-submit').text('Update');
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
    </script>
@endsection