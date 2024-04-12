@extends('admin.layout.app')

@section('title', 'Create product')

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Create Products'])
    <section class="content">
        <div class="container-fluid">
            <form action="" method="POST" id="product" name="product">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="slug">slug</label>
                                            <input type="text" name="slug" id="slug" class="form-control" placeholder="slug" readonly>
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="description">Description</label>
                                            <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description"></textarea>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="mb-3" id="gallery-image">
                                    <label for="image">image</label>
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Pricing</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" class="form-control" placeholder="Price">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="compare_price">Compare at Price</label>
                                            <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price">
                                            <p class="text-muted mt-3">
                                                To show a reduced price, move the product’s original price into Compare at price. Enter a lower value into Price.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Inventory</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="sku">SKU (Stock Keeping Unit)</label>
                                            <input type="text" name="sku" id="sku" class="form-control" placeholder="sku">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="barcode">Barcode</label>
                                            <input type="text" name="barcode" id="barcode" class="form-control" placeholder="Barcode">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox">
                                                <input type="hidden" id="track_qty" name="track_qty" value="Yes">
                                                <input class="custom-control-input" type="checkbox" id="track_checked" checked>
                                                <label for="track_checked" class="custom-control-label">Track Quantity</label>
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <input type="number" min="0" name="qty" id="qty" class="form-control" placeholder="Qty">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product status</h2>
                                <div class="mb-3">
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="h4  mb-3">Product category</h2>
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="category" id="category" class="form-control">
                                        <option value="">selecte a category</option>
                                        @foreach ($categorys as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <p></p>
                                </div>
                                <div class="mb-3">
                                    <label for="category">Sub category</label>
                                    <select name="sub_category" id="sub_category" class="form-control">
                                        <option value="">selecte a sub category</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Product brand</h2>
                                <div class="mb-3">
                                    <select name="brand" id="status" class="form-control">
                                        <option value="">selecte a brand</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3">
                            <div class="card-body">
                                <h2 class="h4 mb-3">Featured product</h2>
                                <div class="mb-3">
                                    <select name="is_featured" id="status" class="form-control">
                                        <option value="No">No</option>
                                        <option value="Yes">Yes</option>
                                    </select>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary" id="btn-submit">Create</button>
                    <a href="{{ route("products.index") }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@section('customJS')
    <script>
        $('#track_checked').click(function () {
            const isChecked = $(this).is(':checked');
            $('#track_qty').val(isChecked ? 'Yes' : 'No');
            $('#qty').prop('disabled', !isChecked);
        });

        $('.summernote').summernote({
            height: '300px'
        });

        $('#category').change(function (){
            const category_id = $(this).val();
            if(category_id){
                $.ajax({
                    url: "{{ route('get.subcategory') }}",
                    method: "GET",
                    data: {category_id: category_id},
                    success: function(res){
                        console.log(res);
                        if(res){
                            $('#sub_category').find('option').not(':first').remove();
                            $.each(res, function(key, value){
                                $('#sub_category').append('<option value="'+ value.id +'">'+ value.name +'</option>');
                            });
                        }else{
                            $('#sub_category').find('option').not(':first').remove();
                        }
                    }
                })
            }else{
                $('#sub_category').find('option').not(':first').remove();
            }
        })

        $("#product").submit(function(e){
            e.preventDefault();
            const products = $(this);
            $('#btn-submit').text('Loading ...');
            $.ajax({
                url: "{{ route('products.store') }}",
                method: "POST",
                data: products.serializeArray(),
                dataType: "json",
                success: function(data){
                    if (!data.status) {
                        // $('#btn-submit').prop('disabled', true);
                        ['title', 'slug', 'price', 'sku', 'track_qty', 'category', 'is_featured', 'qty'].forEach(element => {
                            const error = data.errors[element];
                            if (error) {
                                $(`#${element}`).addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(error);
                            } else {
                                $(`#${element}`).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                            }
                        });
                    } else {
                        ['title', 'slug', 'price', 'sku', 'track_qty', 'category', 'is_featured', 'qty'].forEach(element => {
                            $(`#${element}`).removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html("");
                        });
                        Swal.fire({
                            icon: 'success',
                            title: data['message'],
                            showConfirmButton: false,
                            timer: 500,
                            timerProgressBar: true,
                            didClose: () => {
                                window.location.href = "{{ route('products.index') }}";
                            }
                        });
                    }
                },
                error: function(error){
                    console.log(error);
                },
                complete: function(){
                    $('#btn-submit').text('Create');
                }
            })
        })
        $("#title").change(function(e){
            const name = $(this).val();
            const slug = name.toLowerCase()
                .replace(/\s+/g, '-')
                    .replace(/[^\w-]+/g, '')
                    .replace(/--+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
            $("#slug").val(slug);
        })
        Dropzone.autoDiscover = false;
        const dropzone = new Dropzone("#image", {
            url: "{{ route('temp-image') }}",
            maxFiles: 10,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                const img = document.createElement('input');
                img.type = 'hidden';
                img.name = 'images_id[]';
                img.value = response.image_id;
                img.setAttribute('data-img', file.name);
                $("#gallery-image").append(img);
            },
            removedfile: function(file) {
                const imgId = $(`[data-img="${file.name}"]`).data('img');
                if (imgId) {
                    $(`input[data-img="${imgId}"]`).remove();
                }
                $(file.previewElement).remove();
            }
        });

    </script>
@endsection
