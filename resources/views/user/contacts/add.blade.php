@extends("layouts.user.app")

@section('content')
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            @include('user.includes.message')
            <div class="border-0 shadow card">
                <div class="card-header">
                    <h3>Add Contact</h3>
                </div>
                <div class="card-body">
                    <form action="{{ url('user/contacts/add') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="user_name" class="form-label">Phone Number</label>
                            <input type="number" class="form-control" value="{{ Session::has('phone_number') ? Session::get('phone_number') : '' }}" id="user_name" val placeholder="Enter phone number" name="phone_number" autocomplete="off" required>
                        </div>

                        <div class="mb-3 d-flex justify-content-end">
                            <button type="submit" class="float-right btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).on("click", ".upload-picture-button", function(){
            $("#profile_image").click();
        });

        $(document).on("change", "#profile_image", function(event){
            const uploadedImagePath = URL.createObjectURL(event.target.files[0])
            const imageHtml = `<img src="${uploadedImagePath}" alt="">`;
            $(".profile-image-box").html(imageHtml)
        })

    </script>
@endsection
