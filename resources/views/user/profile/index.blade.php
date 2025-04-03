@extends("layouts.user.app")

@section('content')
    <div class="border-0 shadow card">
        <div class="card-header">
            <h3>Profile Information</h3>
        </div>
        <div class="card-body">
            <form action="{{ url('user/profile/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-3 mb-3 d-flex justify-content-center">
                    <div class="profile-image-box">
                        <img src="{{ asset(Auth::user()->image ?? 'chat-assets/images/default.png') }}" alt="">
                    </div>
                </div>
                <div class="text-center">
                    <button type="button" class="text-center btn btn-warning upload-picture-button">Upload Picture</button>
                </div>

                <div class="mb-3 d-none">
                    <label for="email" class="form-label">Upload Picture:</label>
                    <input type="file" class="form-control" accept="image/*" name="image" id="profile_image">
                </div>
                <div class="mb-3">
                    <label for="user_name" class="form-label">Display Name:</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->name ?? '' }}" id="user_name" val placeholder="Enter name" name="name">
                </div>
                <div class="mb-3">
                    <label for="user_name" class="form-label">Phone Number:</label>
                    <input type="text" class="form-control" value="{{ Auth::user()->phone_number ?? '' }}" id="user_name" readonly disabled val placeholder="Enter name" name="name">
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <button type="submit" class="float-right btn btn-primary">Save</button>
                </div>
            </form>
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
