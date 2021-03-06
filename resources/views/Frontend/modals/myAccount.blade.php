<div class="modal fade my_account_popup" id="myaccount" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">

                    <i class="far fa-user"></i>{{ __('My Account') }}
                </h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body display">
                <div class="col-md-12 col-12 custom_row">
                    <div class="col-md-4 col-12 box" style="cursor: pointer;">
                        <a data-toggle="modal" data-target="#mydetails" data-dismiss="modal">

                            <h4 class="head">{{ __('My details') }} <i class="fas fa-edit"></i> </h4>

                            <p>{{ __('Manage your account information here.') }}
                            </p>
                        </a>
                    </div>
                    <div class="col-md-4 col-12 box" style="cursor: pointer;">
                        <a data-toggle="modal" data-target="#personal" data-dismiss="modal">
                            <h4 class="head">{{ __('My message') }}<i class="far fa-comment-alt"></i>
                            </h4>

                            <p>{{ __('Read, send, and delete your messages here.') }}
                            </p>
                        </a>
                    </div>
                    <div class="col-md-4 col-12 box" style="cursor: pointer;">
                        <a data-toggle="modal" data-target="#myfavourites" data-dismiss="modal">
                            <h4 class="head">{{ __('Favourites') }}<i class="far fa-heart"></i></h4>

                            <p>{{ __('View and delete your saved favorites here.') }}
                            </p>
                        </a>
                    </div>
                </div>

                <div class="col-md-12 col-12 custom_row">
                    <div class="col-md-4 col-12 box" style="cursor: pointer;">
                        <a data-toggle="modal" data-target="#mypost" data-dismiss="modal">
                            <h4 class="head">{{ __('My posts') }}<i class="fas fa-edit"></i>
                            </h4>

                            <p>{{ __('View, Pause , Edit , publish and delete your post here') }}

                            </p>
                        </a>
                    </div>
                    <div class="col-md-4 col-12 box" style="cursor: pointer;">
                        <a data-toggle="modal" data-target="#privacy" data-dismiss="modal">
                            <h4 class="head">{{ __('My privacy') }}<img
                                    src="{{ asset('Frontend/img/insurance.png') }}" class="img-fluid">
                            </h4>

                            <p>{{ __('Manage your account privacy settings here.') }}
                            </p>
                        </a>
                    </div>
                    <div class="col-md-4 col-12 box" style="cursor: pointer;">
                        <a data-toggle="modal" data-target="#addcredit" data-dismiss="modal">
                            <h4 class="head">{{ __('Add credit') }}<i class="fas fa-credit-card"></i>
                            </h4>

                            <p>{{ __('Manage your pay-perclick account here') }}
                            </p>
                        </a>
                    </div>


                </div>
                <div class="col-md-12 col-12 custom_row">
                    <div class="col-md-4 col-12 box" style="cursor: pointer;">
                        <a data-toggle="modal" data-target="#getverified" data-dismiss="modal">
                            <h4 class="head">{{ __('Get verified') }}<i class="fas fa-check-circle"></i>
                            </h4>

                            <p>{{ __('Manage your account verification here.') }}
                            </p>
                        </a>
                    </div>
                    <div class="col-md-4 col-12 box" style="cursor: pointer;">
                        <a data-toggle="modal" data-target="#deleteaccount" data-dismiss="modal">
                            <h4 class="head">{{ __('Delete account') }}<i class="fas fa-trash"></i>
                            </h4>

                            <p>{{ __('Manage your account deletion here.') }}
                            </p>
                        </a>
                    </div>
                    <div class="col-md-4 col-12 box" style="cursor: pointer;">
                        <a
                            onclick="event.preventDefault();  (confirm('Are you sure you want to logout?')) ? document.getElementById('logout-form').submit():''">
                            <h4 class="head">Logout<i class="fas fa-sign-out-alt"></i></h4>

                            <p>{{ __('SignOut your account here.') }}
                            </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>


                </div>

            </div>
        </div>
    </div>
</div>
