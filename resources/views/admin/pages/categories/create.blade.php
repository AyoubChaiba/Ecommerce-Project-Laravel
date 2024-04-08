@extends('admin.layout.app')

@section('title' , "Add category")

@section('main')
<div class="content-wrapper">
    @include("admin.partiels.content-header",['text' => 'Create Category'])
    <section class="content">
        <div class="container-fluid">
            <form method="POST" id="category" name="category">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" >
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug" readonly>
                                    <p></p>
                                </div>
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
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">image</label>
                                    <input type="hidden" id="image_id" name="image_id" value="">
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url:  "{{ route('temp-image') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, success: function(file, response){
                $("#image_id").val(response.image_id);
                //console.log(response)
            }
        });
    </script>
@endsection

