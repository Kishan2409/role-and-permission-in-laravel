    <!-- Main content -->
    <section class="content">

        <div class="card card-danger">
            <div class="card-header">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <h3 class="card-title"> {{ __('Delete Account') }}</h3>
                </button>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>


                </div>
            </div>

            <div class="card-body">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </br>
                <button type="button" class="btn btn-danger mt-3" data-toggle="modal" data-target="#staticBackdrop">
                    {{ __('Delete Account') }}
                </button>
            </div>

        </div>

        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">
                            {{ __('Are you sure you want to delete your account?') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="profiledestroy" method="post" action="{{ route('profile.destroy') }}" class="p-6">
                        @csrf
                        @method('delete')
                        <div class="modal-body">

                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            <div class="mt-3">
                                <label for="password">{{ __('Password') }}<span class="text-danger ">*</span></label>

                                <input id="password" name="password" type="password" class="mt-1 form-control "
                                    placeholder="{{ __('Password') }}">

                            </div>

                        </div>
                        <div class="modal-footer">
                            <div class="mt-6 flex justify-end">
                                {{-- <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal">{{ __('Cancel') }}</button> --}}
                                <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
