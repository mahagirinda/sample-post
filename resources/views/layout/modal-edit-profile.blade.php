<div class="modal fade" id="edit-profile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data"
                      autocomplete="off" id="edit-user-form">

                    @csrf

                    @method('PUT')

                    <input type="hidden" name="id" value="{{ old('id', $user->id) }}">

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name"
                               value="{{ old('name', $user->name) }}">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                               value="{{ old('email', $user->email) }}" disabled>
                        <small>Contact Admin to Update Your Email</small>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Profile Image (Optional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                               name="image">
                        @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Password (Optional)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password"
                                   value="" autocomplete="new-password">
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Password Confirmation</label>
                            <input type="text" class="form-control @error('password_confirmation') is-invalid @enderror"
                                   id="password_confirmation" name="password_confirmation"
                                   value="">
                            @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button"
                        class="btn btn-primary"
                        onclick="event.preventDefault(); document.getElementById('edit-user-form').submit();">
                    Update
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
