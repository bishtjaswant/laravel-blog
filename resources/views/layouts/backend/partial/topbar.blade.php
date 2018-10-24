
<!-- Top Bar -->
<nav class="navbar">
    <div class="container-fluid">
        <div class="navbar-header">
            <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
            <a href="javascript:void(0);" class="bars"></a>

            @if( Request::is('admin.dashboard') && Request::is('author.dashboard') )
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Blog Panel <strong> {{ auth::user()->username }} </strong></a>

            @else

                <a class="navbar-brand" href="{{ route('author.dashboard') }}">Blog Panel <strong> {{ auth::user()->username }} </strong></a>

            @endif




        </div>
        <div class="collapse navbar-collapse" id="navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <!-- Call Search -->
                <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                <!-- #END# Call Search -->
            </ul>
        </div>
    </div>
</nav>