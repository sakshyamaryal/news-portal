<nav class="navbar navbar-expand-lg navbar-light fixed-top">
    <button id="sidebarCollapse" class="mr-3 btn btn-outline-primary">
        <i class="fa fa-arrow-right" aria-hidden="true"></i>
    </button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span class="navbar-brand"> Dashboard</span>

    <div class="profile-section">
        <div class="dropdown">
            <span>Welcome {{ auth()->user()->name }}</span>

            <button class="btn btn-light dropdown-toggle" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('storage/default.jpg') }}" alt="Profile Image" class="profile-img mr-2">
            </button>
            <div class="dropdown-menu" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="{{ route('profile.show') }}">My Profile</a> 
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>

<br>

<!-- Profile Image Styles -->
<style>
    .profile-img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        object-fit: cover;
    }
</style>

<script>
    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').toggleClass('collapsed');
            $('.content').toggleClass('full-width');
        });

        $('.nav-link[data-toggle="collapse"]').on('click', function() {
            const target = $(this).attr('data-target');
            $(target).collapse('toggle');
        });

        $('.nav-link').on('click', function() {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');
        });
    });
</script>
