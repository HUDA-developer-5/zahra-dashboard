<img src="{{  (auth('users')->user()->image)? auth('users')->user()->image_path : asset('frontend/assets/images/icons/profile-circle.svg') }}"
     alt="profile-img" loading="lazy">